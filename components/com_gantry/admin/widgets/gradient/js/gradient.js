/**
 * @version   3.1.6 December 30, 2010
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

var GantryGradient = {
	init: function() {		
		var previews = $$('.gradient-preview');
		
		previews.each(function(preview) {
			new Element('div').setText('Sorry. Gradient previews can be seen only on WebKit and Gecko based browsers.').inject(preview.addClass('error'));
		});
	}
};