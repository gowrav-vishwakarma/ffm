var ZT_Flow = new Class({
	Implements: [Events, Options],
	options:{},
	initialize:function(options){		
		this.setOptions(options);
		this.container = $$(this.options.ztContainer);
		this.items = $$(this.options.items);
        this.content = $$(this.options.content);
        this.pagenext = $$(this.options.pagenext)[0];
        this.currentIter = 0;
		if(this.options.shownext >0){
			this.pagenext.addEvent('click',function(){this.next(true);}.bind(this));
		}
        this.items.each(function(item,i){
        	item.addEvent('click',function(event){
        		event = new Event(event);        		
        		event.stop();
        		this.slideContainer(i);
        	}.bind(this));        	
        }.bind(this));
        this.content[0].setStyles({
            'visibility': 'visible',
            'opacity': 1
        });
		this.items.each(function(item, numb){
			this.items[numb].effects({duration:1000-(numb*100),transition: Fx.Transitions.Sine.easeOut, onComplete: function(){}}).start({
				'opacity': [0, (100-(numb*10))/100],
				'width': this.options.imgwidth-(numb*32.3),
				'height': this.options.imgheight-(numb*28.3),
				'left': 10+((numb*70.5)/1.6),
				'top': 5-(numb*(-10.5-(numb)))
			});
		}.bind(this));  
        if(this.options.auto==1){
            this.prepareTimer();
        }
	},
	clearTimer:function(){
		$clear(this.timer);
	},
    prepareTimer:function(){
		this.timer = this.next.periodical(this.options.transaction, this);
	},
	goTo:function(num){    	
    	this.clearTimer();     	
    	this.slideContainer(num);    	
        this.prepareTimer();	    	
    },
    slideContainer: function(num){
        var itemSlected = 50 - this.items[num].getStyle("z-index");
        var zt_int = parseInt(this.items[num].getStyle("z-index"));
        this.items.each(function(element, n){
            var zt_int = parseInt(this.items[n].getStyle("z-index"));
            if(zt_int == 50){
                this.items[n].setStyle("z-index", 50-(this.items.length-1)); 
				for (z=this.items.length-1;z>=0;z--) { 
					if(z==(this.items.length-1)){
						ztWidth = this.options.imgwidth-(z*32.3);
						ztHeight = this.options.imgheight-(z*28.3)
						ztLeft = 10+((z*70.5)/1.6);
						ztTop = 5-(z*(-10.5-(z)));
					}
				}
				zt_slideFlow = new Fx.Styles(this.items[n], {duration:500, wait: false});
                zt_slideFlow.start({
					opacity: [0.8, 0.5],
					width: [this.options.imgwidth, ztWidth],
					height: [this.options.imgheight, ztHeight],
					left: [10, ztLeft],
					top: [5, ztTop]
				});
				
            }else{ 
                var zt_getint = 50-(zt_int+1);
				this.items[n].setStyle("z-index", zt_int+1);
				zt_slideFlow = new Fx.Styles(this.items[n], {duration:500, wait: false});
                zt_slideFlow.start({
					opacity: (100-(zt_getint*10))/100,
					width: this.options.imgwidth-(zt_getint*32.3),
					height: this.options.imgheight-(zt_getint*28.3),
					left: 10+((zt_getint*70.5)/1.6),
					top: 5-(zt_getint*(-10.5-(zt_getint)))
				});
            }
            if(this.items[n].getStyle("z-index")==50){
                this.content.each(function(element, j){
                    if(n==j){
                        zt_slideContent = new Fx.Style(this.content[j],'opacity', {duration:500, wait: false});
                        zt_slideContent.start(1);
                    }else{
                        zt_slideContent = new Fx.Style(this.content[j],'opacity', {duration:500, wait: false});
                        zt_slideContent.start(0);
                    }
                }.bind(this));
                this.currentIter=n;
            }
        }.bind(this));
        if(itemSlected == 0){
            return;
        }
        if(itemSlected != 1){ 
            setTimeout(function(){this.slideContainer(num)}.bind(this), 150);
        }
	},
	next:function(wait){
		this.nextIter = this.currentIter;
        if (this.nextIter >= this.maxIter)
            this.nextIter = 0;  
        if(wait){ 
			this.clearTimer();				
        	this.slideContainer(this.nextIter);
            if(this.options.auto==1){
                this.prepareTimer();
            }
        	return; 	
        }                  
        this.goTo(this.nextIter);   
	}
});
ZT_Flow.implement(new Events);
ZT_Flow.implement(new Options);
