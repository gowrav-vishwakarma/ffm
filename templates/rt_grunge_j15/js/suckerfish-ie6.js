/**
 * @version		1.5.2 January 10, 2011
 * @author		RocketTheme, LLC http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license		http://www.rockettheme.com/legal/license.php RocketTheme Proprietary Use License
 */

var sfHover=function(B,C){if(!C){C="sfHover";}var A=$$(B).getElements("li");if(!A.length){return false;}A.each(function(D){D.addEvents({mouseenter:function(){var F=this.getProperty("class").split(" ");F=F.filter(function(G){return !G.test("-"+C);});F.each(function(G){if(this.hasClass(G)){this.addClass(G+"-"+C);}},this);var E=F.join("-")+"-"+C;if(!this.hasClass(E)){this.addClass(E);}this.addClass(C);},mouseleave:function(){var F=this.getProperty("class").split(" ");F=F.filter(function(G){return G.test("-"+C);});F.each(function(G){if(this.hasClass(G)){this.removeClass(G);}},this);var E=F.join("-")+"-"+C;if(!this.hasClass(E)){this.removeClass(E);}this.removeClass(C);}});});};window.addEvent("domready",function(){sfHover("ul.menu");});