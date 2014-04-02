<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.Astra
 *
 * @copyright   Copyright (C) 2008 - 2012 Asikart, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


/**
 * Panel helper.
 */
class AstraHelperPanel
{
	
	/*
	 * function startPane
	 * @param 
	 */
	
	public static function startTabs($selector = 'myTab', $params = array())
	{
		if( JVERSION >= 3 ) {
			return JHtml::_('bootstrap.startPane', $selector, $params );
		}else{
			return JHtml::_('tabs.start', $selector, $params);
		}
	}
	
	
	/*
	 * function endTabs
	 * @param 
	 */
	
	public static function endTabs()
	{
		if( JVERSION >= 3 ) {
			return JHtml::_('bootstrap.endPane' );
		}else{
			return JHtml::_('tabs.end');
		}
	}
	
	
	/*
	 * function addPane
	 * @param 
	 */
	
	public static function addPanel($selector, $text, $id)
	{
		if( JVERSION >= 3 ) {
			return JHtml::_('bootstrap.addPanel', $selector, $id );
		}else{
			return JHtml::_('tabs.panel', $text, $id);
		}
	}
	
	
	/*
	 * function endPanel
	 * @param arg
	 */
	
	public static function endPanel()
	{
		if( JVERSION >= 3 ) {
			return JHtml::_('bootstrap.endPanel' );
		}
	}
	
	
	
	/*
	 * function startSlider
	 * @param $selector
	 */
	
	public static function startSlider($selector = 'mySlider', $params = array())
	{
		if( JVERSION >= 3 ) {
			return JHtml::_('bootstrap.startAccordion', $selector, $params );
		}else{
			return JHtml::_('sliders.start', $selector, $params);
		}
	}
	
	
	/*
	 * function endSlider
	 * @param 
	 */
	
	public static function endSlider()
	{
		if( JVERSION >= 3 ) {
			return JHtml::_('bootstrap.endAccordion' );
		}else{
			return JHtml::_('sliders.end');
		}
	}
	
	
	
	/*
	 * function addSlide
	 * @param 
	 */
	
	public static function addSlide($selector, $text, $id)
	{
		if( JVERSION >= 3 ) {
			return JHtml::_('bootstrap.addSlide', $selector, $text, $id );
		}else{
			return JHtml::_('sliders.panel', $text, $id);
		}
	}
	
	
	/*
	 * function endSlide
	 * @param 
	 */
	
	public static function endSlide()
	{
		if( JVERSION >= 3 ) {
			return JHtml::_('bootstrap.endSlide' );
		}
	}
}
