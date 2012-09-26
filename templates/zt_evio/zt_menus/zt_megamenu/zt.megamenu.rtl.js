var ZTMegaMenu = function(boxTimer, xOffset, yOffset, smartBoxSuffix, smartBoxClose, isub, xduration, xtransition)
{	
	var smartBoxes 	= $(document.body).getElements('div[id$=' + smartBoxSuffix + ']');
	var closeElem 	= $(document.body).getElements('.' + smartBoxClose);
	var closeBoxes 	= function(){smartBoxes.setStyle('display', 'none');};
	
	closeElem.addEvent('click', function(){ closeBoxes() }).setStyle('cursor', 'pointer');
	
	var closeBoxesTimer = 0;
	var fx = Array();
	var h  = Array();
	smartBoxes.each(function(item, i)
	{
		smartBoxes.setStyle('display', 'none');
		var currentBox 	= item.getProperty('id');
		currentBox 		= currentBox.replace('' + smartBoxSuffix + '', '');
		
		fx[i] = new Fx.Elements(item.getChildren(), {wait: false, duration: xduration, transition: xtransition, 
		onComplete: function(){item.setStyle('overflow', '')}});
 		
		$(currentBox).addEvent('mouseleave', function(){
			$(currentBox).removeClass('hover');
			
			item.setStyle('overflow', 'hidden');
			fx[i].start({
				'0':{
					'height': [h[i], 0],
					'opacity': [1, 0]
				}
			});
			
			closeBoxesTimer = closeBoxes.delay(boxTimer);
		});
 
		item.addEvent('mouseleave', function(){
		});
 
		$(currentBox).addEvent('mouseenter', function(){
			$(currentBox).addClass('hover');
			if($defined(closeBoxesTimer)) $clear(closeBoxesTimer);
		});
 
		item.addEvent('mouseenter', function(){
			if($defined(closeBoxesTimer)) $clear(closeBoxesTimer);
		});
 
		item.setStyle('margin', '0');
		$(currentBox).addEvent('mouseenter', function()
		{
			if(item.getStyle("height").toInt() < h[i] && h[i] != 'undefined' && !window.ie)
			{
				closeBoxesTimer = closeBoxes.delay(0);
				return false;
			}
				
			smartBoxes.setStyle('display', 'none');
			item.setStyles({ display: 'block', position: 'absolute' });
			
			if(h[i] == null) h[i] = item.getStyle("height").toInt();
			item.getChildren().setStyle('height', '0px');
			item.setStyle('overflow', 'hidden');
			
			fx[i].start({
				'0':{
					'height': [0, h[i]],
					'opacity': [0, 1]
				}				
			});
			
			var halfWindowY = window.getHeight() / 2;
			var halfWindowX = window.getWidth() / 2;
			var boxSize 	= item.getSize().size;
			var inputPOS 	= $(currentBox).getCoordinates();
			var inputCOOR 	= $(currentBox).getPosition();
			var inputSize 	= $(currentBox).getSize().size;
			
			var inputBottomPOS 			= inputPOS.top + inputSize.y;
			var inputBottomPOSAdjust 	= inputBottomPOS - window.getScrollHeight();
			
			var inputLeftPOS 	= inputPOS.left + xOffset;
			var inputRightPOS 	= inputPOS.right;
			var leftOffset 		= inputCOOR.x + xOffset;
			
			if(halfWindowY < inputBottomPOSAdjust)
			{
				if(!isub)
				{
					item.setStyle('top', inputPOS.top - boxSize.y - yOffset);
					if(inputLeftPOS < halfWindowX){ item.setStyle('left', leftOffset);}
					else{item.setStyle('left', (inputPOS.right - boxSize.x) - xOffset);};
				}
				else
				{
					item.setStyle('top', inputPOS.top - boxSize.y - yOffset);
					if(inputLeftPOS < halfWindowX){ item.setStyle('right', leftOffset);}
					else{item.setStyle('right', (inputPOS.right - boxSize.x) - xOffset);};
				}
			}
			else
			{
				if(!isub)
				{
					item.setStyle('top', inputBottomPOS + yOffset);
					if(inputLeftPOS < boxSize.x){item.setStyle('left', inputLeftPOS);}
					else{item.setStyle('left', (inputPOS.right - boxSize.x) - xOffset);};
				}
				else
				{
					if(boxSize.x > (inputLeftPOS)){item.setStyle('left', boxSize.x);}
					else{item.setStyle('right', inputSize.x);}
				}
			};
		}).setStyle('cursor', 'pointer');
	});
};