if( typeof(JVSlideEoty) == 'undefined' ){
var JVSlideEoty = new Class({
	options:{   
        duration: 2000,
		effect:'sliceDownLeft',
		slices:15,
        transition: Fx.Transitions.Quart.easeInOut,
		autoRun:true,
		directionNav:true,
		controlNav:true	
    },
	initialize:function(options){
		this.setOptions(options);
		this.vars = {
			currentSlide: 0,
			currentImage: '',
			totalSlides: 0,
			randEffect: '',
			running: false,
			paused: false,
			stop:false			
		};		
		this.container = $(this.options.container);
		this.childs = this.container.getElements('img');
		this.description = this.container.getElements('div.description');
		this.childs.setStyle('display','none');
		this.timer = '';
		this.fxItems = [];
		this.vars.totalSlides = this.childs.length;
		this.vars.currentImage = this.childs[this.vars.currentSlide];		
		this.container.setStyle('background','url('+ this.vars.currentImage.getProperty("src") +') no-repeat');		
		for(i=0;i<this.options.slices;i++){			
			var sliceWidth = Math.round(this.container.offsetWidth/this.options.slices);
			if(i == this.options.slices - 1 ) {
				var newSlide = new Element('div',{'styles':{			
					'left':sliceWidth*i,
					'width':this.container.offsetWidth-sliceWidth*i
				},'class':'eoty-slice'});
			} else {
				var newSlide = new Element('div',{'styles':{			
					'left':sliceWidth*i,
					'width':sliceWidth
				},'class':'eoty-slice'});	
			}
			newSlide.injectInside(this.container);	
		}
		if(this.options.directionNav){
			var directionNav = new Element('div',{'class':'eoty-directionNav'});
			var navPre = new Element('a',{'class':'eoty-prevNav'});
			navPre.setText('Prev');
			navPre.injectInside(directionNav);
			var navNext = new Element('a',{'class':'eoty-nextNav'});
			navNext.setText('Next');
			navNext.injectInside(directionNav);
			directionNav.injectInside(this.container);
		}
		//Description
		var desc = new Element('div',{'class':'eoty_des_wrap'});
		var descWrap = new Element('div',{'class':'eoty-caption'});
		desc.injectInside(descWrap);		
		desc.setHTML(this.description[0].innerHTML);
		descWrap.injectInside(this.container);
		//End
		this.descXX = this.container.getElement('div.eoty-caption .eoty_des_wrap');
		descWrap.setStyle('height',this.options.heightDesc);
		if(!this.options.enableDes) descWrap.setStyle('display','none');
		this.fxDesc = new Fx.Styles(this.descXX, {duration: 500, transition: Fx.Transitions.linear});
		if(this.options.directionNav) {
			//If click pre button
			this.container.getElement('a.eoty-prevNav').addEvent('click',function(){
				if(this.vars.running) return false;
				this.stop();
				this.vars.currentSlide-= 2;//Sub current slide 2 unit, cause function run effect increase 1
				//Call function run effect
				this.runEotySlide("prev");				
			}.bind(this));
			//End click pre button
			//If click next button
			this.container.getElement('a.eoty-nextNav').addEvent('click',function(){			
				if(this.vars.running) return false;//If effect's running 
				this.stop();
				this.runEotySlide("next");
			}.bind(this));
			//End click next button
			this.container.getElement('a.eoty-prevNav').addEvent('mouseleave',function(){
				this.container.getElement('a.eoty-prevNav').setStyle('opacity',1);
			}.bind(this));
			this.container.getElement('a.eoty-prevNav').addEvent('mouseenter',function(){
				this.container.getElement('a.eoty-prevNav').setStyle('opacity',0.4);
			}.bind(this));
			this.container.getElement('a.eoty-nextNav').addEvent('mouseleave',function(){
				this.container.getElement('a.eoty-nextNav').setStyle('opacity',1);
			}.bind(this));
			this.container.getElement('a.eoty-nextNav').addEvent('mouseenter',function(){
				this.container.getElement('a.eoty-nextNav').setStyle('opacity',0.4);
			}.bind(this));
		}
		//If auto run enable
		if(this.options.autoRun  && this.childs.length > 1){
			this.timer = this.runEotySlide.periodical(3000,this,[false]);
			//this.timer = setInterval(function(){ diloRun(slider, kids, settings, false); }, settings.pauseTime);
		}
		//End if		
		//If navigation enabled
		if(this.options.controlNav){
			var navigator = new Element('div',{'class':'eoty-controlNav'});
			navigator.injectInside(this.container);
			for(i=0;i<this.vars.totalSlides;i++){
				var navElement = new Element('a',{'class':'eoty-control'});
				navElement.setProperty('rel',i);
				navElement.setText(i+1);
				navElement.injectInside(navigator);
			}
			//Set active navigator selected and event click
			navigator.getElements('a.eoty-control').each(function(item,i){
				//Set active navigator selected
				if(i == this.vars.currentSlide) item.addClass('active');
				item.addEvent('click',function(){
					if(this.vars.running) return false;//If effect's running
					if(item.hasClass('active')) return false;
					this.stop();
					this.container.setStyle('background','url('+ this.vars.currentImage.getProperty('src') +') no-repeat');
					this.vars.currentSlide = item.getProperty('rel') - 1;
					this.runEotySlide('control');
				}.bind(this));
			}.bind(this));
			//End event click navigator
		}		
		//End navigation	
	},
	runEotySlide:function(flag){
		if(this.vars.stop && !flag) {
			return false;
		}
		if(!flag){
			this.container.setStyle('background','url('+ this.vars.currentImage.getProperty("src") +') no-repeat');	
		} else {
			if(flag == 'next' || flag == 'prev'){
				this.container.setStyle('background','url('+ this.vars.currentImage.getProperty("src") +') no-repeat');	
			}			
		}		
		this.vars.currentSlide++;
		if(this.vars.currentSlide == this.vars.totalSlides){ 
				this.vars.currentSlide = 0;
		}
		if(this.vars.currentSlide < 0) this.vars.currentSlide = (this.vars.totalSlides - 1);
		this.vars.currentImage = this.childs[this.vars.currentSlide];
		this.descXX.setStyle('opacity',0);
		if(this.options.controlNav){
			var navigator = this.container.getElements('.eoty-controlNav a');
			navigator.each(function(item,i){
				if(i !=this.vars.currentSlide) item.removeClass('active');
				else item.addClass('active');
			}.bind(this));
		}
		//Set new slide
		this.container.getElements('div.eoty-slice').each(function(item,i){
			var wSlice = Math.round(this.container.offsetWidth/this.options.slices);
			item.setStyles({'height':0,
							'opacity':0,
							'background': 'url('+ this.vars.currentImage.getProperty('src') +') no-repeat -'+ ((wSlice + (i * wSlice)) - wSlice) +'px 0%' 
						});	
						
		}.bind(this));
		//Run effect
		this.vars.running = true;	
		if(this.options.effect == 'random'){
			var eotyEffects = new Array("sliceDownRight","sliceDownLeft","sliceUpRight","sliceUpLeft","sliceUpDown","sliceUpDownLeft","fold","fade");
			this.vars.randEffect = eotyEffects[Math.floor(Math.random()*(eotyEffects.length + 1))];
			if(this.vars.randEffect == undefined) this.vars.randEffect = "fade";
		}
		if(this.options.effect == 'sliceDownLeft' || this.options.effect == 'sliceDown' || this.options.effect == 'sliceDownRight' || this.vars.randEffect  == 'sliceDownLeft'
			|| this.vars.randEffect == 'sliceDown' || this.vars.randEffect == 'sliceDownRight'){
			timeBuff = 0;
			var slides = this.container.getElements('div.eoty-slice');	
			if(this.options.effect == 'sliceDownLeft' || this.vars.randEffect == 'sliceDownLeft')slides = slides.reverse();
			//Init fxItems to run effect
			slides.each(function(item,i){
				this.fxItems[i] = new Fx.Styles(item, {duration: 500, transition: Fx.Transitions.linear});
			}.bind(this));
			//End init
			var objEffect = eval("({height:"+this.container.offsetHeight+",opacity:'1'})");
			slides.each(function(item,i){
				item.setStyle('top','0px');
				if(i == this.options.slices-1){						
						setTimeout(function(){
							this.fxItems[i].addEvent('onComplete',function(){this.finishFx();}.bind(this));
							this.fxStart(i,objEffect);						
						}.bind(this), (100 + timeBuff));
				} else {
						setTimeout(function(){
							this.fxStart(i,objEffect);							
						}.bind(this), (100 + timeBuff));
				}
				timeBuff += 50;
			}.bind(this));
		} else if(this.options.effect == 'sliceUp' || this.options.effect == 'sliceUpRight' || this.options.effect == 'sliceUpLeft' 
				|| this.vars.randEffect == 'sliceUp' || this.vars.randEffect == 'sliceUpRight' || this.vars.randEffect == 'sliceUpLeft'){
			timeBuff = 0;
			var slides = this.container.getElements('div.eoty-slice');
			var objEffect = eval("({height:"+this.container.offsetHeight+",opacity:'1'})");
			if(this.options.effect == 'sliceUpLeft' || this.vars.randEffect == 'sliceUpLeft') slides = slides.reverse();
			//Init fxItems to run effect
			slides.each(function(item,i){
				this.fxItems[i] = new Fx.Styles(item, {duration: 500, transition: Fx.Transitions.linear});
			}.bind(this));
			//End init
			slides.each(function(item,i){
				item.setStyle('bottom','0px');
				if(i == this.options.slices-1){						
						setTimeout(function(){
							this.fxItems[i].addEvent('onComplete',function(){this.finishFx();}.bind(this));
							this.fxStart(i,objEffect);						
						}.bind(this), (100 + timeBuff));
				} else {
						setTimeout(function(){
							this.fxStart(i,objEffect);							
						}.bind(this), (100 + timeBuff));
				}
				timeBuff += 50;
			}.bind(this));
		} else if(this.options.effect == 'sliceUpDown' || this.options.effect == 'sliceUpDownRight' || this.options.effect == 'sliceUpDownLeft' 
			|| this.vars.randEffect == 'sliceUpDown' || this.vars.randEffect == 'sliceUpDownRight' || this.vars.randEffect == 'sliceUpDownLeft'){
			timeBuff = 0;
			var j =0;			
			var slides = this.container.getElements('div.eoty-slice');
			if(this.options.effect == 'sliceUpDownLeft' || this.vars.randEffect == 'sliceUpDownLeft') slides = slides.reverse();
			//Init fxItems to run effect
			slides.each(function(item,i){
				this.fxItems[i] = new Fx.Styles(item, {duration: 500, transition: Fx.Transitions.linear});
			}.bind(this));
			//End init				
			var objEffect = eval("({height:"+this.container.offsetHeight+",opacity:'1'})");//{height:this.container.offsetHeight, opacity:'1'};
			slides.each(function(item,i){
				if(j==0){
					item.setStyle('top','0px');	
					j++;
				} else {
					item.setStyle('bottom','0px');	
					j=0;
				}				
				if(i == this.options.slices-1){						
						setTimeout(function(){
							this.fxItems[i].addEvent('onComplete',function(){this.finishFx();}.bind(this));
							this.fxStart(i,objEffect);						
						}.bind(this), (100 + timeBuff));
				} else {
						setTimeout(function(){
							this.fxStart(i,objEffect);							
						}.bind(this), (100 + timeBuff));
				}
				timeBuff += 50;
			}.bind(this));
		} else if(this.options.effect == 'fold' || this.vars.randEffect == 'fold'){
			timeBuff = 0;
			var slides = this.container.getElements('div.eoty-slice');					
			//Init fxItems to run effect
			slides.each(function(item,i){
				this.fxItems[i] = new Fx.Styles(item, {duration: 500, transition: Fx.Transitions.linear});
			}.bind(this));
			//End init
			slides.each(function(item,i){
				//item.setStyle('top','0px');
				var objEffect = eval("({width:"+item.offsetWidth+",opacity:'1'})");
				item.setStyles({ top:'0px', height:'100%', width:'0px' });
				if(i == this.options.slices-1){						
						setTimeout(function(){
							this.fxItems[i].addEvent('onComplete',function(){this.finishFx();}.bind(this));
							this.fxStart(i,objEffect);						
						}.bind(this), (100 + timeBuff));
				} else {
						setTimeout(function(){
							this.fxStart(i,objEffect);							
						}.bind(this), (100 + timeBuff));
				}
				timeBuff += 50;
			}.bind(this));
		} else if(this.options.effect == 'fade' || this.vars.randEffect == 'fade'){			
			var slides = this.container.getElements('div.eoty-slice');
			//Init fxItems to run effect
			slides.each(function(item,i){
				this.fxItems[i] = new Fx.Styles(item, {duration: 1000, transition: Fx.Transitions.linear});
			}.bind(this));
			//End init	
			slides.each(function(item,i){				
				var objEffect = eval("({opacity:'1'})");
				item.setStyle('height','100%');				
				if(i == this.options.slices-1){						
					this.fxItems[i].addEvent('onComplete',function(){this.finishFx();}.bind(this));
					this.fxStart(i,objEffect);					
				} else {						
					this.fxStart(i,objEffect);					
				}				
			}.bind(this));
		}
		//End
	},
	finishFx:function(){
		this.vars.running = false;
		this.descXX.setHTML(this.description[this.vars.currentSlide].innerHTML);
		this.fxDesc.stop().start({opacity:'0.8'});
		if(this.options.autoRun)  {
			this.stop();
			this.timer = this.runEotySlide.periodical(3000,this,[false]);
		}
	},
	fxStart:function(index,objEffect){	
		this.fxItems[index].stop().start(objEffect);		
	},
	stop:function(){
		$clear(this.timer);
	}
	
});
JVSlideEoty.implement(new Options);
JVSlideEoty.implement(new Events);
}
