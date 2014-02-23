<?php

use Windwalker\Model\AdminModel;

/**
 * Class CsiModelNotify
 *
 * @since 1.0
 */
class CsiModelNotify extends AdminModel
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
