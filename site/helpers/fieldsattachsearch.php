<?php
/**
 * @version     1.0.0
 * @package     com_fieldsattachsearch
 * @copyright   Copyright (C) 2013. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Cristian Grañó <cristian@percha.com> - http://www.percha.com
 */

defined('_JEXEC') or die;

class FieldsattachsearchHelper
{
	public static function myFunction()
	{
		$result = 'Something';
		return $result;
	}
	
	/**
	 * returns string of catids
	 *
	 * @param id   
	 * @return string
	 */
        public static function getCategories($id)
	{  
		$db = JFactory::getDbo();
		$query = 'SELECT a.catids'
		. ' FROM #__fieldsattachsearch_layout as a' 
		. ' WHERE  a.id = '.$id.' and a.state=1' 
		;
		
		$db->setQuery($query);
		$row = $db->loadResult(); 
            

		return $row;  
	}
	
	/**
	 * returns string of catids
	 *
	 * @param id   
	 * @return string
	 */
     public static function getJson($id)
	{ 
		 
		 

		$db = JFactory::getDbo();
		$query = 'SELECT a.fields'
		. ' FROM #__fieldsattachsearch_layout as a' 
		. ' WHERE  a.id = '.$id.' and a.state=1' 
		;
		
		$db->setQuery($query);
		$row = $db->loadResult(); 
            

		return $row;  
	}
	/**
	 * returns string of catids
	 *
	 * @param id   
	 * @return string
	 */
	static function getInfo($fieldid)
        {
            $db = JFactory::getDBO(  );
            
            $query = 'SELECT a.title, a.type, a.extras  FROM #__fieldsattach as a  WHERE a.id = '.$fieldid;
            //echo $query;
	    
            $db->setQuery( $query );
	    $result = $db->loadObject();
            $str = "";
            if(!empty($result)) $str = $result;
	    return $str;
        }
	
	/**
	 * returns string of catids
	 *
	 * @param id   
	 * @return string
	 */
	static  function getOrdering($id)
        {
		 

		$db = JFactory::getDbo();
		$query = 'SELECT a.ordering'
		. ' FROM #__fieldsattachsearch_layout as a' 
		. ' WHERE  a.id = '.$id.' and a.state=1' 
		;
		
		$db->setQuery($query);
		$row = $db->loadResult();
		
		return $row;
        }
	
	/**
	 * returns string of catids
	 *
	 * @param id   
	 * @return string
	 */
	static  function getLimit($id)
        {
		 

		$db = JFactory::getDbo();
		$query = 'SELECT a.limit'
		. ' FROM #__fieldsattachsearch_layout as a' 
		. ' WHERE  a.id = '.$id.' and a.state=1' 
		;
		
		$db->setQuery($query);
		$row = $db->loadResult();
		
		return $row;
        }
	
	 
	
	/**
	 * returns string of catids
	 *
	 * @param id   
	 * @return string
	 */
      static   public function getTemplate($id)
	{ 
		 
		 

		$db = JFactory::getDbo();
		$query = 'SELECT a.templateform'
		. ' FROM #__fieldsattachsearch_layout as a' 
		. ' WHERE  a.id = '.$id.' and a.state=1' 
		;
		
		$db->setQuery($query);
		$row = $db->loadResult(); 
            

		return $row;  
	}
	
	
	/**
	 * returns string of catids
	 *
	 * @param id   
	 * @return string
	 */
     static    public function getScript($id)
	{ 
		 
	 

		$db = JFactory::getDbo();
		$query = 'SELECT a.templatejavascript'
		. ' FROM #__fieldsattachsearch_layout as a' 
		. ' WHERE  a.id = '.$id.' and a.state=1' 
		;
		
		$db->setQuery($query);
		$row = $db->loadResult(); 
            

		return $row;  
	}

	/**
	 * returns HTML 
	 *
	 * @param objects JSON   
	 * @return string HTML
	 */
	static public function getTemplateForm($objects, $templateHTML)
	{
		 
		foreach($objects as $object)
		{
			//echo "<br />".$object->fieldid;
			if($object->fieldid>0){
				$obj = FieldsattachsearchHelper::getInfo($object->fieldid); 
				$type = $obj->type;
				 
				JPluginHelper::importPlugin('fieldsattachment'); // very important
				$function  = "plgfieldsattachment_".$obj->type."::searchinput";
				$bool = method_exists("plgfieldsattachment_".$obj->type,"searchinput");
				 
				 
				if($bool){
					if($object->condition == "BETWEEN")
					{
						$val1 = JRequest::getVar("field_".$object->fieldid, $object->initvalue);
						if(!empty($object->initvalue_2)) $val2 = JRequest::getVar("field_".$object->fieldid."_2", $object->initvalue_2);
						else $val2 =  JRequest::getVar("field_".$object->fieldid."_2");
						$object->html = '<input name="field_'.$object->fieldid.'" id="field_'.$object->fieldid.'" value="'.$val1.'" />';
						$object->html .= ' '.JText::_("TO").' ';
						$object->html .= '<input name="field_'.$object->fieldid.'_2" id="field_'.$object->fieldid.'_2" value="'.$val2.'" />';
						$templateHTML = str_replace("{field_".$object->fieldid."}",'<label for="">'.JText::_($object->title).'</label>'.$object->html, $templateHTML);

					}else{

						 
						$tmpparameters = array();
						$tmpparameters[]	= $object->fieldid;
						$tmpparameters[]	= JRequest::getVar("field_".$object->fieldid, $object->initvalue);
						$tmpparameters[] 	= $obj->extras;
						
						$object->html = call_user_func_array($function,$tmpparameters);
						
						//REMOVE DIV WRAPPER CONTENT
						$object->html = preg_replace("/<\/?div[^>]*\>/i", "", $object->html);

						if($object->condition == "JOINTOTITLEANDTEXT")
						{
							$templateHTML = str_replace("{field_".$object->fieldid."}",'<input id="'.$object->fieldid.'" id="'.$object->fieldid.'" type="hidden">', $templateHTML);

						 }else{
						 	$templateHTML = str_replace("{field_".$object->fieldid."}",'<label for="">'.JText::_($object->title).'</label>'.$object->html, $templateHTML);

						 }
					}
				}else{
					$templateHTML = str_replace("{field_".$object->fieldid."}",'<div class="alert"><a class="close" data-dismiss="alert">×</a><strong>'.JText::_("COM_FIELDSATTACHSEARCH_INPUTERROR").'</strong></div>', $templateHTML);

				}
				
				}else{
				if($object->fieldid == -1){
					
					$valor = JRequest::getVar("searchword", $object->initvalue);
					$templateHTML = str_replace("{field_".$object->fieldid."}",'<label for="searchword">'.JText::_("COM_FIELDSATTACHSEARCH_SEARCHLABEL").'</label><input type="text" name="searchword" id="search-searchword" size="30" value="'.$valor.'" class="inputbox" />', $templateHTML);

				}
			}
		}

		return $templateHTML;
	}
	
	 

}

