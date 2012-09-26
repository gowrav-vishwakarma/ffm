// JavaScript Document
var LadyOverlay = new Class({
	options: {
		id: 'lady_overlay',
		transition: Fx.Transitions.linear,
		duration: 350
	},
	
	initialize: function(el, options) {
		this.element = $(el); if (!this.element) return;
		this.setOptions(options);
		this.layout = $(this.options.id);
		this._close = $(el+'_close');
		
		this.element.addEvent('click', function(e) { this.toggle(e); }.bind(this));
		this._close.addEvent('click', function(e) { this.toggle(e); }.bind(this));
		
		this.overlay   = new Element("div").injectAfter(this.layout);
		this.overlay.setStyle('display', 'none');
		this.overlay.setStyles({'position': 'absolute', 'background': 'none repeat scroll 0 0 #000000', 
							   'visibility': 'hidden', 'left': 0, 'top': 0, 'z-index': 777, 'width': window.getWidth(), 'height': window.getHeight() + window.getScrollHeight()});
		
		this.fxoverlay = new Fx.Elements(this.overlay, {wait: false, duration: this.options.duration, 
								   transition: this.options.transition, onComplete: function(){}.bind(this)});
		this.OverlayEvents();
		
		this.hide();
	},
	
	toggle: function() {
		this[this.visible ? 'hide' : 'show']();
	},
	
	show: function() {
		this.layout.setStyles({'display': 'block', 'z-index': 9999, 'position': 'relative'});
		
		var lazy = new Fx.Elements(this.layout, {wait: false, duration: this.options.duration, 
								   transition: this.options.transition, onComplete: function(){}.bind(this)});
		lazy.start({'0' : {'opacity': [0, 1]}});
		
		//Show overlay
		this.overlay.setStyle('display', 'block');
		this.fxoverlay.start({'0' : {'opacity': [0, 0.5]}});
		
		this.visible = true;
	},
	
	hide: function() {
		this.layout.setStyles({'display': 'none', 'z-index': 0, 'position': 'relative'});
		var lazy = new Fx.Elements(this.layout, {wait: false, duration: this.options.duration, 
								   transition: this.options.transition, onComplete: function(){this.overlay.setStyles({'display': 'none'});}.bind(this)});
		lazy.start({'0' : {'opacity': [1, 0]}});		
		
		//Hide overlay
		this.fxoverlay.start({'0' : {'opacity': [0.5, 0]}});
		
		this.visible = false;
	},
	
	OverlayEvents: function() {
		/*document.addEvent('click', function() { 
			if(this.visible) this.hide(this.layout);
		}.bind(this));*/
		
		this.overlay.addEvent('click', function() {
			if(this.visible) this.hide(this.layout);
		}.bind(this));
		
		[this.element].each(function(el) {
			el.addEvents({
				'click': function(e) { new Event(e).stop(); },
				'keyup': function(e) {
					e = new Event(e);
					if(e.key == 'esc' && this.visible) this.hide(this.layout);
				}.bind(this)
			}, this);
		}, this);
	}
});
LadyOverlay.implement(new Options);
LadyOverlay.implement(new Events);