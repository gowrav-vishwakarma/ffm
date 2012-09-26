var JVSlideShow5 = new Class({
	options:{},
	initialize:function(options){		
		this.setOptions(options);		
		this.jvSlide5Bg = $$(this.options.jvSlide5Bg);
		this.jvSlide5Menu = $$(this.options.jvSlide5Menu);	
		this.jvSlide5Info = $$(this.options.jvSlide5Info);	
		this.jvSlideMenuImg = $$(this.options.jvSlideMenuImg);
		this.jvSlide = $(this.options.jvSlide);		
		this.maxIter = this.jvSlide5Bg.length;		
		this.currentIter = 0;						
		this.constructElement();
		if(this.options.showButtonNext == 1) {
			this.butPre = $$(this.options.butPre)[0];
			this.butNext = $$(this.options.butNext)[0];
			this.butPre.addEvent('mouseleave',function(){this.butPre.setStyle('opacity',1)}.bind(this));
			this.butPre.addEvent('mouseenter',function(){this.butPre.setStyle('opacity',0.5)}.bind(this));
			this.butNext.addEvent('mouseleave',function(){this.butNext.setStyle('opacity',1)}.bind(this));
			this.butNext.addEvent('mouseenter',function(){this.butNext.setStyle('opacity',0.5)}.bind(this));
			this.butPre.addEvent('click',function(){this.previous(true);}.bind(this));
			this.butNext.addEvent('click',function(){this.next(true);}.bind(this));	
		}
		this.jvSlide.removeClass('loading');		    
        this.jvSlide5Menu.each(function(item,i){
        	item.addEvent('click',function(event){
        		event = new Event(event);        		
        		event.stop();
        		this.goToByClick(i);
        	}.bind(this));        	
        }.bind(this));     
        this.info = new Fx.Style(this.jvSlide5Info[0],'opacity', {duration:200});
        this.info.start(1);
        this.jvSlide5Menu[0].addClass('active');
        this.prepareTimer();         				
	},
	constructElement:function(){		
	   this.jvSlide5Bg.each(function(item,i){	   
		   	item.setStyles('position:absolute;left:0;right:0');
		   	item.setStyle('opacity',0);
			item.setStyle('display','');
	   }.bind(this));
	   this.jvSlide5Info.each(function(item,i){
			item.setStyle('opacity',0);
			item.setStyle('display','');	   	  
	   }.bind(this));
	   this.jvSlide5Bg[0].setStyle('opacity',1);
	   this.currInter = -1;	   
	},
	clearTimer:function(){
		$clear(this.timer);
	},
	prepareTimer:function(){		
		this.timer = this.next.periodical(this.options.transaction, this);
	},
	previous:function(wait){
		this.nextIter = this.currentIter-1;
        if (this.nextIter <= -1)
            this.nextIter = this.maxIter - 1;
        if(wait){
        	this.info.stop();
			this.clearTimer();				
        	this.changeItem.delay(100,this,this.nextIter); 
        	this.prepareTimer();
        	return; 	
        }    
        this.goTo(this.nextIter);    
	},
	next:function(wait){		
		this.nextIter = this.currentIter+1;
        if (this.nextIter >= this.maxIter)
            this.nextIter = 0;  
        if(wait){
        	this.info.stop();
			this.clearTimer();				
        	this.changeItem(this.nextIter); 
        	this.prepareTimer();
        	return; 	
        }                  
        this.goTo(this.nextIter);   
	},
	goToByClick:function(num){
		if(num !=this.currentIter) {		
			this.info.stop();
			this.clearTimer();				
	        this.changeItem(num); 
	        this.prepareTimer();             
		}
	},
	goTo:function(num){    	
    	this.clearTimer();     	
    	this.changeItem(num);    	
        this.prepareTimer();	    	
    },
    changeItem:function(num){
    	if (this.currentIter != num){
			var jv_current_num = parseInt(num);  
			if ((jv_current_num>1) && ($('jv_maju_headline'+this.options.slideId+'_content_'+jv_current_num).getAttribute('rel'))) { 
				if(this.options.linkimg>0){ 
					$('jv_maju_headline'+this.options.slideId+'_content_'+jv_current_num).innerHTML = '<a class="link'+this.options.slideId+'_'+jv_current_num+'" href="'+$$('a.link'+this.options.slideId+'_'+jv_current_num).getProperty('href')+'">'+$('jv_maju_headline'+this.options.slideId+'_content_'+jv_current_num).getAttribute('rel')+'</a>';
					$('jv_maju_headline'+this.options.slideId+'_content_'+jv_current_num).removeProperty('rel');
				}else{ 
					$('jv_maju_headline'+this.options.slideId+'_content_'+jv_current_num).innerHTML = ''+$('jv_maju_headline'+this.options.slideId+'_content_'+jv_current_num).getAttribute('rel');
					$('jv_maju_headline'+this.options.slideId+'_content_'+jv_current_num).removeProperty('rel');
				}
			}   
    		this.info.stop();    			   			
			this.oldSlide = new Fx.Styles(this.jvSlide5Bg[this.currentIter], {duration:this.options.durationSlide5, wait: false});
            this.newSlide = new Fx.Styles(this.jvSlide5Bg[num],{duration:this.options.durationSlide5, wait: false});
            JVSlideShow5.Transitions[this.options.jvStyleEffect].pass([
                this.oldSlide,
                this.newSlide,
                this.currentIter,
                num], this)();
            this.jvSlide5Info.each(function(item,i){
                   this.jvSlide5Info[i].setStyle('opacity',0);  
        	}.bind(this)); 
			this.jvSlide5Menu.removeClass('active');
			this.jvSlide5Menu[num].addClass('active');		
            this.currentIter = num;                                               
		}		
    }   
});
JVSlideShow5.implement(new Events);
JVSlideShow5.implement(new Options);

JVSlideShow5.Transitions = new Abstract ({
    fade: function(oldFx, newFx, oldPos, newPos){
    	this.jvSlide5Info.each(function(item,i){
                   this.jvSlide5Info[i].setStyle('opacity',0);  
        }.bind(this));
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;
        oldFx.options.duration = newFx.options.duration = this.options.fadeDuration;
        if (newPos > oldPos) newFx.start({opacity: 1});
        else
        {
            newFx.set({opacity: 1}).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
            oldFx.start({opacity: 0});
        }
    },
    crossfade: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;
        oldFx.options.duration = newFx.options.duration = this.options.fadeDuration;
        newFx.start({opacity: 1});
        oldFx.start({opacity: 0});
    },
    fadebg: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;
        oldFx.options.duration = newFx.options.duration = this.options.fadeDuration / 2;
        oldFx.start({opacity: 0}).chain(newFx.start.pass([{opacity: 1}], newFx));
    }
});
/**
 * @author jon
 */
JVSlideShow5.Transitions.extend({
    fadeslideleft: function(oldFx, newFx, oldPos, newPos){    	
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.Cubic.easeOut;
        oldFx.options.duration = newFx.options.duration = 1000; 
        this.jvSlide5Info.each(function(item,i){
                   this.jvSlide5Info[i].setStyle('opacity',0);  
        }.bind(this));       
        if (newPos > oldPos)
        {           	                
            newFx.start({
                left: [this.options.moduleWidth, 0],
                opacity: 1
            }).chain(function(){            	
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));
            oldFx.start({opacity: [1,0]});
        } else {
            newFx.start({opacity: [0,1]}).chain(function(){            	
            	this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));
            oldFx.start({
                left: [0, this.options.moduleWidth],
                opacity: 0
            }).chain(function(fx){fx.set({left: 0});}.pass(oldFx));
        }
    },
    fadeslideright: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.Cubic.easeOut;
        oldFx.options.duration = newFx.options.duration = 1000;
        this.jvSlide5Info.each(function(item,i){
                   this.jvSlide5Info[i].setStyle('opacity',0);  
        }.bind(this));
        if (newPos > oldPos)
        {
            newFx.start({opacity: [0,1]}).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
            oldFx.start({
                left: [0, this.options.moduleWidth],
                opacity: 0
            }).chain(function(fx){fx.set({left: 0});}.pass(oldFx));
        } else {
            newFx.start({
                left: [this.options.moduleWidth, 0],
                opacity: 1
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
            oldFx.start({opacity: [1,0]});
        }
    },
    continuoushorizontal: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;
        this.jvSlide5Info.each(function(item,i){
                   this.jvSlide5Info[i].setStyle('opacity',0);  
        }.bind(this));      
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                left: [0, this.options.moduleWidth * -1]
            });
            newFx.set({opacity: 1, left: this.options.moduleWidth});
            newFx.start({
                left: [this.options.moduleWidth, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;;
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                left: [0, this.options.moduleWidth]
            });
            newFx.set({opacity: 1, left: this.options.moduleWidth * -1});
            newFx.start({
                left: [this.options.moduleWidth * -1, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;;
        }
    },
    continuoushorizontalright: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;
        this.jvSlide5Info.each(function(item,i){
                   this.jvSlide5Info[i].setStyle('opacity',0);  
        }.bind(this));
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                left: [0, this.options.moduleWidth]
            });
            newFx.set({opacity: 1, left: this.options.moduleWidth * -1});
            newFx.start({
                left: [this.options.moduleWidth * -1, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                left: [0, this.options.moduleWidth * -1]
            });
            newFx.set({opacity: 1, left: this.options.moduleWidth});
            newFx.start({
                left: [this.options.moduleWidth, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
        }
    },
    continuousvertical: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;
        this.jvSlide5Info.each(function(item,i){
                   this.jvSlide5Info[i].setStyle('opacity',0);  
        }.bind(this));
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                top: [0, this.options.moduleHeight * -1]
            });
            newFx.set({opacity: 1, top: this.options.moduleHeight});
            newFx.start({
                top: [this.options.moduleHeight, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                top: [0, this.options.moduleHeight]
            });
            newFx.set({opacity: 1, top: this.options.moduleHeight * -1});
            newFx.start({
                top: [this.options.moduleHeight * -1, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
        }
    },
    continuousverticalbuttom: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;
        this.jvSlide5Info.each(function(item,i){
                   this.jvSlide5Info[i].setStyle('opacity',0);  
        }.bind(this));
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                top: [0, this.options.moduleHeight]
            });
            newFx.set({opacity: 1, top: this.options.moduleHeight * -1});
            newFx.start({
                top: [this.options.moduleHeight * -1, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                top: [0, this.options.moduleHeight * -1]
            });
            newFx.set({opacity: 1, top: this.options.moduleHeight});
            newFx.start({
                top: [this.options.moduleHeight, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
        }
    },
    jvslideshow: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;
        this.jvSlide5Info.each(function(item,i){
                   this.jvSlide5Info[i].setStyle('opacity',0);  
        }.bind(this));
        //var jvheight = this.options.moduleHeight;
        //alert(this.options.moduleHeight);
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                opacity: [1, 0],
                top: [0, this.options.moduleHeight]
            });
            newFx.set({
                opacity: 1,
                top: this.options.moduleHeight * -1
            });
            newFx.start({
                opacity: [0, 1],
                top: [this.options.moduleHeight, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                opacity: [1, 0],
                top: [0, this.options.moduleHeight]
            });
            newFx.set({
                opacity: 1,
                top: this.options.moduleHeight
            });
            newFx.start({
                top: [this.options.moduleHeight, 0]
            }).chain(function(){
                this.info = new Fx.Style(this.jvSlide5Info[newPos],'opacity', {duration:200});
                this.info.start(1);
            }.bind(this));;
        }
    }
});
