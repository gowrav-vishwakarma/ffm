var JVSlideBoro = new Class({
	options:{
		imageShadowStrength:0.5, //how dark should that shadow be, recommended values: between 0.3 and 0.8, allowed between 0 and 1
		moduleHeight:320,
		expandWidth:600,
		descHeight:80
	},
	initialize:function(options){
		this.setOptions(options);		
		this.slideName = "featured";
		this.arrImages = $(this.options.container).getElements("img");
		this.slides = $(this.options.container).getElements("div.featured");
		//this.desc = $(this.options.container).getElements("div.jv_headline_desc");
		this.fx = [];
		this.fxDesc = [];
		this.overlay_modifier = 200 *(1- this.options.imageShadowStrength);		
		this.slide_count = this.slides.length;
		this.slide_width = $(this.options.container).offsetWidth/this.slide_count;
		this.expand_slide 	= this.options.expandWidth;
		this.minimized_slide = ($(this.options.container).offsetWidth - this.expand_slide) / (this.slide_count - 1);
		this.dataSlides = [];
		this.arrSources = [];
		this.desc=[];
		this.headingClone=[];
		this.excerptWrapper = $(this.options.container).getElements(".feature_excerpt");				
		this.heading = $(this.options.container).getElements(".sliderheading");		
		this.currentIndex = -1;
		this.arrImages.each(function(item,i){
			item.setStyles({opacity:0, visibility:'hidden'});
			this.arrSources[i] = item.getProperty('src');
		}.bind(this));
		this.initSlide();			
		$(this.options.container).addEvent('mouseleave',function(){
			this.setDefaultSlide();
		}.bind(this));
	},	
	preLoad:function(){
		new Asset.images(this.arrSources,{
			onComplete:function(){
				this.arrImages.each(function(item,i){
					setTimeout(function(){	
					item.effects({duration: 400, transition: Fx.Transitions.linear}).start({'opacity': [0,1]});},400*(i+1));					
				}.bind(this));				
				this.actionSlide.delay(400*this.arrImages.length,this);				
			}.bind(this)
		})
	},
	initSlide:function(){
		//Init wrap description
		this.excerptWrapper.each(function(item){
			var child = item.clone();
			child.removeClass('feature_excerpt').addClass('position_excerpt');
			item.empty();
			child.setStyles({'opacity':0,'position':'absolute','bottom': '9px'});
			child.injectInside(item);
			item.setStyles({'opacity':0.8,'height':this.options.descHeight,'width':(this.expand_slide-30)});
			item.setOpacity(0.8);
		}.bind(this));
		this.excerpt = $(this.options.container).getElements("div.position_excerpt");
		//End wrap description
		//Init heading		
		this.heading.each(function(item,i){					
			item.setStyle('width',(this.slide_width-30).toString()+'px');
			var heading_height = item.offsetHeight;	
			var bottom = ((76-heading_height)/2).toString()+'px';		
			item.setStyles({'opacity':1,'bottom':bottom});
		}.bind(this));
		//End init heading		
		this.slides.each(function(item,i){
			this.dataSlides[i] = {};
			this.desc[i] = {};
			this.headingClone[i] = {};			
			var posWidth = parseInt(this.slide_width/2-8);			
			var posHeight = parseInt(this.options.moduleHeight/2-8);			
			item.setStyle('background-position',posWidth+'px '+ posHeight+'px');			
			this.fx[i] = new Fx.Styles(this.slides[i], {duration: 400, transition: Fx.Transitions.linear});
			this.desc[i] = new Fx.Styles(this.excerpt[i],{duration:400,wait:false});
			this.headingClone[i] = new Fx.Styles(this.heading[i],{duration:400,wait:false});			
			item.setStyles({zIndex:i+1, left: i * this.slide_width, width:this.slide_width+this.overlay_modifier});
			this.dataSlides[i].this_slides_position = i * this.slide_width;	
			this.dataSlides[i].pos_active_higher = i * this.minimized_slide;
			this.dataSlides[i].pos_active_lower = ((i-1) * this.minimized_slide) + this.expand_slide;			
		}.bind(this));		
		this.preLoad();
	},
	actionSlide:function(){
		this.slides.each(function(item,i){			
			item.addEvent(this.options.eventType,function(){				
				if(this.currentIndex !=i) {	
				this.fx[i].stop().start({'width':this.expand_slide+(this.overlay_modifier * 1.2),'left':this.dataSlides[i].pos_active_higher});					
				this.desc[i].stop().start({'opacity':1});
				this.headingClone[i].stop().start({'opacity':0});
				this.slides.each(function(item1,j){	
					if(i!=j){
					new_pos = this.dataSlides[j].pos_active_higher;
					if(i < j) { new_pos = this.dataSlides[j].pos_active_lower; }			
					this.fx[j].stop().start({'width':this.minimized_slide+this.overlay_modifier,'left':new_pos});
					this.desc[j].stop().start({'opacity':0});
					this.headingClone[j].stop().start({'opacity':1});
					}
				}.bind(this));			
				}
				this.currentIndex = i;
			}.bind(this));			
		}.bind(this));
	},
	//set mouseout event: expand all slides to no-slide-active position and width
	setDefaultSlide:function(){
		this.slides.each(function(item,i){
			new_pos = this.dataSlides[i].this_slides_position;
			this.fx[i].stop().start({'width':this.slide_width+this.overlay_modifier,'left':new_pos});
			this.desc[i].stop().start({'opacity':0});
			this.headingClone[i].stop().start({'opacity':1});			
		}.bind(this));
		this.currentIndex = -1;
	}	
});
JVSlideBoro.implement(new Events);
JVSlideBoro.implement(new Options);