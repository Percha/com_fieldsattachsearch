<?php
/*------------------------------------------------------------------------
# mod_insertfieldsattach
# ------------------------------------------------------------------------
# author    Cristian Grañó (percha.com)
# copyright Copyright (C) 2010 percha.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.percha.com
# Technical Support:  Forum - http://www.percha.com/
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.html.html');
jimport('joomla.form.formfield');//import the necessary class definition for formfield

 

/**
 * Supports an HTML select list of articles
 * @since  1.6
 */
class JFormFieldSearchFieldsattach extends JFormField
{
	 /**
      * The form field type.
      *
      * @var  string
      * @since	1.6
      */
      protected $type = 'searchfieldsattach'; //the form field type

            /**
      * Method to get content articles
      *
      * @return	array	The field option objects.
      * @since	1.6
      */
	protected function getInput()
	{
          // Initialize variables.
          $session = JFactory::getSession();
          $options = array();

          $attr = '';

          // Initialize some field attributes.
          $attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';

          // To avoid user's confusion, readonly="true" should imply disabled="true".
          if ( (string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') {
           $attr .= ' disabled="disabled"';
          }

          $attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
          $attr .= $this->multiple ? ' multiple="multiple"' : '';

          // Initialize JavaScript field attributes.
          $attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';


          //now get to the business of finding the articles

          $db = &JFactory::getDBO();
          $query = 'SELECT * FROM #__fieldsattachsearch_layout WHERE state=1 ORDER BY title';
	  
          $db->setQuery( $query );
          $searchs = $db->loadObjectList();
	  $html =  "";
	  if(count($searchs)>0)
		{
		 $html .= '<select id="'.$this->id.'" name="'.$this->name.'" >';
		 foreach($searchs as $search){ 
			 
			$html .='<option value="'.$search->id.'" ';
			if($search->id==$this->value) $html .=' selected="selected"';
			$html .='>'.$search->title.'';
			$html .='</option>';
		      
		 
		 }
		  $html .= '</select>';
	       }
     //$html .= "\n".'<input type="hidden" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'" />';

        return $html;
        //return JHTML::_('select.genericlist',  $articles, $this->name, trim($attr), 'id', 'title', $this->value );
  
  }
} 