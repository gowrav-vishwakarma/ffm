<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created on Aug 29, 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 * 
 * @todo trim every userinput by $.trim(str) JQuery function
 * @todo validation limit f chars to implement
 */
 
 class form {
 	var $html;
 	var $ci;
 	var $id;
 	var $i;
 	var $cols;
 	var $focus;
    
 	function form(){
                $this->ci =& get_instance();
                $this->i=0;
                $this->cols=2;
                $this->ci->load->library('jq');
//                $this->ci->jq->addJs(array('js/formvalidator/jquery.ufvalidator.js'));
//                $this->ci->jq->addCss(array('js/formvalidator/assets/reset.css', 'js/formvalidator/assets/styles.css'));
        //        $this->ci->jq->addjs(array('js/jquery.autocomplete.js'));
        //        $this->ci->jq->addCss(array('css/jquery.autocomplete.css'));
                $this->focus="";
 	}
 	
 	function open($id,$action,$attributes=''){
		$enterScript='$("#'.$id.'").keypress(function (e) {
					    if (e.which == 13) {
					        var $targ = $(e.target);
					        if (/*!$targ.is("textarea") && */ !e.shiftKey && !$targ.is(":button,:submit")) {
					            $targ.blur();
					            var focusNext = false;
					            $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
					                if (this === e.target) {
					                    focusNext = true;
					                }
					                else if (focusNext){
					                    $(this).focus();
					                    return false;
					                }
					            });
					
					            return false;
					        }
					    }
					}
					);';
		$this->ci->jq->addDomReadyScript($enterScript);
		$highlightScript='
            //we want to highlight the row only if the item focused on is a textbox,
            //password or select list. Buttons should be ignored...
            $(":input").not(":button")
                .focus(function () {
                    //highlight the containing table row...
                    $(this).parents("td").css({ "background": "#14BDF4" });
                })
                .blur(function () {
                    //remove the background attribute from the inline style...
                    $(this).parents("td").css({ "background": "" });
                });';
        $this->ci->jq->addDomReadyScript($highlightScript);
        $textSelectScript="$('input, textarea, ui.combobox').focus(
							 function()
							 {
							   this.select();
							 }
							);\n";
		$this->ci->jq->addDomReadyScript($textSelectScript);
 		$this->html="<div id='bg-container' align='center'><form action=$action method='post' name='$id' id='$id' class='form' enctype='multipart/form-data' $attributes>";
 		$this->html .="<table width='100%' border='0' class='ui-widget ui-widget-content' cellspacing='5' cellpadding='5'>";
 		$this->id=$id;
                $this->i=0;
 		return $this;
 	}
 	
 	function setColumns($cols){
 		$this->cols=$cols;
 		return $this;
 	}
 	
 	function text($lable,$attributes,$style="text-transform:capitalize;"){
 		$this->first($lable);
                $id=$this->getAttribute('name',$attributes);
                $id=$this->id."_".$id;
 		$this->html .= "<td><div class='input-container'><input type='text' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .=" style='$style' id='$id'/></div></td>";
 		$this->last();
 		return $this;
 	}
 	
  	function dateBox($lable,$attributes){
 		$this->first($lable);
 		$id=$this->getAttribute('name',$attributes);
                $id=$this->id."_".$id;
 		$this->html .= "<td><div class='input-container'><input type='text' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .=" id='$id'/></div></td>";
 		$this->last();
 		$script="$(function() {
					$( '#$id' ).datepicker({ dateFormat: 'yy-mm-dd',changeMonth: true, changeYear: true, yearRange: '1950:1995'});
				});
			\n";
		$this->ci->jq->addDomReadyScript($script);
 		return $this;
 	}
 	
 	function textArea($lable,$attributes,$style="text-transform:capitalize;",$value=""){
 		$this->first($lable);
 		$this->html .= "<td><div class='input-container'><textarea ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
		$this->html .=" style='$style'/>$value</textarea></div></td>";
 		$this->last();
 		return $this;
 	}
 	
 	function password($lable,$attributes){
 		$this->first($lable);
 		$this->html .= "<td><div class='input-container'><input type='password' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .="/></div></td>";
 		$this->last();
 		return $this;
 	}
 	
 	function checkBox($lable,$attributes,$checked=false){
 		$this->first($lable);
 		$this->html .= "<td><div class='input-container'><input type='checkbox' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .= ($checked) ? 'checked': '';
 		$this->html .="/></div></td>";
 		$this->last();
 		return $this;
 	}
 	
 	function radio($lable,$attributes,$values, $defaultSelectedValue=''){
 		$this->first($lable);
 		$this->html .= "<td><div class='input-container'>";
 		foreach($values as $key=>$val){
 			$this->html .="<input type='radio' value='$val' ";
 			if(is_array($attributes)){
		 		foreach($attributes as $attr=>$val){
		 			$this->html .= "$attr='$val' ";
		 		}
 			}else{
 				$this->html .= $attributes;
 			}
                        $this->html .=" ". (($val==$defaultSelectedValue) ? "CHECKED" : "");
	 		$this->html .="  />$key";
 		}
 		$this->html .="</div></td>";
 		$this->last();
 		return $this;
 	}
 	
 	function hidden($lable,$attributes,$displayValue=''){
 		$this->first($lable);
 		$this->html .= "<td><div class='input-container'><input type='hidden' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .="/>$displayValue</div></td>";
 		$this->last();
 		return $this;
 	}

        function fileUpload($label,$attributes,$selected='-1'){
                $this->first($label);
 		$this->html .= "<td><div class='input-container'><input type='file' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .="/></div></td>";
 		$this->last();
 		return $this;
        }
 	
 	function select($label,$attributes,$values,$selected='-1'){
 		$i=1;
 		$this->first($label);
 		$this->html .= "<td><div class='input-container'><select  ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .=">";
 		
		foreach($values as $key=>$val){
			if($val!=$selected)
				$sel="";
			else
				$sel="selected";
			$this->html .="<option value='$val' $sel>$key</option>";
			$i++;
		}
		$this->html .="</select></div></td>";
 		$this->last();
 		return $this;
 		
 	}

 	function selectAjax($label,$attributes,$values,$selected='-1'){
 		$i=1;
 		$this->first($label);
 		$id=$this->getAttribute('name',$attributes);
                $id=$this->id."_".$id;
 		$class=$this->getAttribute('class',$attributes);
 		$notReqVal=$this->getAttribute('not-req-val',$attributes);
 		if($notReqVal!="") $notReqVal = ".attr( 'not-req-val', '$notReqVal')";
 		
 		$this->html .= "<td><div class='input-container'><select  ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .=" id='$id' >";
 		
		foreach($values as $key=>$val){
			if($val!=$selected)
				$sel="";
			else
				$sel="selected";
			$this->html .="<option value='$val' $sel>$key</option>";
			$i++;
		}
		$this->html .="</select></div></td>";
 		$this->last();
 		$script='(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.addClass( "'.$class.'" )'.
					$notReqVal
					.'
					.focus(function(){this.select()})
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( this.value.match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn\'t match anything
									$( this ).val( "" );
									select.val( "" );
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};
				/*
				$( "<button type=\'button\'>&nbsp;</button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});*/
			}
		});
	})( jQuery );

	$(function() {
		$( "#'.$id.'" ).combobox();
	});
';
 		$this->ci->jq->addDomReadyScript($script);
 		return $this;
 		
 	}
 	
 
  	function lookup($lable,$attributes,$url,$labelField,$valueField='',$style=''){
  		$this->first($lable);
  		$id=$this->getAttribute('name',$attributes);
                $id=$this->id."_".$id;
  		if($valueField=='') $valueField = $labelField;
  		$mapping="";
  		$makeListValues="";
  		$makeList=".data( \"autocomplete\" )._renderItem = function( ul, item ) {
			return $( \"<li></li>\" )
				.data( \"item.autocomplete\", item )
				.append( \"<a>\"+";
				
  		if(is_array($labelField)){
  			foreach($labelField as $l){
  				$mapping .= $l . " : item." . $l . ",\n";
  				$makeList .= " item.$l + \" :: \" + "; 
  			}
  			
  		}else{
  			$mapping = "label: item.".$labelField.", ";
			$mapping .= "value: item.".$valueField.", ";
  		}
                $mapping = trim($mapping,", ");
  		$makeList.=" \"</a>\" )
						.appendTo( ul );
						};";
 		$this->html .= "<td><div class='input-container'><input type='text' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .=" id='$id' style='$style'/></div></td>";
 		$this->last();
		$script="
				    var {$id}_data;
				    $('#$id').autocomplete({
				    source: function(request, response) {
				            $.ajax({
				                    url: '". $url."',
				                    dataType: 'json',
				                    type: 'post',
				                    data: {
				                            maxRows: 15,
				                            term: request.term,
				                            state: $('#$id').val()
				                    },
				                    success: function(data) {
				   							{$id}_data = data;
				                            response($.map(data.tags, function(item) {
				                                    return {
				                                            $mapping
				                                    }
				                            }))
				                    }
				            })
				    },
				    minLength: 1,
				    mustMatch: 1,
				    select: function(event, ui) {
					          $('#$id').val(ui.item.".$valueField.") ;
				    }
				
				})$makeList
		
	;
	";
		$this->ci->jq->addDomReadyScript($script);
 		return $this;
 	}
  
  	function lookupDB($lable,$attributes,$url,$dql,$labelField,$valueField='',$style=''){
  		$this->first($lable);
  		$id=$this->getAttribute('name',$attributes);
                $id=$this->id."_".$id;
  		if($valueField=='') $valueField = $labelField;
  		$mapping="";
  		$makeListValues="";
  		$makeList=".data( \"autocomplete\" )._renderItem = function( ul, item ) {
			return $( \"<li></li>\" )
				.data( \"item.autocomplete\", item )
				.append( \"<a>\"+";
				
  		if(is_array($labelField)){
  			foreach($labelField as $l){
  				$mapping .= $l . " : item." . $l . ",\n";
  				$makeList .= " item.$l + \" :: \" + "; 
  			}
  			
  		}else{
  			$mapping = "label: item.".$labelField.",\n";
			$mapping .= "value: item.".$valueField.",\n";	
  		}
                $mapping = trim($mapping,",\n");
  		$makeList.=" \"</a>\" )
						.appendTo( ul );
						};";
		if(!is_array($labelField)) $makeList="";
		
 		$this->html .= "<td><div class='input-container'><input type='text' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .=" id='$id' style='$style'/></div></td>";
 		$this->last();
		$script="
				    var {$id}_data;
				    $('#$id').autocomplete({
				    source: function(request, response) {
				            $.ajax({
				                    url: '". $url."',
				                    dataType: 'json',
				                    type: 'post',
				                    data: {
				                            maxRows: 15,
				                            term: request.term,
				                            dql: '".urlencode(json_encode($dql))."',
				                            state: $('#$id').val()
				                    },
				                    success: function(data) {
				   							{$id}_data = data;
				                            response($.map(data.tags, function(item) {
				                                    return {
				                                            $mapping
				                                    }
				                            }))
				                    }
				            })
				    },
				    minLength: 1,
				    mustMatch: 1,
				    select: function(event, ui) {
					          $('#$id').val(ui.item.".$valueField.") ;
				    }
				
				})$makeList
		
	;
	";
		$this->ci->jq->addDomReadyScript($script);
 		return $this;
 	}
  	
 	function div($id, $attributes,$matter=''){
 		$this->first('no');
 		$this->html .= "<td colspan=2><div id='$id' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .=	">$matter</div></td>";
 		$this->last();
 		return $this;
 	}
 	
 	function submit($value){
 		$this->first();
 		$this->html .= "<td><input id='submitBtn$this->id' value='$value' type='submit' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' /></td>";
 		$this->last();
                $script="$('#submitBtn$this->id').click(function(){
                            $(this).hide();
                        });";
                $this->ci->jq->addDomReadyScript($script);
 		return $this;
 	}

        function submitNoHide($value){
            $this->first();
 		$this->html .= "<td><input id='submitBtn$this->id' value='$value' type='submit' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' /></td>";
 		$this->last();
 		return $this;
        }

        function confirmButton($value,$title,$url,$fullScreen=true){
                $this->first();
 		$this->html .= "<td><input id='confirmBtn$this->id' value='$value' type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' /></td>";
 		$this->last();
                $script="$('#confirmBtn$this->id').click(function () {
                           $('#confirmBtn$this->id').hide();
                          $.ajax(
                                {
                                  type: 'POST',
                                  url: '$url',
                                  data: $('#$this->id').serialize(),
                                  success: function( response ) {
                                        $('<div>').dialog({
                                                modal: true,
                                                buttons: {
                                                        'Confirm and Proceed': function() {
                                                                $(this).dialog('close');
                                                                //alert('sdfsd');
                                                                $('#submitBtn$this->id').click();     
                                                        },
                                                        Cancel: function() {
                                                                $(this).dialog( 'close' );
                                                        }
                                                },

                                                open: function ()
                                                {
                                                    if(response.indexOf('falsefalse') >= 0 ){
                                                        var firstButton=$('.ui-dialog-buttonpane');
                                                        firstButton.hide();
//                                                        response=response.substring(0,response.indexOf('false'));
                                                    }
                                                    $(this).html(response);
                                                },
                                                close: function()
                                                {
                                                    $('#confirmBtn$this->id').show();
                                                    $(':input:visible:enabled:first').focus();
                                                },
                                                height: 500,
                                                width: 800,
                                                title: '$title'
                                            });
                                           } // sucess funciton
                                  }
                                ); //$.ajax
                                }); //ConfirmBtn click

                    $(function (){
                        $('#submitBtn$this->id').hide();
                        });
                        ";
                $this->ci->jq->addDomReadyScript($script);
 		return $this;
        }
 	
 	function resetBtn($value){
 		$this->first();
 		$this->html .= "<td><input id='resetBtn$this->id' value='$value' type='reset' class='sendBtn' /></td>";
 		$this->last();
 		return $this;
 	}
 	
 	function get(){
 		$this->html.= "</table><div id='errorDiv$this->id' class='error-dive'>FORM LIBRARY</div></form>";
 		$this->html.= "</div>";
 		$script="$('#submitBtn$this->id').formValidator({
                                onError         : function() { if($('#confirmBtn$this->id').length == 0) $('#submitBtn$this->id').show(); return false;},
				scope		: '#$this->id',
				errorDiv	: '#errorDiv".$this->id."'
			});
			";
		$this->ci->jq->addDomReadyScript($script);
		$shiftEnter="$('Shift+Enter').trigger('Shift+Tab');";
		$this->ci->jq->addDomReadyScript($shiftEnter);
 		if($this->focus=="")
 			$this->focus();
 		return $this->html;
 	}
 	
 	function first($lable=''){
 		if($this->i % $this->cols == 0){
 			$this->html.="<tr>";
 		}
 		if($lable!='no')
 			$this->html .= $this->setlable($lable);
 	}
 	
 	function last(){
 		if($this->i % $this->cols !=0){
 			$this->html.="</tr>";
 		}
 		$this->i++;
 	}
 	
 	function _($label=""){
 		$this->first($label);
 		$this->html .= "<td>&nbsp;</td>";
 		$this->last();
 		return $this;
 	}
 	function setLable($lable=''){
 		return "<td ".(($lable!='')? "class='ui-widget-header'": "") ."><div class='label'>".(($lable!='')? $lable: "&nbsp;") ."</div></td>";
 	}
 	function focus($id=''){
 		$this->focus=$id;
 		if($id != '')
 			$script="\n\$(':input[name=\"$id\"]').focus();\n";
 		else
 			$script="\n\$(':input:visible:enabled:first').focus();\n";
		$this->ci->jq->addDomReadyScript($script);
 	}
 	function getAttribute($attrib, $tag){
		  //get attribute from html tag
		  $re = '/';
		  $re .= $attrib.'=["\']?([^"\']*)["\' ]/is';
		  @preg_match($re, $tag, $match);
		  if($match){
		    return urldecode($match[1]);
		  }else {
		    return false;
		  }
	}

        function dateBoxMultiSelect($lable,$attributes){
                $today=getNow("Y-m-d");
 		$this->first($lable);
 		$id=$this->getAttribute('name',$attributes);
                $id=$this->id."_".$id;
 		$this->html .= "<td><div class='input-container'><input type='text' ";
 		if(is_array($attributes)){
	 		foreach($attributes as $attr=>$val){
	 			$this->html .= "$attr='$val' ";
	 		}
 		}else{
 			$this->html .= $attributes;
 		}
 		$this->html .=" id='$id'/></div></td>";
 		$this->last();
 		$script="$('#$id').datepick({
                            dateFormat: 'yyyy-mm-dd',
                            changeMonth: false,
                            multiSelect: 31, monthsToShow: 1,
                            monthsToStep: 1,
                            
                            });"
                    ;
		$this->ci->jq->addDomReadyScript($script);
 		return $this;
 	}
 }
 
?>