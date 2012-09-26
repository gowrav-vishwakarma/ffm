//JS script for Joomla template
var siteurl = '';

window.addEvent('load', function(){

	var StyleCookie = new Hash.Cookie('ZTEvioStyleCookieSite');
	var settings = { colors: '' };
	var style_1, style_2, style_3;
	new Asset.css(StyleCookie.get('colors'));

	/* Style 1 */
	if($('ztcolor1')){$('ztcolor1').addEvent('click', function(e) {
		e = new Event(e).stop();
		if (style_1) style_1.remove();
		new Asset.css(ztpathcolor + 'blue.css', {id: 'blue'});
		style_1 = $('blue');
		settings['colors'] = ztpathcolor + 'blue.css';
		StyleCookie.empty();
		StyleCookie.extend(settings);
	});}

	/* Style 2 */
	if($('ztcolor2')){$('ztcolor2').addEvent('click', function(e) {
		e = new Event(e).stop();
		if (style_2) style_2.remove();
		new Asset.css(ztpathcolor + 'grey.css', {id: 'grey'});
		style_2 = $('grey');
		settings['colors'] = ztpathcolor + 'grey.css';
		StyleCookie.empty();
		StyleCookie.extend(settings);
	});}

	/* Style 3 */
	if($('ztcolor3')){$('ztcolor3').addEvent('click', function(e) {
		e = new Event(e).stop();
		if (style_3) style_3.remove();
		new Asset.css(ztpathcolor + 'red.css', {id: 'red'});
		style_3 = $('red');
		settings['colors'] = ztpathcolor + 'red.css';
		StyleCookie.empty();
		StyleCookie.extend(settings);
	});}
});