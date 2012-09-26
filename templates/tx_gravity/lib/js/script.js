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

window.addEvent("domready",function(){        
    var $b = $(document.getElementsByTagName('body')[0]);
    // aniation classes - Fx.Height and Fx.Opacity
    Fx.Height = Fx.Style.extend({initialize: function(el, options){this.parent(el, 'height', options);this.element.setStyle('overflow', 'hidden');},toggle: function(){return (this.element.offsetHeight > 0) ? this.custom(this.element.offsetHeight, 0) : this.custom(0, this.element.scrollHeight);},show: function(){return this.set(this.element.scrollHeight);}});
    Fx.Opacity = Fx.Style.extend({initialize: function(el, options){this.now = 1;this.parent(el, 'opacity', options);},toggle: function(){return (this.now > 0) ? this.start(1, 0) : this.start(0, 1);},show: function(){return this.set(1);}});
    
    // help vars
    if($('popup_login')) var popup_login = new Fx.Opacity('popup_login', {duration: 250}).set(0);
    if($('popup_login')){
        $('popup_login').setStyle("display", "block");
        $('close_button_login').addEvent("click", function(){popup_login.start(0);});
    }
    // login
    if($('login_btn')) $('login_btn').addEvent("click", function(e){new Event(e).stop();popup_login.start(1);});
    if($('login_btn_noborder')) $('login_btn_noborder').addEvent("click", function(e){new Event(e).stop();popup_login.start(1);});    
});
    