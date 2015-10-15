<?php
/**
 * @package     Joomla.Cli
 * @subpackage  JConsole
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Command\Queue;

use Csi\Component\TaskMapper;
use JConsole\Command\JCommand;
use Windwalker\Controller\Resolver\ControllerResolver;
use Windwalker\DI\Container;
use Windwalker\Event\ListenerHelper;
use Windwalker\Helper\AssetHelper;
use Windwalker\Joomla\DataMapper\DataMapper;

defined('JCONSOLE') or die;

/**
 * Class Queue
 *
 * @package     Joomla.Cli
 * @subpackage  JConsole
 *
 * @since       3.2
 */
class Queue extends JCommand
{
	/**
	 * An enabled flag.
	 *
	 * @var bool
	 */
	public static $isEnabled = true;

	/**
	 * Console(Argument) name.
	 *
	 * @var  string
	 */
	protected $name = 'queue';

	/**
	 * The command description.
	 *
	 * @var  string
	 */
	protected $description = 'Execute Queues';

	/**
	 * The usage to tell user how to use this command.
	 *
	 * @var string
	 */
	protected $usage = 'queue <cmd><command></cmd> <option>[option]</option>';

	/**
	 * Property queue.
	 *
	 * @var  \Windwalker\Data\Data
	 */
	protected $queue = null;

	/**
	 * Property queueMapper.
	 *
	 * @var  DataMapper
	 */
	protected $queueMapper = null;

	/**
	 * Property pk.
	 *
	 * @var  int
	 */
	protected $pk = null;

	/**
	 * Property resolver.
	 *
	 * @var object
	 */
	protected $resolver;

	/**
	 * Configure command information.
	 *
	 * @return void
	 */
	public function configure()
	{
		define('JPATH_COMPONENT', JPATH_ADMINISTRATOR . '/components/com_csi');
		define('JPATH_COMPONENT_ADMINISTRATOR', JPATH_ADMINISTRATOR . '/components/com_csi');

		// $this->addCommand();
		include JPATH_ADMINISTRATOR . '/components/com_csi/src/init.php';

		define('CSI_ADMIN', JPATH_COMPONENT_ADMINISTRATOR);

		ListenerHelper::registerListeners(
			'Csi',
			Container::getInstance()->get('event.dispatcher'),
			JPATH_COMPONENT_ADMINISTRATOR . '/src/Csi/Listener'
		);

		parent::configure();
	}

	/**
	 * Execute this command.
	 *
	 * @return int|void
	 */
	protected function doExecute()
	{
		$_SERVER['HTTP_HOST'] = 'console';

		$sleep = $this->getArgument(0, 5);

		$this->queueMapper = $mapper = new DataMapper('#__csi_queues');

		$this->resolver = TaskMapper::register(new ControllerResolver(new \JApplicationCms, Container::getInstance()));

		\JLog::addLogger(
			array('text_file' => 'queue.errors.php'),
			\JLog::ALL,
			array('queue')
		);

		while (true)
		{
			try
			{
				$this->executeQueue();
			}
			catch (\Exception $e)
			{
				$this->renderException($e);

				\JLog::add($e->getMessage(), \JLog::ERROR, 'queue');
			}

			sleep($sleep);
		}
	}

	/**
	 * executeQueue
	 *
	 * @throws \Exception
	 * @return mixed
	 */
	protected function executeQueue()
	{
		$this->queue = $this->queueMapper->findOne(array('state' => 1), 'priority DESC, id');

		if (!(array) $this->queue)
		{
			$this->application->close('No queue found.');
		}

		/** @var $db \JDatabaseDriver */
		$db = \JFactory::getDbo();

		$this->out(sprintf('Execute Queue. id: %s, task: %s', $this->queue->id, $this->queue->task));

		try
		{
			$db->transactionStart(true);

			// Set processing
			$this->queue->state = 2;

			$this->queueMapper->updateOne($this->queue);

			// Do task
			// $result = $this->fetch('Csi', $this->queue->task, array('id' => $this->queue->id));
			$controller = $this->resolver->getController('Csi', $this->queue->task, new \JInput(array('id' => $this->queue->id)));

			$result = $controller
				->setContainer(Container::getInstance())
				->execute();

			// Set finished
			$this->queue->state = 3;

			$this->queueMapper->updateOne($this->queue);
		}
		catch (\Exception $e)
		{
			$db->transactionRollback(true);

			// Set closed
			$this->queue->state = 0;

			$this->queueMapper->updateOne($this->queue);

			throw $e;
		}

		$db->transactionCommit(true);

		$this->out($result)->out();
	}
}
