<?php
/**
 * @package JV Headline module for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright (C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/
defined('JPATH_BASE') or die();

/**
 * Renders a list element
 *
 */

class JElementStylies extends JElement
{
	/**
	 * Element type
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'stylies';

	function fetchElement($name, $value, &$node, $control_name)
	{
		//Get value of layout style from database
		$db = &JFactory::getDBO();
		$cId = JRequest::getVar('cid','');
		if($cId !='') $cId = $cId[0];
		if($cId == ''){
			$cId = JRequest::getVar('id');
		}
		$sql = "SELECT params FROM #__modules WHERE id=$cId";
		$db->setQuery($sql);
		$paramsConfigObj = $db->loadObjectList();
		$db->setQuery($sql);
		$data = $db->loadResult();
		$params = new JParameter($data);
		$contentType = $params->get('content_type','content');
		$layoutStyle = $params->get('layout_style','jv_slide1');
		//End get value of layout style
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="inputbox"' );
		$options = array ();
		$val = "jv_slide1";
		$text = "JV News";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		$val = "jv_slide2";
		$text = "JV Eoty";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		$val = "jv_slide3";
		$text = "JV Lago";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		$val = "jv_slide4";
		$text = "JV Sello2";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		$val = "jv_slide5";
		$text = "JV Maju";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		$val = "jv_slide6";
		$text = "JV Sello1";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		$val = "jv_slide7";
		$text = "JV Slide7";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		$val = "jv_slide8";
		$text = "JV Pedon";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		$val = "jv_slide9";	
		$text = "JV Boro";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		$val = "jv_slide10";	
		$text = "JV Flow";
		$options[] = JHTML::_('select.option', $val, JText::_($text));
		?>
		<script type="text/javascript">	
		var jpaneAutoHeight = function(){
			 $$('.jpane-slider').each(function(item, i){
			      if(i == 0)item.setStyle('height','auto');				
			  });
			};
		  window.addEvent('load',function(){		     		     
		      setTimeout(jpaneAutoHeight, 400);	
		      var rowNewsHeight = $('paramsjv_news_thumbs').getParent().getParent();
		      for(i=0;i<=8;i++){
		    	  rowNewsHeight.addClass('jv_slide_stylenews');		    	  
		    	  rowNewsHeight = rowNewsHeight.getNext();		    	 
				  }
			  
			  	var rowJV2Width = $('paramsjv_eoty_thumbs').getParent().getParent();
			  	for(i=0;i<=11;i++){
			  		rowJV2Width.addClass('jv_slide_style2');
			  		rowJV2Width = rowJV2Width.getNext();
					}
					var rowJVLagoHeight = $('paramsjv_lago_thumbs').getParent().getParent();
					for(i=0;i<=14;i++){
						rowJVLagoHeight.addClass('jv_slide_stylelago');
						rowJVLagoHeight = rowJVLagoHeight.getNext();
					}
					var rowJVSello2Height = $('paramsjv_sello2_thumbs').getParent().getParent();
					for(i=0;i<=10;i++){
						rowJVSello2Height.addClass('jv_slide_stylesello2');
						rowJVSello2Height = rowJVSello2Height.getNext();
					}
					var rowJVSello1Width = $('paramsjv_sello1_thumbs').getParent().getParent();					
					for(i=0;i<=10;i++){
						rowJVSello1Width.addClass('jv_slide_stylesello1');
						rowJVSello1Width = rowJVSello1Width.getNext();
					}
					var rowJVMajuWidth = $('paramsjv_maju_thumbs').getParent().getParent();
					for(i=0;i<=9;i++){
						rowJVMajuWidth.addClass('jv_slide_stylemaju');
						rowJVMajuWidth = rowJVMajuWidth.getNext();
					}
					var rowJV7 = $('paramsjv_jv7_main_thumbs').getParent().getParent();
					for(i=0;i<=7;i++){
						rowJV7.addClass('jv_slide_style7');
						rowJV7 = rowJV7.getNext();
					}
					var rowJVPedon = $('paramsjv_pedon_thumbs').getParent().getParent();
					for(i=0;i<=8;i++){
						rowJVPedon.addClass('jv_slide_stylepedon');
						rowJVPedon = rowJVPedon.getNext();
					}
					var rowJVHead9 = $('paramsjv_jv9_main_thumbs').getParent().getParent();
					for(i=0;i<=6;i++){
						rowJVHead9.addClass('jv_slide_style9');
						rowJVHead9 = rowJVHead9.getNext();
					}
					var rowZTflow = $('paramszt_flow_thumbs').getParent().getParent();
					for(i=0;i<=9;i++){
						rowZTflow.addClass('jv_slide_styleflow');
						rowZTflow = rowZTflow.getNext();
					}
					var jvPedon = $$('.jv_slide_stylepedon');
					var jvNews = $$('.jv_slide_stylenews');
					var jvStyle2 = $$('.jv_slide_style2');	
					var jvLago = $$('.jv_slide_stylelago');     
					var jvSello2 = $$('.jv_slide_stylesello2');
					var jvSello1 = $$('.jv_slide_stylesello1'); 					
					var jvMaju = $$('.jv_slide_stylemaju');
					var jvStyle7 = $$('.jv_slide_style7');
					var jvStyle9 = $$('.jv_slide_style9');
					var jvFlow = $$('.jv_slide_styleflow');
          var layout = "<?php echo $layoutStyle; ?>";
          var content = "<?php echo $contentType; ?>"
		   var selectStyle = function(style){				
                 switch(style){               
					case "jv_slide1":				
				jvNews.each(function(item){
					item.setStyle('display','');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','none');
                });
              	jvLago.each(function(item){
					item.setStyle('display','none');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','none');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','none');
				});
				jvMaju.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','none');
				});
				jvFlow.each(function(item){
					item.setStyle('display','none');
				});
              	break;
			case "jv_slide2":
				jvNews.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','');
                });
              	jvLago.each(function(item){
					item.setStyle('display','none');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','none');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','none');
				});
				jvMaju.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','none');
				});
				jvFlow.each(function(item){
					item.setStyle('display','none');
				});
				break;
			case "jv_slide3":
				jvNews.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','none');
                });
              	jvLago.each(function(item){
					item.setStyle('display','');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','none');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','none');
				});
				jvMaju.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','none');
				});
				jvFlow.each(function(item){
					item.setStyle('display','none');
				});
				break;
			case "jv_slide4":
				jvNews.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','none');
                });
              	jvLago.each(function(item){
					item.setStyle('display','none');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','none');
				});
				jvMaju.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','none');
				});
				jvFlow.each(function(item){
					item.setStyle('display','none');
				});
				break;
			case "jv_slide5":
				jvNews.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','none');
                });
              	jvLago.each(function(item){
					item.setStyle('display','none');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','none');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','none');
				});
				jvMaju.each(function(item){
					item.setStyle('display','');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','none');
				});
				jvFlow.each(function(item){
					item.setStyle('display','none');
				});
				break;
			case "jv_slide6":
				jvNews.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','none');
                });
              	jvLago.each(function(item){
					item.setStyle('display','none');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','none');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','');
				});
				jvMaju.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','none');
				});
				jvFlow.each(function(item){
					item.setStyle('display','none');
				});
				break;
			case "jv_slide7":
				jvNews.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','none');
                });
              	jvLago.each(function(item){
					item.setStyle('display','none');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','none');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','none');
				});
				jvMaju.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','none');
				});
				jvFlow.each(function(item){
					item.setStyle('display','none');
				});
				break;
			case "jv_slide8":
				jvNews.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','none');
                });
              	jvLago.each(function(item){
					item.setStyle('display','none');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','none');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','none');
				});
				jvMaju.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','none');
				});
				jvFlow.each(function(item){
					item.setStyle('display','none');
				});
				break;
			case "jv_slide9":
				jvNews.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','none');
                });
              	jvLago.each(function(item){
					item.setStyle('display','none');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','none');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','none');
				});
				jvMaju.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','');
				});
				jvFlow.each(function(item){
					item.setStyle('display','none');
				});
				break;
			case "jv_slide10":
				jvNews.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvPedon.each(function(item){
					item.setStyle('display','none');
               	}.bind(this));
              	jvStyle2.each(function(item){
					item.setStyle('display','none');
                });
              	jvLago.each(function(item){
					item.setStyle('display','none');
                });
              	jvSello2.each(function(item){
					item.setStyle('display','none');
				});
              	jvSello1.each(function(item){
					item.setStyle('display','none');
				});
				jvMaju.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle7.each(function(item){
					item.setStyle('display','none');
				});
				jvStyle9.each(function(item){
					item.setStyle('display','none');
				});
				jvFlow.each(function(item){
					item.setStyle('display','');
				});
				break;
			}              
        };
        var selectContent = function(content){
        	if(content == 'content'){
        		$('paramsk2_category').getParent().getParent().setStyle('display','none');
        		$('paramscategories').getParent().getParent().setStyle('display','');
        	} else {
        		$('paramsk2_category').getParent().getParent().setStyle('display','');
        		$('paramscategories').getParent().getParent().setStyle('display','none');
        	} 
        };   
		selectStyle(layout);
		selectContent(content);	                           
		  $('paramslayout_style').addEvent('change',function(){
					selectStyle(this.value);                
		  });
		  $('paramscontent_type').addEvent('change',function(){
					selectContent(this.value);                
		  });		           
		  });		 
		</script>
		<?php	
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', $class, 'value', 'text', $value, $control_name.$name);
	}
}
?>