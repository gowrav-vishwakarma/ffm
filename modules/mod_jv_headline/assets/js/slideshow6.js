var JVSlideShow6 = new Class({
	options:{
		delay:3000
	},
	initialize:function(options){ 		
		this.setOptions(options);
		this.slideImg = $$(this.options.slideImg);		
		this.slideBar = $$(this.options.slideBar);		
		this.descItem = $$(this.options.descItem);
		this.slideImgContainer = $(this.options.slideImgContainer);			
		this.currentIter = 0;	
		this.constructElement();	
		this.slideBar.each(function(item,i){
			item.addEvent('click',function(){this.goToByClick(i)}.bind(this));
		}.bind(this));
		if(this.options.showButNext == 1) {
			this.butNext = $$(this.options.butNext)[0];
			this.butPre = $$(this.options.butPre)[0];	
			this.butPre.addEvent('click',function(){this.preItem();}.bind(this));
			this.butPre.addEvent('mouseleave',function(){this.butPre.setStyle('opacity',1)}.bind(this));
			this.butPre.addEvent('mouseenter',function(){this.butPre.setStyle('opacity',0.5)}.bind(this));
			this.butNext.addEvent('click',function(){this.nextItem(true)}.bind(this));
			this.butNext.addEvent('mouseleave',function(){this.butNext.setStyle('opacity',1)}.bind(this));
			this.butNext.addEvent('mouseenter',function(){this.butNext.setStyle('opacity',0.5)}.bind(this));
		}
		this.info = new Fx.Style(this.descItem[0],'opacity', {duration:300});
        this.info.start(1);		
		this.timer = this.nextItem.delay(this.options.delay,this);			
	},	
	constructElement:function(){
		this.slideImg.each(function(item,i){
			item.setStyle('opacity',0);
		}.bind(this));
		this.slideImgContainer.removeClass('loading');
        this.slideImg[0].setStyle('opacity',1);
        this.slideBar[0].setStyle('opacity',1);
        this.maxIter = this.slideImg.length;        	
	},
	clearTimer:function(){
		$clear(this.timer);
	},
	prepareTimer:function(){		
		this.timer = this.nextItem.delay(this.options.delay, this);
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
    	this.info.stop();
    	//this.changeItem(num);
    	this.changeItem(num);
    	this.prepareTimer();   	    	   
    },   
	changeItem:function(num){		
		if (this.currentIter != num){
			var jv_current_num = parseInt(num);  
			if ((jv_current_num>1) && ($('jv_sello1_headline'+this.options.slideId+'_content_'+jv_current_num).getAttribute('rel'))) { 
				if(this.options.linkimg>0){ 
					$('jv_sello1_headline'+this.options.slideId+'_content_'+jv_current_num).innerHTML = '<a class="link'+this.options.slideId+'_'+jv_current_num+'" href="'+$$('a.link'+this.options.slideId+'_'+jv_current_num).getProperty('href')+'">'+$('jv_sello1_headline'+this.options.slideId+'_content_'+jv_current_num).getAttribute('rel')+'</a>';
					$('jv_sello1_headline'+this.options.slideId+'_content_'+jv_current_num).removeProperty('rel');
				}else{
					$('jv_sello1_headline'+this.options.slideId+'_content_'+jv_current_num).innerHTML = ''+$('jv_sello1_headline'+this.options.slideId+'_content_'+jv_current_num).getAttribute('rel');
					$('jv_sello1_headline'+this.options.slideId+'_content_'+jv_current_num).removeProperty('rel');
				}
			}
			this.slideBar.each(function(item,i){item.setStyle('opacity',0.5)}.bind(this));
			this.slideBar[num].setStyle('opacity',1);
			this.oldSlide = new Fx.Styles(this.slideImg[this.currentIter], {duration:this.options.slide6transition, wait: false});
            this.newSlide = new Fx.Styles(this.slideImg[num],{duration:this.options.slide6transition, wait: false});
            JVSlideShow6.Transitions[this.options.styleEffect].pass([
                this.oldSlide,
                this.newSlide,
                this.currentIter,
                num], this)();
             this.descItem.each(function(item,i){           
                item.setStyle('opacity',0);  
            }.bind(this));
            this.info = new Fx.Style(this.descItem[num],'opacity', {duration:300});
            this.info.start(1);
            this.currentIter = num;                                               
		}		
	},	 	  
	nextItem:function(wait){		
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
	preItem:function(){
		this.nextIter = this.currentIter-1;
		if (this.nextIter <= -1)
			this.nextIter = this.maxIter - 1;
		this.info.stop();
		this.clearTimer();				
        this.changeItem.delay(100,this,this.nextIter); 
        this.prepareTimer(); 	
		//this.goTo(this.nextIter);	
	}
});
JVSlideShow6.implement(new Events);
JVSlideShow6.implement(new Options);
JVSlideShow6.Transitions = new Abstract ({
    fade: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;
        oldFx.options.duration = newFx.options.duration = this.options.fadeDuration;
        if (newPos > oldPos) newFx.start({opacity: 1});
        else
        {
            newFx.set({opacity: 1});
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
JVSlideShow6.Transitions.extend({
    fadeslideleft: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.Cubic.easeOut;
        oldFx.options.duration = newFx.options.duration = 1000;      
        if (newPos > oldPos)
        {                   
            newFx.start({
                left: [this.options.slideWidth, 0],
                opacity: 1
            });
            oldFx.start({opacity: [1,0]});
        } else {
            newFx.start({opacity: [0,1]});
            oldFx.start({
                left: [0, this.options.slideWidth],
                opacity: 0
            }).chain(function(fx){fx.set({left: 0});}.pass(oldFx));
        }
    },
    fadeslideright: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.Cubic.easeOut;
        oldFx.options.duration = newFx.options.duration = 1000;
        if (newPos > oldPos)
        {
            newFx.start({opacity: [0,1]});
            oldFx.start({
                left: [0, this.options.slideWidth],
                opacity: 0
            }).chain(function(fx){fx.set({left: 0});}.pass(oldFx));
        } else {
            newFx.start({
                left: [this.options.slideWidth, 0],
                opacity: 1
            });
            oldFx.start({opacity: [1,0]});
        }
    },
    continuoushorizontal: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;               
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                left: [0, this.options.slideWidth * -1]
            });
            newFx.set({opacity: 1, left: this.options.slideWidth});
            newFx.start({
                left: [this.options.slideWidth, 0]
            });
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                left: [0, this.options.slideWidth]
            });
            newFx.set({opacity: 1, left: this.options.slideWidth * -1});
            newFx.start({
                left: [this.options.slideWidth * -1, 0]
            });
        }
    },
    continuoushorizontalright: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;       
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                left: [0, this.options.slideWidth]
            });
            newFx.set({opacity: 1, left: this.options.slideWidth * -1});
            newFx.start({
                left: [this.options.slideWidth * -1, 0]
            });
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                left: [0, this.options.slideWidth * -1]
            });
            newFx.set({opacity: 1, left: this.options.slideWidth});
            newFx.start({
                left: [this.options.slideWidth, 0]
            });
        }
    },
    continuousvertical: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;      
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                top: [0, this.options.slideHeight * -1]
            });
            newFx.set({opacity: 1, top: this.options.slideHeight});
            newFx.start({
                top: [this.options.slideHeight, 0]
            });
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                top: [0, this.options.slideHeight]
            });
            newFx.set({opacity: 1, top: this.options.slideHeight * -1});
            newFx.start({
                top: [this.options.slideHeight * -1, 0]
            });
        }
    },
    continuousverticalbuttom: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;       
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                top: [0, this.options.slideHeight]
            });
            newFx.set({opacity: 1, top: this.options.slideHeight * -1});
            newFx.start({
                top: [this.options.slideHeight * -1, 0]
            });
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                top: [0, this.options.slideHeight * -1]
            });
            newFx.set({opacity: 1, top: this.options.slideHeight});
            newFx.start({
                top: [this.options.slideHeight, 0]
            });
        }
    },
    jvslideshow: function(oldFx, newFx, oldPos, newPos){
        oldFx.options.transition = newFx.options.transition = Fx.Transitions.linear;       
         this.descItem.each(function(item,i){
                   this.descItem[i].setStyle('opacity',0);  
        }.bind(this));
        //var jvheight = this.galleryElement.offsetHeight;
        //alert(this.galleryElement.offsetHeight);
        if (
            ((newPos > oldPos) || ((newPos==0) && (oldPos == (this.maxIter-1) ))) &&
            (!((newPos == (this.maxIter-1 )) && (oldPos == 0)))
        ) {
            oldFx.set({opacity: 1});
            oldFx.start({
                opacity: [1, 0],
                top: [0, this.options.slideHeight]
            });
            newFx.set({
                opacity: 1,
                top: this.options.slideHeight * -1
            });
            newFx.start({
                opacity: [0, 1],
                top: [this.options.slideHeight, 0]
            });
        } else  {
            oldFx.set({opacity: 1});
            oldFx.start({
                opacity: [1, 0],
                top: [0, this.options.slideHeight]
            });
            newFx.set({
                opacity: 1,
                top: this.options.slideHeight
            });
            newFx.start({
                top: [this.options.slideHeight, 0]
            });
        }
    }

});

