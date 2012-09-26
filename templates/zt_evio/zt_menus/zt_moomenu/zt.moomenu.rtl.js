var subnav = new Array();
Element.extend(
{
	doActive: function () {
		this.className+='hover';
	},

	doDeactive: function () {
		this.className=this.className.replace(new RegExp("hover\\b"), "");
	},
	
	hide: function(timeout) 
	{
		this.status = 'hide';
		clearTimeout (this.timeout);
		if (timeout)
		{
			this.timeout = setTimeout (this.animation.bind(this), timeout);
		}else{
			this.animation();
		}
	},
			
	show: function(timeout) 
	{
		this.status = 'show';
		clearTimeout (this.timeout);
		if (timeout)
		{
			this.timeout = setTimeout (this.animation.bind(this), timeout);
		}else{
			this.animation();
		}
	},

	animation: function() {
	
		if ((this.status == 'hide' && this.style.right != 'auto') || (this.status == 'show' && this.style.right == 'auto' && !this.hidding)) return;
		this.setStyle('overflow', 'hidden');
		if (this.status == 'show') {
			this.hidding = 0;
			this.hideAll();
		} 
		if (this.status == 'hide')
		{
			this.hidding = 1;
			this.myFx2.stop();
			if (this.parent._id) this.myFx2.start(this.offsetWidth,0);
			else this.myFx2.start(this.offsetHeight,0);
		} else {
			this.setStyle('right', 'auto');
			this.setStyle('display', 'block');
			this.myFx2.stop();
			if (this.parent._id) this.myFx2.start(0,(this.menuwidth));
			else this.myFx2.start(0,(this.menuheight));
		}
	},

	init: function() {
		this.menuwidth = this.clientWidth;
		this.menuheight = this.clientHeight;
		if (this.parent._id)
		{
			this.myFx2 = new Fx.Style(this, 'width', {duration: 350});
			this.myFx2.set(0);
		}else{
			this.myFx2 = new Fx.Style(this, 'height', {duration: 350});
			this.myFx2.set(0);
		}
		this.setStyle('right', '0px');
		animationComplete = function(){
			if (this.status == 'hide')
			{
				this.setStyle('right', '0px');
				this.setStyle('display', 'none');
				this.hidding = 0;
			}
			this.setStyle('overflow', '');
		};
		this.myFx2.addEvent ('onComplete', animationComplete.bind(this));
	},

	hideAll: function() {
		for(var i=0;i<subnav.length; i++) {
			if (!this.isChild(subnav[i]))
			{
				subnav[i].hide(0);
				subnav[i].setStyle('display', 'none');
			}
		}
	},

	isChild: function(_obj) {
		obj = this;
		while (obj.parent)
		{
			if (obj._id == _obj._id) return true;
			obj = obj.parent;
		}
		return false;
	}
});


var MooMenu = new Class({	
	initialize: function(element)
	{
		$A($(element).childNodes).each(function(el)
		{
			if(el.nodeName.toLowerCase() == 'li')
			{
				$A($(el).childNodes).each(function(el2)
				{
					if(el2.nodeName.toLowerCase() == 'ul')
					{
						$(el2)._id = subnav.length+1;
						$(el2).parent = $(element);
						subnav.push ($(el2));
						el2.init();
						el.addEvent('mouseover', function()
						{
							el.doActive();
							el2.show(0);
							return false;
						});

						el.addEvent('mouseout', function()
						{
							el.doDeactive();
							el2.hide(20);
						});
						new MooMenu(el2);
						el.hasSub = 1;
						el2.setStyle('display', 'none');
					}
				});
				if (!el.hasSub)
				{
					el.addEvent('mouseover', function()
					{
						el.doActive();
						return false;
					});

					el.addEvent('mouseout', function()
					{
						el.doDeactive();
					});
				}
			}
		});
		return this;
	}
});

window.addEvent('load',function() {new MooMenu($('menusys_moo'))});