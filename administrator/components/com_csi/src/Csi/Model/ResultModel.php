<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Model;

use Csi\Config\Config;
use Csi\Table\Table;
use Windwalker\Data\Data;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class PageModel
 *
 * @since 1.0
 */
class ResultModel extends \JModelDatabase
{
	/**
	 * getPageResults
	 *
	 * @return  array
	 */
	public function getPageResults()
	{
		$pageIds = $this->state->get('page.ids', array());

		$results = with(new DataMapper(Table::RESULTS))->find(array('type' => 'page', 'fk' => $pageIds));

		$resultFields = $this->getResultFields();

		// Re build result set
		$resultSet = array();

		foreach ($results as $result)
		{
			if (empty($resultSet[$result->fk]))
			{
				$resultSet[$result->fk] = new Data;
			}

			if (!in_array($result->key, $resultFields))
			{
				continue;
			}

			$resultSet[$result->fk]->{$result->key} = $result;
		}

		return $resultSet;
	}

	/**
	 * getResultFields
	 *
	 * @param string $database
	 *
	 * @return  array
	 */
	public function getResultFields($database = null)
	{
		$database = $database ? : $this->state->get('task.database');

		return (array) Config::get('database.' . $database . '.page_result_fields');
	}
}
 