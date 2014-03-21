<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_search
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$lang = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();
 
JLoader::register('fieldattach',  JPATH_ROOT.DS.'components/com_fieldsattach/helpers/fieldattach.php');

//           
?>
<form id="searchForm" action="<?php echo JRoute::_('index.php?option=com_fieldsattachsearch');?>" method="post">
	
	<fieldset class="word">  
		<?php echo $this->getForm();?>
		<div class="btn-group pull-left">
			<button name="Search" onclick="this.form.submit()" class="btn" title="<?php echo JText::_('COM_FIELDSATTACHSEARCH_SEARCH');?>"><?php echo JText::_("COM_FIELDSATTACHSEARCH_SEARCH");?></button>
		</div>
		 
		<input type="hidden" name="option" value="com_fieldsattachsearch" />
		<input type="hidden" name="task" value="search" />
		<input type="hidden" name="Search" value="<?php echo  JRequest::getVar("Search");?>" />
		<input type="hidden" name="Itemid" value="<?php echo  JRequest::getVar("Itemid"); ?>" />
	</fieldset>
	  
		<p class="span12">
			<p><?php echo JText::_('COM_FIELDSATTACHSEARCH_N_RESULTS').' <span class="badge badge-info">'.($this->total).'</span>'; ?></p>
		</p>
	 
</form>

		

