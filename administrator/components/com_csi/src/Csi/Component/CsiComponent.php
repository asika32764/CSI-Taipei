<?php

namespace Csi\Component;

use Csi\Provider\CsiProvider;
use Windwalker\Component\Component;
use Windwalker\Debugger\Debugger;
use Windwalker\Helper\LanguageHelper;
use Windwalker\Helper\ProfilerHelper;

// No direct access
defined('_JEXEC') or die;

/**
 * Class CsiComponent
 *
 * @since 1.0
 */
abstract class CsiComponent extends Component
{
	/**
	 * Property name.
	 *
	 * @var string
	 */
	protected $name = 'Csi';

	/**
	 * prepare
	 *
	 * @return  void
	 */
	protected function prepare()
	{
		if (JDEBUG)
		{
			Debugger::registerWhoops();
		}

		// Register provider
		$this->container->registerServiceProvider(new CsiProvider);

		// Load language
		$lang = $this->container->get('language');

		LanguageHelper::loadAll($lang->getTag(), $this->option);

		// Load asset
		$asset = $this->container->get('helper.asset');

		$asset->windwalker();

		parent::prepare();
	}

	/**
	 * postExecute
	 *
	 * @param mixed $result
	 *
	 * @return  mixed
	 */
	protected function postExecute($result)
	{
		// Debug profiler
		if (JDEBUG)
		{
			$result .= "<hr />" . ProfilerHelper::render('Windwalker', true);
		}

		return parent::postExecute($result);
	}
}
