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

jimport('joomla.application.component.view');

/**
 * View class for a list of Fieldsattachsearch.
 */
class FieldsattachsearchViewSeachs extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->alerts		= "";

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		FieldsattachsearchHelper::addSubmenu('seachs');
        
		$this->addToolbar();
        
		$this->sidebar = JHtmlSidebar::render();
		
		//Control of plugin 
		
		$formPath = JPATH_ROOT.'/plugins/fieldsattachsearch/search/search.php';
		 
		if(!file_exists($formPath))
		{
				$this->alerts='<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					'.JText::_("COM_SEARCH_EXIST_PLUGIN").'
			       </div>';
		}else{
			JPluginHelper::importPlugin('fieldsattachsearch'); // very important
			$function  = "plgfieldsattachsearchsearch::onContentSearch";
			$exist = method_exists("plgfieldsattachsearchsearch","onContentSearch");
			 
			 
			if(!$exist)
			{
				$this->alerts='<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					'.JText::_("COM_SEARCH_ACTIVE_PLUGIN").'
			       </div>';
			}
			
		}
		
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/fieldsattachsearch.php';

		$state	= $this->get('State');
		$canDo	= FieldsattachsearchHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_FIELDSATTACHSEARCH_TITLE_SEACHS'), 'seachs.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/seach';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('seach.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('seach.edit','JTOOLBAR_EDIT');
		    }

        }

		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('seachs.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('seachs.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'seachs.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('seachs.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('seachs.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'seachs.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('seachs.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_fieldsattachsearch');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_fieldsattachsearch&view=seachs');
        
        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

        
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.title' => JText::_('COM_FIELDSATTACHSEARCH_SEACHS_TITLE'),
		'a.state' => JText::_('JSTATUS'),
		);
	}

    
}
