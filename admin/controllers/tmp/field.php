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

jimport('joomla.application.component.controllerform');

/**
 * Field controller class.
 */
class FieldsattachsearchControllerField extends JControllerForm
{

    function __construct() {
        $this->view_list = 'fields';
        parent::__construct();
    }

}