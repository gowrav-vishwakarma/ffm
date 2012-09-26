/*
# ------------------------------------------------------------------------
# ZT Menu Parameters plugin for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright(C) 2008-2011 www.zootemplate.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: ZooTemplate
# Websites: http://www.zootemplate.com
# ------------------------------------------------------------------------
*/

ZTFormController = new Class( { 
	initialize : function( control, options ){
		// options 
		this.options =  $extend({ hideRow:true }, options||{ } );
		this.groups = [];	
		var _default = '';
		var groups = this.getGroup( control );
		this._control = control;
		$('paramsmega_module_style').getParent().getParent().setStyle('display', 'none');
		if( $defined(groups) ) {
			groups._parent = this;
			groups.addEvents({'click': function(){
					if (this.tagName.toLowerCase() == 'select') return;					
					groups._parent.update(this.value);
					
					if(this.value != 0) $('paramsmega_module_style').getParent().getParent().setStyle('display', '');
					else $('paramsmega_module_style').getParent().getParent().setStyle('display', 'none');
				},
				'change': function() {
					if (this.tagName.toLowerCase() != 'select') return;
					groups._parent.update(this.value);
				}}
			);			
		}
		this.update(this._default);		
	},
	
	update: function(_default){
		this.items.each( function( item ) {
			if( item.tagName.toLowerCase() == 'label' ) return;
			if (!_default || (item.id && item.id.test ('-'+_default+'-'))){
				display = '';
				disabled = false;
			}else{
				display = 'none';
				disabled = true;
			}
			
			if( this.options.hideRow == true ) { 
				var parent = this.getParentByTagName(item, "tr" );
				if( $defined(parent) ){
					parent.setStyles({"display":display});
					if(display != 'none') $('paramsmega_module_style').getParent().getParent().setStyle('display', '');
				}
			}else {
				item.disabled = disabled;
			}
		}.bind(this) );
		
		this.updateHeight ();
	},
	
	getGroup: function (control) {
		var frm = document.forms['adminForm'];
		var obj = frm['params['+control+']'];
		if (!obj) return null;
		var objs;
		if (obj.tagName == 'SELECT') {
			objs = $(obj).getElements('option');
			this._tparent = this.getParentByTagName(obj, 'table');
			this._dparent = this.getParentByTagName(obj, 'div');
		} else {
			if (obj.length < 1) return null;			
			this._tparent = this.getParentByTagName(obj[0], 'table');
			this._dparent = this.getParentByTagName(obj[0], 'div');
			objs = obj = $$(obj);
		}
		objs.each (function(group){
			this.groups.push(group.value);
			if( group.selected || group.checked){ 
				this._default = group.value;
			}
		}.bind(this));
		
		this.items = $( document.adminForm ).getElements("*[id^=params"+control+"-"+"]");
		return obj;
	},
	
	updateHeight: function () {
		if (this._tparent && this._dparent && this._dparent.hasClass('content') && this._dparent.offsetHeight) this._dparent.setStyle('height', this._tparent.offsetHeight);
	},
	
	getParentByTagName: function (el, tag) {
		var parent = $(el).getParent();
		while (!parent || parent.tagName.toLowerCase() != tag.toLowerCase()) {
			parent = parent.getParent();
		}
		return parent;
	}
});

var ztparamhelpergroups = new Array();

function initztpramhelpergroup(control, options) {
	ztparamhelpergroups.push (new ZTFormController (control, options));
}

window.addEvent('load', function() {
	document.adminForm.onsubmit = function(){
		ztparamhelpergroups.each (function(group){
			if (!group.options.hideRow)	group.update();
		})
	};
	setTimeout(function() {
		//alert('hupdate height');
		
		ztparamhelpergroups.each (function(group){			
			if (group.options.hideRow)	group.updateHeight();
		});
	},400);
});

//window.addEvent ('load', function(){alert('hehe');this.updateHeight ();});