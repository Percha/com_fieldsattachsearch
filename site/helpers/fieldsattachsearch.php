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
        public function getCategories($id)
	{ 
		 
		$db = JFactory::getDbo(); 

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
        public function getJson($id)
	{ 
		 
		$db = JFactory::getDbo(); 

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
	function getInfo($fieldid)
        {
            $db = &JFactory::getDBO(  );
            
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
	function getOrdering($id)
        {
		$db = JFactory::getDbo(); 

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
	function getLimit($id)
        {
		$db = JFactory::getDbo(); 

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
        public function getTemplate($id)
	{ 
		 
		$db = JFactory::getDbo(); 

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
        public function getScript($id)
	{ 
		 
		$db = JFactory::getDbo(); 

		$db = JFactory::getDbo();
		$query = 'SELECT a.templatejavascript'
		. ' FROM #__fieldsattachsearch_layout as a' 
		. ' WHERE  a.id = '.$id.' and a.state=1' 
		;
		
		$db->setQuery($query);
		$row = $db->loadResult(); 
            

		return $row;  
	}
	
	 

}

