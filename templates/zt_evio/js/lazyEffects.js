window.addEvent('load', function() {
	var div = Array("zt-user1", "zt-user2", "zt-user3", "zt-user4");
	var fx  = Array();
	var _start = 0.4;
	var _end   = 1;
	
	div.each(function(item, i) {
		if($(item) == null) return false;
		
		$(item).setStyle('opacity', _start);
		
		fx[i] = new Fx.Elements($(item), {wait: false, duration: 500, transition: Fx.Transitions.linear  , onComplete: function(){}});
		$(item).addEvent('mouseenter', function() {
			fx[i].start({
				'0': {'opacity': [_start, _end]}
			});
		});
		
		$(item).addEvent('mouseleave', function() {
			fx[i].start({
				'0': {'opacity': [_end, _start]}
			});
		});
	});
});