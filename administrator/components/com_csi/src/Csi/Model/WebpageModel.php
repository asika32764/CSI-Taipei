<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Model;

use Csi\Config\Config;
use Csi\Engine\AbstractEngine;
use Csi\Webometrics\AbstractWebometrics;
use Windwalker\Model\AdminModel;

/**
 * The WebpageModel class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class WebpageModel extends AdminModel
{
	/**
	 * Property prefix.
	 *
	 * @var  string
	 */
	protected $prefix = 'csi';

	/**
	 * Property option.
	 *
	 * @var  string
	 */
	protected $option = 'com_csi';

	/**
	 * Property textPrefix.
	 *
	 * @var string
	 */
	protected $textPrefix = 'COM_CSI';

	/**
	 * Property viewItem.
	 *
	 * @var  string
	 */
	protected $viewItem = 'webpage';

	/**
	 * Property viewList.
	 *
	 * @var  string
	 */
	protected $viewList = 'webpages';

	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'webpage';

	/**
	 * Prepare and sanitise the table data prior to saving.
	 *
	 * @param   \JTable  $table  A reference to a JTable object.
	 *
	 * @return  void
	 */
	protected function prepareTable(\JTable $table)
	{
		parent::prepareTable($table);

		if ($table->url)
		{
			$counts = $this->countWebometrics($table->url);

			$table->count = array_sum($counts);

			$table->params = array('counts' => $counts);
		}
	}

	/**
	 * countWebometrics
	 *
	 * @param string $url
	 *
	 * @return  array
	 */
	public function countWebometrics($url)
	{
		$engines = Config::get('engines', array());

		$results = array();

		foreach ($engines as $engineName)
		{
			$webo = AbstractWebometrics::getInstance($engineName, AbstractEngine::getInstance($engineName));

			$results[$engineName] = $webo->getWebometrics($url);
		}

		return $results;
	}

	/**
	 * Method to set new item ordering as first or last.
	 *
	 * @param   \JTable $table    Item table to save.
	 * @param   string $position 'first' or other are last.
	 *
	 * @return  void
	 */
	public function setOrderPosition($table, $position = 'last')
	{
		parent::setOrderPosition($table, $position);
	}
}
 