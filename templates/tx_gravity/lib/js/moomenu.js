/**
 * @package   ZOE Template Framework by ThemExpert
 * @version   2.5.0 June 01, 2010
 * @author    ThemExpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2010 ThemExpert LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 * 
 * This Framework uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 * 
 */
if(typeof(MooTools)!='undefined'){var subnav=new Array();Element.extend({hide:function(timeout)
{this.status='hide';clearTimeout(this.timeout);if(timeout)
{this.timeout=setTimeout(this.anim.bind(this),timeout);}else{this.anim();}},show:function(timeout)
{this.status='show';clearTimeout(this.timeout);if(timeout)
{this.timeout=setTimeout(this.anim.bind(this),timeout);}else{this.anim();}},setActive:function(){this.className+='sfhover';},setDeactive:function(){this.className=this.className.replace(new RegExp("sfhover\\b"),"");},anim:function(){if((this.status=='hide'&&this.style.left!='auto')||(this.status=='show'&&this.style.left=='auto'&&!this.hidding))return;this.setStyle('overflow','hidden');if(this.status=='show'){this.hidding=0;this.hideAll();}else{}
if(this.status=='hide')
{this.hidding=1;this.myFx2.stop();if(this.parent._id)this.myFx2.start(this.offsetWidth,0);else this.myFx2.start(this.offsetHeight,0);}else{this.setStyle('left','auto');this.myFx2.stop();if(this.parent._id)this.myFx2.start(0,this.mw);else this.myFx2.start(0,this.mh);}},init:function(){this.mw=this.clientWidth;this.mh=this.clientHeight;if(this.parent._id)
{this.myFx2=new Fx.Style(this,'width',{duration:300});this.myFx2.set(0);}else{this.myFx2=new Fx.Style(this,'height',{duration:300});this.myFx2.set(0);}
this.setStyle('left','-999em');animComp=function(){if(this.status=='hide')
{this.setStyle('left','-999em');this.hidding=0;}
this.setStyle('overflow','');}
this.myFx2.addEvent('onComplete',animComp.bind(this));},hideAll:function(){for(var i=0;i<subnav.length;i++){if(!this.isChild(subnav[i]))
{subnav[i].hide(0);}}},isChild:function(_obj){obj=this;while(obj.parent)
{if(obj._id==_obj._id)
{return true;}
obj=obj.parent;}
return false;}});var DropdownMenu=new Class({initialize:function(element)
{$A($(element).childNodes).each(function(el)
{if(el.nodeName.toLowerCase()=='li')
{$A($(el).childNodes).each(function(el2)
{if(el2.nodeName.toLowerCase()=='ul')
{$(el2)._id=subnav.length+1;$(el2).parent=$(element);subnav.push($(el2));el2.init();el.addEvent('mouseover',function()
{el.setActive();el2.show(0);return false;});el.addEvent('mouseout',function()
{el.setDeactive();el2.hide(20);});new DropdownMenu(el2);el.hasSub=1;}});if(!el.hasSub)
{el.addEvent('mouseover',function()
{el.setActive();return false;});el.addEvent('mouseout',function()
{el.setDeactive();});}}});return this;}});Window.onDomReady(function(){new DropdownMenu($E('#tx-navigation ul.menu'))});}else{sfHover=function(){var sfEls=document.getElementById("tx-navigation").getElementsByTagName("li");for(var i=0;i<sfEls.length;++i){sfEls[i].onmouseover=function(){this.className+="sfhover";}
sfEls[i].onmouseout=function(){this.className=this.className.replace(new RegExp("sfhover\\b"),"");}}}
if(window.attachEvent)window.attachEvent("onload",sfHover);}