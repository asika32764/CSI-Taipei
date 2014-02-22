<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_akquickicons
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
JHtml::_('behavior.framework', true);

$lang		= JFactory::getLanguage();
$lang_code 	= $lang->getTag();
$lang_code 	= str_replace('-', '_', $lang_code) ;


if( JVERSION >= 3 ){
	JHtml::_('jquery.framework');
	$doc->addStylesheet( 'components/com_akquickicons/includes/jquery-ui/css/smoothness/jquery-ui-1.8.24.custom.css' );
	//$doc->addscript( 'components/com_akquickicons/includes/jquery-ui/js/jquery-1.7.2.min.js' );
	$doc->addscript( 'components/com_akquickicons/includes/jquery-ui/js/jquery-ui-1.8.24.custom.min.js' );
}else{
	$doc->addStylesheet( 'components/com_akquickicons/includes/jquery-ui/css/smoothness/jquery-ui-1.8.24.custom.css' );
	$doc->addscript( 'components/com_akquickicons/includes/jquery-ui/js/jquery-1.7.2.min.js' );
	$doc->addscript( 'components/com_akquickicons/includes/jquery-ui/js/jquery-ui-1.8.24.custom.min.js' );
	//$doc->addScriptDeclaration('jQuery.noConflict();');
}

	

$doc->addStylesheet( 'components/com_akquickicons/includes/elfinder/css/elfinder.min.css' );
$doc->addStylesheet( 'components/com_akquickicons/includes/elfinder/css/theme.css' );
JHtml::script( JURI::base().'components/com_akquickicons/includes/elfinder/js/elfinder.min.js' );
JHtml::script( JURI::base().'components/com_akquickicons/includes/elfinder/js/i18n/elfinder.'.$lang_code.'.js' );

$script = <<<EL
jQuery().ready(function($) {
	var elf = $('#elfinder').elfinder({
		url : 'index.php?option=com_akquickicons&task=manager'
		,
		lang : '{$lang_code}' 
	}).elfinder('instance');
});
EL;

$doc->addScriptDeclaration($script) ;

?>
<!-- Form Begin -->
<form action="<?php echo JFactory::getURI()->toString(); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<?php if(!empty( $this->sidebar)): ?>
		
		<!-- Sidebar -->
		<div id="j-sidebar-container" class="span2">
			<h4 class="page-header"><?php echo JText::_('JOPTION_MENUS'); ?></h4>
			<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
	<?php else : ?>
		<div id="j-main-container">
	<?php endif;?>
	
	<p>
		<div class="system-info">
			<span class="message">
				<?php echo JText::_('COM_AKQUICKICONS_IMAGE_MANAGER_DESC'); ?>
			</span>
			|
			<?php
			$upload_max = ini_get('upload_max_filesize') ;
			$upload_num = ini_get('max_file_uploads') ;
			?>
			
			<?php echo JText::_('COM_AKQUICKICONS_UPLOAD_MAX'); ?> <?php echo $upload_max; ?>
			|
			<?php echo JText::_('COM_AKQUICKICONS_UPLOAD_NUM'); ?> <?php echo $upload_num; ?>
			
		</div>
	</p>
	<div id="elfinder"></div>

	<p align="center">
		<br />
		Powerd by <a href="http://elfinder.org/">elFinder</a>
	</p>	
	
</form>