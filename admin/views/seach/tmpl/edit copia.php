<?php
/**
 * @version     1.0.0
 * @package     com_fieldsattachsearch
 * @copyright   Copyright (C) 2013. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Cristian Grañó <cristian@percha.com> - http://www.percha.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal', 'a.modal');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive'); 


// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_fieldsattachsearch/assets/css/fieldsattachsearch.css');

$link	= 'index.php?option=com_fieldsattach&view=fieldsattachunidades&layout=modal&tmpl=component&function=jSelectFields&object='.(int) $this->item->id;
          

$script = '
    js = jQuery.noConflict();
    js(document).ready(function(){
    
	 var frameSrc = "'.$link.'";

	jQuery("#openBtn").click(function(){
	    jQuery("#myModal").on("show", function () {
		 
		jQuery("iframe").attr("src",frameSrc);
	      
		});
	    jQuery("#myModal").modal({show:true})
	});
        
    });
    
    Joomla.submitbutton = function(task)
    {
	
        if(task == "seach.cancel"){
            Joomla.submitform(task, document.getElementById("seach-form"));
        }
        else{
            
            if (task != "seach.cancel" && document.formvalidator.isValid(document.id("seach-form"))) {
                //alert(task);
                Joomla.submitform(task, document.getElementById("seach.cancel"));
		 
            }
            else {
                alert("'.$this->escape(JText::_("JGLOBAL_VALIDATION_FORM_FAILED")).'");
            }
        }
	
	
	
	
    }
    
    /*
    * JSON:
    * 	{
    * 		fieldid:,
    * 		title:,
    *		initvalue:,
    *		obj:,
    *		catid:,
    *  	},
    */
    
    var jsonfields = new Array();
    function jSelectFields(id, title, catid, object,type) {
	console.log("id:"+id);
	console.log("title:"+title);
	console.log("catid:"+catid);
	console.log("object:"+object);
	
	//Add TO Json
	var objjson		=	new Object();
	objjson.fieldid		=	id;
	objjson.title		=	title;
	objjson.initvalue	=	"";
	objjson.object		=	object;
	objjson.catid		=	catid;
	
	jsonfields.push(objjson);
	
	
	jQuery("#jform_fields").val(JSON.stringify(objjson));
	
	jQuery("#myModal").modal("hide");
	
    }
    
';

// Add the script to the document head.
JFactory::getDocument()->addScriptDeclaration($script);
?>
<form action="<?php echo JRoute::_('index.php?option=com_fieldsattachsearch&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="seach-form" class="form-validate">
    <div class="row-fluid">
        <div class="span10 form-horizontal">
            <fieldset class="adminform">

                	<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('fields'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('fields'); ?></div>
			</div>
			 
        

		    <a href="#" class="btn btn-primary" id="openBtn"><?php echo JText::_('Select Field'); ?></a>
		    <!-- INI IFRMAE -->
		    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog">
			    <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal">×</button>
					    <h3>Select Field</h3>
					    
			    </div>
			    <div class="modal-body">
				<iframe src="" width="99.6%" height="450" frameborder="0"></iframe>
			    </div>
			    <div class="modal-footer">
				    <button class="btn" data-dismiss="modal"><?php JText::_("close");?></button>
			    </div>
		    </div>
		    <!-- END IFRMAE -->
            </fieldset>
        </div>

        

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>