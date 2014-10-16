<?php
/**
 * @package     Joomla.Cli
 * @subpackage  JConsole
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Command\Csi\Import;

use JConsole\Command\JCommand;
use Windwalker\Data\Data;
use Windwalker\Data\DataSet;
use Windwalker\Helper\DateHelper;
use Windwalker\Joomla\DataMapper\DataMapper;

defined('JCONSOLE') or die;

/**
 * Class Import
 *
 * @package     Joomla.Cli
 * @subpackage  JConsole
 *
 * @since       3.2
 */
class Import extends JCommand
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
	protected $name = 'import';

	/**
	 * The command description.
	 *
	 * @var  string
	 */
	protected $description = 'Import schools';

	/**
	 * The usage to tell user how to use this command.
	 *
	 * @var string
	 */
	protected $usage = 'import <cmd><command></cmd> <option>[option]</option>';

	/**
	 * Configure command information.
	 *
	 * @return void
	 */
	public function configure()
	{
		// $this->addCommand();

		include_once JPATH_LIBRARIES . '/windwalker/src/init.php';

		parent::configure();
	}

	/**
	 * Execute this command.
	 *
	 * @return int|void
	 */
	protected function doExecute()
	{
		// $this->setRef();

		return true;
	}

	protected function setRef()
	{
		$mapper = new DataMapper('#__csi_schools');

		$schools = $mapper->findAll();

		$nickSet = new DataSet;

		foreach ($schools as $school)
		{
			$nicks = (array) json_decode($school->nick);

			foreach ($nicks as $nick)
			{
				$data = new Data;

				$data->parent_id = $school->id;

				$data->title = $nick;

				$nickSet[] = $data;
			}
		}

		$mapper->create($nickSet);
	}

	protected function importSchools()
	{
		$csv = file_get_contents(__DIR__ . '/schools-utf8.csv');

		$csv = explode("\n", trim($csv));

		$csv = array_map('str_getcsv', $csv);

		$dataset = new DataSet;

		$date = DateHelper::getDate('now');

		foreach ($csv as $school)
		{
			$data = new Data;

			$data->parent_id = 0;

			$data->title = $school[0];
			$data->tel = $school[1];
			$data->fax = $school[2];
			$data->address = $school[3];
			$data->url = $school[4];
			$data->nick = $school[5];

			$data->created = $date->toSql(true);

			$data->nick = json_encode(explode('、', $data->nick));

			$dataset[] = $data;
		}

		(new DataMapper('#__csi_schools'))->create($dataset);
	}
}
