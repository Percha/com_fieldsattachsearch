var application = {
           
	  settings: {
                    idfield:"",
                    wrapperid:"",
                    jsonfields:"",
                    conditions:"LIKE,EQUAL,NOT EQUAL,HIGHER,LOWER,BETWEEN"
	  },
	
	  init: function(idfield, wrapperid) {
                    console.log("INIT");
                    //wrappers = this.settings;
                    this.settings.idfield=idfield;
                    this.settings.wrapperid=wrapperid;
                    this.initHTML();
                    this.initJson();
                    this.initEvents();
                    //this.bindUIActions();
	  },
          initHTML:function(){
                    var idfield = jQuery("#"+this.settings.idfield);
                    var wrapper = jQuery("#"+this.settings.wrapperid);
                    var tmpJson = idfield.val();
                    jQuery( "#"+this.settings.wrapperid ).find("li").remove();
                    console.log("JSON:"+tmpJson);
                    var tmpArray = jQuery.parseJSON(tmpJson);
                    if(jQuery.isArray(tmpArray)){
                              for(var i = 0; i<tmpArray.length;i++)
                              {
                                        //Add to HTML LIST
                                        var str   = '<li class="row unit_'+tmpArray[i].fieldid+'">';
                                        str       += '<span class="span9"><h4>'+tmpArray[i].title;
                                        str       += ' <small>ID: '+tmpArray[i].fieldid+'</small></h4>';
                                        str       += '<span class="span12"><select name="selectcondition_'+tmpArray[i].fieldid+'" id="selectcondition_'+tmpArray[i].fieldid+'"  class="rules">';
                                        var tmpconditions = String(this.settings.conditions).split(",");
                                        if(tmpArray[i].fieldid>0){
                                                  for(var i2=0; i2<tmpconditions.length;i2++)
                                                  {
                                                            console.log(tmpArray[i].condition+" == "+ tmpconditions[i2]);
                                                            str       += '<option value="'+tmpconditions[i2]+'"'; 
                                                            if(tmpArray[i].condition == tmpconditions[i2]){ str += ' selected="selected"';}
                                                            str       += '>'+tmpconditions[i2]+'</option>';
                                                  }
                                        }else{
                                                  str       += '<option value="LIKE">LIKE</option>'; 
                                        }
                                        str       += '</select>'
                                        str       += '</span><span class="span12"><span class="span5"><input type="text" class="initvalue" name="initvalue_'+tmpArray[i].fieldid+'" value="'+tmpArray[i].initvalue+'" placeholder="default value" /></span>';
                                        
                                        str       += '<span class="span6"><input type="text" class="initvalue_2 cond2" id="initvalue_2_'+tmpArray[i].fieldid_2+'" name="initvalue_2_'+tmpArray[i].fieldid_2+'" value="'+tmpArray[i].initvalue_2+'" placeholder="default value" ';
                                         
                                        if(tmpArray[i].condition != "BETWEEN")
                                        {
                                                 
                                                  str       +=' style="display:none" ';
                                        }
                                        str       += '/></span></span>';
                                        str       += '</span>';
                                        str       += '<span class="up span1 btn btn-primary">up</span>';
                                        str       += '<span  class="down span1 btn btn-primary">down</span>';
                                        str       += '<span class="remove span1 btn btn-danger">X</span>';
                                        str       += '</li>';
                                         wrapper.append(str);
                                        //Add To Array
                                        //this.addItemJson(tmpArray[i].fieldid,tmpArray[i].title,tmpArray[i].initvalue,tmpArray[i].object,tmpArray[i].catid)
                              }
                              this.initDefaultTemplate();
                    }
          },
          initJson:function(){
                    var tmpJson         = jQuery("#"+this.settings.idfield).val();
                    var tmpArray        = jQuery.parseJSON(tmpJson);
                    if(jQuery.isArray(tmpArray)){
                              for(var i = 0; i<tmpArray.length;i++)
                              { 
                                        //Add To Array
                                        this.addItemJson(tmpArray[i].fieldid,tmpArray[i].title,tmpArray[i].initvalue,tmpArray[i].object,tmpArray[i].catid,tmpArray[i].condition,tmpArray[i].initvalue_2)
                              }
                    }
          },
          initEvents:function(){
                    
                    //REMOVE
                    jQuery( ".remove" ).click(function() {
                              console.log(""+jQuery(this).attr("class"));
                              application.removeItemJson(jQuery(this));
                    });
                    jQuery( ".remove" ).mouseover(function() {
                             jQuery(this).css("cursor", "pointer");
                    });
                    
                    //UP
                    jQuery( ".up" ).click(function() {
                              console.log(""+jQuery(this).attr("class"));
                              application.changeOrderItemJson(jQuery(this),-1);
                    });
                    jQuery( ".up" ).mouseover(function() {
                             jQuery(this).css("cursor", "pointer");
                    });
                    
                    //DOWN
                    jQuery( ".down" ).click(function() {
                              console.log(""+jQuery(this).attr("class"));
                              application.changeOrderItemJson(jQuery(this),1);
                    });
                    jQuery( ".down" ).mouseover(function() {
                             jQuery(this).css("cursor", "pointer");
                    });
                    
                    //INIT
                    jQuery( ".initvalue" ).change(function() {
                              console.log(""+jQuery(this).attr("class"));
                              application.changeInitValueJson(jQuery(this));
                    });
                    
                    //INIT
                    jQuery( ".initvalue_2" ).change(function() {
                              console.log(""+jQuery(this).attr("class"));
                              application.changeInitValueJson_2(jQuery(this));
                    });
                    
                    //RULES
                    jQuery( ".rules" ).change(function() {
                              console.log(""+jQuery(this).attr("class"));
                              application.changeConditionJson(jQuery(this));
                    });
                    
                    
          },
          removeItemJson:function(obj)
          {
                    console.log("L_::"+obj.parent().attr("class"));
                    var tmp = String(obj.parent().attr("class")).split("_");
                    
                    for(var index=0; index < jsonfields.length;index++)
                    {
                          if(jsonfields[index].fieldid==tmp[1])
                          {
                              //delete jsonfields[i];
                              jsonfields.splice(index, 1);
                          }
                    }
                    
                    jQuery("#"+this.settings.idfield).val(JSON.stringify(jsonfields));
                    //this.initJson();
                    this.initHTML();
                    this.initEvents();
                   
                    
          },
          addInput:function()
          {
                    this.addItemJson(-1,"Title and description",'',0,0,0,'');
                    this.initHTML();
                    this.initEvents();
          },
          addItemJson: function(fieldid,title,initvalue,object,catid,condition,initvalue_2){
                    var objjson		=	new Object();
                    objjson.fieldid	=	fieldid;
                    objjson.title	=	title;
                    objjson.initvalue	=	initvalue;
                    objjson.initvalue_2	=	initvalue_2; 
                    objjson.object	=	object;
                    objjson.catid	=	catid;
                    objjson.condition	=	condition;
                    
                    console.log("********JSON INIT:: "+initvalue_2);
	
                    jsonfields.push(objjson);
                    
                    console.log("JSON SET:: "+JSON.stringify(jsonfields));
	 
                    jQuery("#"+this.settings.idfield).val(JSON.stringify(jsonfields));
                    
                    //this.initHTML();
                    //this.initEvents();
                     
          
          },
          changeOrderItemJson: function(obj, direction){
                    var tmp = String(obj.parent().attr("class")).split("_");
                    
                    for(var index=0; index <= jsonfields.length;index++)
                    {
                              console.log(jsonfields[index].fieldid+"=="+ tmp[1]);
                              if(jsonfields[index].fieldid == tmp[1])
                              {
                                        var posible=true;
                                        if(direction<0 && index==0){posible=false;}
                                        if(direction>0 && index>=(jsonfields.length-1)){posible=false;}
                                        
                                        if(posible){
                                                  var tmp1 = jsonfields[index+direction];
                                                  var tmp2 = jsonfields[index];
                                                  jsonfields[index+direction]= tmp2;
                                                  jsonfields[index]= tmp1;
                                                  console.log("ss"+tmp1);
                                        }
                                        break;
                              }
                    }
                    
                    jQuery("#"+this.settings.idfield).val(JSON.stringify(jsonfields));
                    //this.initJson();
                    this.initHTML();
                    this.initEvents();
          },
          changeInitValueJson:function(obj)
          {
                    var tmp = String(obj.parent().parent().parent().parent().attr("class")).split("_");
                    console.log("TMP::"+tmp);
                    for(var index=0; index <= jsonfields.length;index++)
                    {
                              console.log(jsonfields[index].fieldid+"=="+ tmp[1]);
                              if(jsonfields[index].fieldid == tmp[1])
                              {
                              console.log(">=="+ obj.val());
                                       jsonfields[index].initvalue= obj.val();
                                       break;
                              }
                    }
                    
                    jQuery("#"+this.settings.idfield).val(JSON.stringify(jsonfields));
                    //this.initJson();
                    //this.initHTML();
                    this.initEvents();
                    this.initDefaultTemplate();
          }
          ,
          changeInitValueJson_2:function(obj)
          {
                    var tmp = String(obj.parent().parent().parent().parent().attr("class")).split("_");
                    console.log("TMP::"+tmp);
                    for(var index=0; index <= jsonfields.length;index++)
                    {
                              console.log(jsonfields[index].fieldid+"=="+ tmp[1]);
                              if(jsonfields[index].fieldid == tmp[1])
                              {
                                        console.log(">=="+ obj.val());
                                        jsonfields[index].initvalue_2= obj.val();
                                        break;
                              }
                    }
                    
                    jQuery("#"+this.settings.idfield).val(JSON.stringify(jsonfields));
                    //this.initJson();
                    //this.initHTML();
                    this.initEvents();
                    this.initDefaultTemplate();
          },
          changeConditionJson:function(obj)
          {
                    var tmp = String(obj.parent().parent().parent().attr("class")).split("_");
                    console.log("TMP::"+tmp);
                    for(var index=0; index <= jsonfields.length-1;index++)
                    {
                              console.log(jsonfields[index].fieldid+"=="+ tmp[1]);
                              if(jsonfields[index].fieldid == tmp[1])
                              {
                                        console.log(">=="+ obj.val());
                                        jsonfields[index].condition = obj.val();
                                        
                                        if( jsonfields[index].condition == "BETWEEN")
                                        {
                                                  
                                                  jQuery("#listjson li:eq("+index+") .cond2").css("display","block");
                                                  //jQuery("#listjson li:eq("+index+") .cond2").val();
                                                  /*
                                                  jQuery("#listjson li").each(function()
                                                            {
                                                                      console.log("BETWEEN:"+jQuery(this)); 
                                                            });
                                                  jsonfields[index].initval_2="sss";
                                                  */
                                                  //console.log("BETWEEN:"+jQuery("#listjson li:gt("+index+") .cond2"));
                                                  console.log("BETWEEN:"+index);
                                        }else{
                                                  jQuery("#listjson li:eq("+index+") .cond2").css("display","none");
                                        }
                                        
                                        break;
                              }
                    }
                    
                    jQuery("#"+this.settings.idfield).val(JSON.stringify(jsonfields));
                    //this.initJson();
                    //this.initHTML();
                    this.initEvents();
          },
          initDefaultTemplate:function(){
                    var tmpJson         = jQuery("#"+this.settings.idfield).val();
                    var tmpArray        = jQuery.parseJSON(tmpJson);
                    
                    var templatestate   = jQuery("#jform_templatestate").val();
                    
                    if(jQuery.isArray(tmpArray) && templatestate==0){
                              var str = '';
                              for(var i = 0; i<tmpArray.length;i++)
                              { 
                                        //Add To Array
                                        //this.addItemJson(tmpArray[i].fieldid,tmpArray[i].title,tmpArray[i].initvalue,tmpArray[i].object,tmpArray[i].catid,tmpArray[i].condition)
                                        str       += '<div class="row-fluid">';
                                        str       += '<div class="span8">';
                                        str       += '{field_'+tmpArray[i].fieldid+'}';
                                        str       += '</div>';
                                        str       += '</div>';
                              }
                              str       += '';
                              jQuery("#jform_templateform").val(str);
                    }
          }
	
};
	