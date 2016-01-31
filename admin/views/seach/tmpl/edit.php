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
          
?> 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
<script type="text/javascript">
    var application;
    js = jQuery.noConflict();
    js(document).ready(function(){
    
	 var frameSrc = "<?php echo $link;?>";

	jQuery('#openBtn').click(function(){
	    jQuery('#myModal').on('show', function () {
		 
		jQuery('iframe').attr("src",frameSrc);
	      
		});
	    jQuery('#myModal').modal({show:true})
	});
	
	jQuery('#openBtn2').click(function(){
	    application.addInput();
	});
	
	//INIT
	application.init("jform_fields","listjson");
	
        
    });
    
    Joomla.submitbutton = function(task)
    {
        if(task == 'seach.cancel'){
            Joomla.submitform(task, document.getElementById('seach-form'));
        }
        else{
            
            if (task != 'seach.cancel' && document.formvalidator.isValid(document.id('seach-form'))) {
                
                Joomla.submitform(task, document.getElementById('seach-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
	
	
	
	
    }
     
    
   
</script>

<?php

$script = '
     
    
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
	
	/* 
	//Add TO Json
	var objjson		=	new Object();
	objjson.fieldid		=	id;
	objjson.title		=	title;
	objjson.initvalue	=	"";
	objjson.object		=	object;
	objjson.catid		=	catid;
	
	jsonfields.push(objjson);
	
	jQuery("#jform_fields").val(JSON.stringify(jsonfields));
	*/
	 
	application.addItemJson(id, title, "", object, catid,"" );
	application.initHTML();
	
	jQuery("#myModal").modal("hide");
	
    }
    
';

// Add the script to the document head.
JFactory::getDocument()->addScriptDeclaration($script);
JFactory::getDocument()->addScript(JURI::root() ."administrator/components/com_fieldsattachsearch/assets/js/application.js");

?>

<form action="<?php echo JRoute::_('index.php?option=com_fieldsattachsearch&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="seach-form" class="form-validate">
    <div class="row-fluid">
        <div class="span12 form-horizontal">
	    <div class="control-group">
		    <div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
		    <div class="controls"><?php echo $this->form->getInput('id'); ?></div>
	    </div>
	    <div class="control-group">
		    <div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
		    <div class="controls"><?php echo $this->form->getInput('title'); ?></div>
	    </div>
	    
	    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
	    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_FIELDSATTACHSEARCH_GENERAL', true)); ?>
	    <div class="row-fluid">
		<fieldset class="adminform">
			<div class="span9">   
			    <div class="control-group">
				    <div class="control-label"><?php echo $this->form->getLabel('fields'); ?></div>
				    <div class="controls"><?php echo $this->form->getInput('fields'); ?></div>
			    </div>
			    <div>
				<a href="#" class="btn btn-primary" id="openBtn2"><?php echo JText::_('COM_FIELDSATTACHSEARCH_TITLEANDTEXTAREA'); ?></a>
				
				<a href="#" class="btn btn-primary" id="openBtn"><?php echo JText::_('COM_FIELDSATTACHSEARCH_SELECTFIELD'); ?></a>
				<ul id="listjson"></ul>
			    </div>
			</div>
			
			<div class="span3">
			    <div class="row-fluid form-horizontal-desktop"> 
				<div class="control-group">
				    <div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				    <div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			       </div>
				<div class="control-group">
				    <div class="control-label"><?php echo $this->form->getLabel('catids'); ?></div>
				    <div class="controls"><?php echo $this->form->getInput('catids'); ?></div>
			       </div>
				<div class="control-group">
				    <div class="control-label"><?php echo $this->form->getLabel('ordering'); ?></div>
				    <div class="controls"><?php echo $this->form->getInput('ordering'); ?></div>
			       </div>
				<div class="control-group">
				    <div class="control-label"><?php echo $this->form->getLabel('limit'); ?></div>
				    <div class="controls"><?php echo $this->form->getInput('limit'); ?></div>
			       </div>
				
				
				
			    </div>
			</div>
			    
	    
    
			
			<!-- INI IFRMAE -->
			<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
						<h3><?php echo JText::_("COM_FIELDSATTACHSEARCH_SELECTFIELD");?></h3>
				</div>
				<div class="modal-body">
				    <iframe src="" width="99.6%" height="450" frameborder="0"></iframe>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal"><?php JText::_("COM_FIELDSATTACHSEARCH_CLOSE");?></button>
				</div>
			</div>
			<!-- END IFRMAE -->
		</fieldset>
	    </div>
	    <?php echo JHtml::_('bootstrap.endTab'); ?>
	    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('COM_FIELDSATTACHSEARCH_TEMPLATE', true)); ?>
	    <div class="row-fluid">
		<div class="span11">
		    <div class="control-group">
				    <div class="control-label"><?php echo $this->form->getLabel('templatestate'); ?></div>
				    <div class="controls"><?php echo $this->form->getInput('templatestate'); ?></div>
			    </div>
		    <fieldset class="adminform"> 
			 <?php echo $this->form->getLabel('templateform'); ?><?php echo $this->form->getInput('templateform'); ?>
		    </fieldset>
            
             <fieldset class="adminform"> 
			 <?php echo $this->form->getLabel('templatejavascript'); ?><?php echo $this->form->getInput('templatejavascript'); ?>
		    </fieldset>
            
            
		</div>
		 
	    </div>
	    <?php echo JHtml::_('bootstrap.endTab'); ?>
	    <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        

	    <input type="hidden" name="task" value="" />
	    <?php echo JHtml::_('form.token'); ?>
	    
        </div>
	

    </div>
</form>