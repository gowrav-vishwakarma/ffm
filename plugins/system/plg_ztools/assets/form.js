/**
 * @package ZTools for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright(C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/

// JavaScript Document
window.addEvent('load', function(){
if($defined($$('.paramlist tr')) && $$('.paramlist tr').length > 0) {  
	var trs = $ES('.paramlist tr');
	
	trs.each(function(tr, index) {
		var tmp = tr.getElement('td.paramlist_value .zt-group')
		if(tmp && tmp.getProperty('title')){
			tr.addClass('group-'+tmp.getProperty('title')).addClass('icon-'+tmp.getProperty('title'));
			tr.setStyle('display', 'none');
			for(j=index+1; j < trs.length; j++){
				if( $defined(trs[j].getElement('td.paramlist_value .zt-end-group'))) {
					trs[j].remove();
					break;
				}
				trs[j].addClass('group-'+tmp.getProperty('title')).addClass('zt-group-tr');
				trs[j].setStyle('display', 'none');
			}
			var title = tmp.getProperty('title');
			tmp.enable= true;
		}
	});
}});
function show(group) {
	hide();
	$('nav-'+group).addClass('nav-active');
	$$('tr.group-'+group).setStyle('display', '');
}
function hide() {
	var groups = $(document.body).getElements('tr[class^=group-]');
	var navs   = $(document.body).getElements('div[id^=nav-]');
	
	groups.setStyle('display', 'none');
	navs.removeClass('nav-active');
}