<?php
/**
 * @version     1.0.0
 * @package     com_fieldsattachsearch
 * @copyright   Copyright (C) 2013. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Cristian Grañó <cristian@percha.com> - http://www.percha.com
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Fieldsattachsearch helper.
 */
class FieldsattachsearchHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_FIELDSATTACHSEARCH_TITLE_SEACHS'),
			'index.php?option=com_fieldsattachsearch&view=seachs',
			$vName == 'seachs'
		);
		/*JHtmlSidebar::addEntry(
			JText::_('COM_FIELDSATTACHSEARCH_TITLE_FIELDS'),
			'index.php?option=com_fieldsattachsearch&view=fields',
			$vName == 'fields'
		);*/

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_fieldsattachsearch';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

	/**
	 * ORder selector
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getOrdering($fields, $ordering)
	{
		 
		$result = '<select id="jform_ordering" name="jform[ordering]" class="chzn-done" ">';

		$result .= '<option value="newest"';
		if('newest' == $ordering ) $result .= ' selected="selected" ';
		$result .= ' >Newesr first</option>';

		$result .= '<option value="oldest"';
		if('oldest' == $ordering ) $result .= ' selected="selected" ';
		$result .= ' >Older First</option>';

		$result .= '<option value="popular"';
		if('popular' == $ordering ) $result .= ' selected="selected" ';
		$result .= ' >Popular first</option>';

		$result .= '<option value="alpha"';
		if('alpha' == $ordering ) $result .= ' selected="selected" ';
		$result .= '>Alphanumeric</option>';

		$result .= '<option value="category"';
		if('category' == $ordering ) $result .= ' selected="selected" ';
		$result .= '>Category</option>';

		$fieldsarray = json_decode($fields); 

		foreach ($fieldsarray as  $obj) { 

			$objtmp = json_decode($obj);

			$result .='<option ';
			$value_asc = 'field_'.$obj->{'fieldid'}.' ASC';
			if($value_asc  == $ordering ) $result .= ' selected="selected" ';
			$result .='value="'.$value_asc.'">'.$obj->{'title'}.' ASC</option>';

			$result .='<option ';
			$value_desc = 'field_'.$obj->{'fieldid'}.' DESC';
			if($value_desc == $ordering ) $result .= ' selected="selected" ';
			$result .='value="'.$value_desc.'">'.$obj->{'title'}.' DESC</option>';

			//echo "ssss:".$obj->{'fieldid'}."<br>";
		}

		

		$result .= '</select>';


		return $result;
	}
}
