var JVSlideShow7 = new Class({
	options:{
		delay:3000
	},
	initialize:function(options){
		this.setOptions(options);
		this.container = $(this.options.container);
		this.slideMain = $$(this.options.slideMain)[0];		
		this.slideItem = $$(this.options.slideItem);
		this.butPre = $$(this.options.butPre)[0];
		this.butNext = $$(this.options.butNext)[0];
		this.slideDes = $$(this.options.slideDes);
		this.mainSpace = 10;
		if(this.options.showButNext == 1) {
			this.butPre.addEvent('click',function(){this.previous(true)}.bind(this));
			this.butNext.addEvent('click',function(){this.next(true)}.bind(this));
		}
		this.constructElement();	
		this.slideMain.getChildren()[0].clone().inject(this.slideMain);
		window.addEvent('domready', function(){
			childrenSlide = this.slideMain.getChildren()[this.slideItem.length-1].getChildren().getChildren();
			childrenSlide.each(function(el){
				if(el.getProperty('rel')){
					if(this.options.linkimg>0){
						el.getChildren().each(function(ael){
							ael.setHTML(el.getProperty('rel'));
							el.removeProperty('rel');
						});
					}else{
						el.setHTML(el.getProperty('rel'));
						el.removeProperty('rel');
					}
				}
			}.bind(this));
		}.bind(this)); 
        this.slideMain.getChildren()[this.slideItem.length-1].clone().injectTop(this.slideMain);
        this.slideMain.setStyle('width',(this.sizeSlideItem*(this.slideItem.length+2)+200)+'px'); 
        if(this.options.autoRun) this.prepareTimer();            		
	},
	constructElement:function(){
		this.currentIndex = 0;
		this.maxIter = this.slideItem.length;
		//Set height for jv slide7 container
		this.container.setStyles({'width':'100%','height':this.options.mainHeight});
		//Set width and height for slide item
		this.slideItem.each(function(item,i){
			item.setStyles({'width':this.options.mainWidth, 'height':this.options.mainHeight});
			item.setStyle('margin-right', this.mainSpace);
		}.bind(this));
		//Set width of slide in left and right 
		this.slideBarWidth = Math.ceil((this.container.offsetWidth - this.options.mainWidth)/2) - this.mainSpace;
		//Set style for left and right slide 
		if(this.options.showButNext == 1){
			this.butPre.setStyles({'opacity':0.4,'width':this.slideBarWidth,'height':this.options.mainHeight});
			this.butPre.addEvent('mouseleave',function(){this.butPre.setStyle('opacity',0.4)}.bind(this));
			this.butPre.addEvent('mouseenter',function(){this.butPre.setStyle('opacity',0.2)}.bind(this));
			this.butNext.setStyles({'opacity':0.4,'width':this.slideBarWidth,'height':this.options.mainHeight});
			this.butNext.addEvent('mouseleave',function(){this.butNext.setStyle('opacity',0.4)}.bind(this));
			this.butNext.addEvent('mouseenter',function(){this.butNext.setStyle('opacity',0.2)}.bind(this));
		}
		//End set style for left and right slide	
		this.initSlide();
	},
	initSlide:function(){		
		//Set width and height for main slide when first load		
		this.sizeSlideItem = this.options.mainWidth + this.mainSpace;
		this.offset = this.slideBarWidth - this.options.mainWidth;
		this.slideMain.setStyles({'width':this.sizeSlideItem*this.slideItem.length+200+'px','left':(-this.currentIndex*this.sizeSlideItem)+this.offset+'px'});		
		this.fx = new Fx.Style(this.slideMain,'left',{duration:this.options.slide7Duration,transition: Fx.Transitions.Back.easeOut,wait:false});
		this.slideDes[0].setStyles({'display': 'block', 'position':'absolute', 'bottom': '0px','opacity':0.7, 'left': this.slideBarWidth+10+'px', 'width':this.options.mainWidth+'px','color':'#FFFFFF'});
		this.slideDes[0].effects({duration:this.options.slide7Duration,transition: Fx.Transitions.Sine.easeInOut}).start({'height': [0,70]});
	},
	previous:function(wait){
		this.nextIter = this.currentIndex-1;
        if (this.nextIter <= -1)
            this.nextIter = this.maxIter - 1;
        this.goTo(this.nextIter,wait);    
	},
	next:function(wait){		
		this.nextIter = this.currentIndex+1;
        if (this.nextIter >= this.maxIter)
            this.nextIter = 0;           
        this.goTo(this.nextIter,wait);   
	},
	clearTimer:function(){
        $clear(this.timer);
    },
    prepareTimer:function(){
    	this.clearTimer();        
        this.timer = this.next.periodical(this.options.slide7Delay, this,false);
    },
    goTo:function(num,wait){    	
    	if(wait) this.clearTimer();
		var jv_current_num = parseInt(num);  
			if ((jv_current_num>1) && (document.getElement('div.jv_slide7_headline'+this.options.slideId+'_content_'+jv_current_num).getAttribute('rel'))) { 
				if(this.options.linkimg>0){ 
					document.getElement('div.jv_slide7_headline'+this.options.slideId+'_content_'+jv_current_num).innerHTML = '<a class="link'+this.options.slideId+'_'+jv_current_num+'" href="'+document.getElement('a.link'+this.options.slideId+'_'+jv_current_num).getProperty('href')+'">'+document.getElement('div.jv_slide7_headline'+this.options.slideId+'_content_'+jv_current_num).getAttribute('rel')+'</a>';
					document.getElement('div.jv_slide7_headline'+this.options.slideId+'_content_'+jv_current_num).removeProperty('rel');
				}else{ 
					document.getElement('div.jv_slide7_headline'+this.options.slideId+'_content_'+jv_current_num).innerHTML = ''+document.getElement('div.jv_slide7_headline'+this.options.slideId+'_content_'+jv_current_num).getAttribute('rel');
					document.getElement('div.jv_slide7_headline'+this.options.slideId+'_content_'+jv_current_num).removeProperty('rel');
				}
			}   
    	this.slideDes.each(function(item,i){item.setStyles({'height':0,'opacity':0})}.bind(this));  	    	 
    	this.fx.start(-num*this.sizeSlideItem + this.offset).chain(function(){
    		this.slideDes[num].setStyles({'display': 'block', 'position':'absolute', 'bottom': '0px','opacity':0.7, 'left': this.slideBarWidth+10+'px', 'width':this.options.mainWidth+'px','color':'#FFFFFF'});
            this.slideDes[num].effects({duration:this.options.slide7Duration,transition: Fx.Transitions.Sine.easeInOut}).start({'height': [0,70]});
    	}.bind(this));    	    	
    	this.currentIndex = num;
        if(wait && this.options.autoRun) this.prepareTimer();	    	
    }
});
JVSlideShow7.implement(new Events);
JVSlideShow7.implement(new Options);
