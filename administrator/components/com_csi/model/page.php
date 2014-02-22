<?php

use Windwalker\Model\AdminModel;

/**
 * Class CsiModelPage
 *
 * @since 1.0
 */
class CsiModelPage extends AdminModel
{
	/**
	 * Method to set new item ordering as first or last.
	 *
	 * @param   JTable $table    Item table to save.
	 * @param   string $position 'first' or other are last.
	 *
	 * @return  void
	 */
	public function setOrderPosition($table, $position = 'last')
	{
		parent::setOrderPosition($table, $position);
	}
}
