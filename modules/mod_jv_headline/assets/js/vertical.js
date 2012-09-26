var JVVerHeadLine = new Class({
    options:{   
        duration: 2000,
        transition: Fx.Transitions.Quart.easeInOut        
    },
    initialize:function(){
        $each(arguments, function(argument, i){                   
            switch($type(argument)){
                case 'object': options = argument; break;                                
            }
        });
        this.fx = [];                
        this.setOptions(options);
        this.counter = -1;
        this.activeSlide = 0;
        this.nextSlide = 0;     
      
        this.slideOuter = $$(this.options.slideOuter);          
        this.slideBarItem = $$(this.options.slideBarItem);      
        this.slideOuter.each(function(item,i){
            item.setStyle('opacity',0);
        });                           
        this.slideBarItem.each(function(item,i){        
            item.addEvent('mouseenter',function(e){
                item.addClass('slideactive1');
            });
            item.addEvent('mouseleave',function(e){
                item.removeClass('slideactive1');
            });
            item.addEvent('click',function(e){               
                this.changeSlideByClick(i);             
            }.bind(this));
        }.bind(this)) ;  
               
        this.changeSlide();        
        this.slideTime = this.changeSlide.periodical(this.options.slideDelay,this);       
    },
    changeSlide:function(){
        var obj= {};        
        if(this.counter !=-1){              
        if(this.counter != this.slideOuter.length - 1) {
            this.activeSlide = this.counter;
            this.nextSlide = this.counter + 1;          
        } else { 
            this.activeSlide = this.counter;
            this.nextSlide = 0;         
        }       
        this.slideOuter.each(function(item,i){
                if(this.slideOuter[i].fx){this.slideOuter[i].fx.stop();}
        }.bind(this));     
        (this.slideOuter)[this.activeSlide].fx = (this.slideOuter)[this.activeSlide].effect('opacity', {duration: this.options.duration,wait:false}).start(0);
        (this.slideOuter)[this.nextSlide].fx = (this.slideOuter)[this.nextSlide].effect('opacity', {duration: this.options.duration,wait:false}).start(1);             
        (this.slideBarItem)[this.activeSlide].removeClass('slideactive');
        (this.slideBarItem)[this.nextSlide].addClass('slideactive');              
       if(this.counter == this.slideOuter.length - 1) {this.counter=0;} else { this.counter++;} 
    }else { 
        this.slideBarItem[0].addClass('slideactive');             
       this.slideOuter[0].setStyle('opacity',1);            
       this.counter = 0;    
    }   
    },
    changeSlideByClick:function(i){     
        if(this.counter !=i){                   
            this.counter = i;
            this.slideOuter.each(function(item,i){
            	if(this.slideOuter[i].fx){this.slideOuter[i].fx.stop();}
            }.bind(this));          
            (this.slideOuter)[this.nextSlide].fx = (this.slideOuter)[this.nextSlide].effect('opacity', {duration: this.options.duration,wait:false}).start(0);
            (this.slideOuter)[i].fx  = (this.slideOuter)[i].effect('opacity', {duration: this.options.duration,wait:false}).start(1);
            (this.slideBarItem)[this.nextSlide].removeClass('slideactive');         
            (this.slideBarItem)[i].addClass('slideactive');            
            this.nextSlide = i;
            $clear(this.slideTime);
            this.slideTime = this.changeSlide.periodical(this.options.slideDelay,this);         
        }
    }
});
JVVerHeadLine.implement(new Options);
JVVerHeadLine.implement(new Events);
