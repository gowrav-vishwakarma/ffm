<?php
/**
* @version		$Id: default.php 00005 2009-11-10 00:00:00 umitkenan $
* @package		Joomla
* @subpackage	JT SlideShow Module
* @link 		http://www.jt.gen.tr
* @copyright	Copyright (C) Joomla Türkçe Eðitim ve Destek Sitesi. http://www.jt.gen.tr 
* @license		GNU/GPL
*/

class modJTSlideShowHelper
{
    function getParameterList( &$params )
    {
		// jQuery Cycle Plugin Parameters
		$this->fx						= $params->get ( 'fx', 'all' );
		$this->timeout					= trim ( $params->get ( 'timeout', 4000 ) );
		$this->timeoutFn				= 'null';
		$this->continuous				= trim ( $params->get ( 'continuous', 0 ) );
		$this->speed					= trim ( $params->get ( 'speed', 1000 ) );
		$this->speedIn					= trim ( $params->get ( 'speedIn', 'null' ) );
		if ( $this->speedIn == '' ) $this->speedIn = 'null';
		
		$this->speedOut					= trim ( $params->get ( 'speedOut', 'null' ) );
		if ( $this->speedOut == '' ) $this->speedOut = 'null';

		$this->prevNextClick			= 'null';
		$this->pagerClick				= 'null';
		$this->pagerEvent				= trim ( $params->get ( 'pagerEvent', 'click' ) );
		$this->pagerAnchorBuilder		= 'null';
		$this->before					= 'null';
		$this->after					= 'null';
		$this->end						= 'null';
		$this->easing					= trim ( $params->get ( 'easing', 'null' ) );
		if ($this->easing != 'null') $this->easing = "'". $this->easing ."'";
		$this->easeIn					= trim ( $params->get ( 'easeIn', 'null' ) );
		if ($this->easeIn != 'null') $this->easeIn = "'". $this->easeIn ."'";
		$this->easeOut					= trim ( $params->get ( 'easeOut', 'null' ) );
		if ($this->easeOut != 'null') $this->easeOut = "'". $this->easeOut ."'";

		$this->shufflesetting			= trim ( $params->get ( 'shufflesetting', 'null' ) );
		if ( $this->shufflesetting == '' ) $this->shufflesetting = 'null';
		if ( $this->shufflesetting != 'null' ) $this->shufflesetting = '{ '.$this->shufflesetting.' }';	

		$this->animIn					= 'null';
		$this->animOut					= 'null';
		$this->cssBefore				= 'null';
		$this->cssAfter					= 'null';
		$this->fxFn						= 'null';
		$this->height					= 'auto';
		$this->startingSlide			= 0;
		$this->sync						= 1;
		$this->random					= trim ( $params->get ( 'random', 0 ) );
		$this->fit						= trim ( $params->get ( 'fit', 0 ) );
		$this->containerResize			= trim ( $params->get ( 'containerResize', 1 ) );
		$this->pause					= trim ( $params->get ( 'pause', 1 ) );
		$this->pauseOnPagerHover		= trim ( $params->get ( 'pauseOnPagerHover', 0 ) );
		$this->autostop					= trim ( $params->get ( 'autostop', 0 ) );
		$this->autostopCount			= 0;
		$this->delay					= trim ( $params->get ( 'delay', 0 ) );
		if ( $this->delay == '' ) $this->delay = 0;

		$this->slideExpr				= 'null';
		$this->nowrap					= trim ( $params->get ( 'nowrap', 0 ) );
		$this->fastOnEvent				= 0;
		$this->randomizeEffects			= trim ( $params->get ( 'randomizeEffects', 1 ) );
		$this->rev						= trim ( $params->get ( 'rev', 0 ) );
		$this->manualTrump				= 'true';
		$this->requeueOnImageNotLoaded	= 'true';
		$this->requeueTimeout			= '250';

		// Loading images, urls, titles, styles, options, etc..
		$this->image 					= explode ( "\n", trim ( $params->get ( 'images' ) ) );
		$this->url 						= explode ( "\n", trim ( $params->get ( 'urls' ) ) );
		$this->title 					= htmlspecialchars ( trim ( $params->get ( 'titles' ) ) );
		$this->title 					= explode ( "\n", $this->title );
		$this->folder					= trim ( $params->get ( 'folder' ) );
		$this->showallimages			= $params->get( 'showallimages', 0 );
		$this->target					= trim ( $params->get ( 'target', '_blank' ) );
		$this->linked					= $params->get( 'linked', 1 );
		$this->showcaption				= $params->get( 'showcaption', 0 );
		$this->captionposition			= $params->get( 'captionposition', 'bottom' );
		$this->captionalign				= $params->get( 'captionalign', 'center' );

		// If adding "http" is YES
		if (trim ( $params->get ( 'addhttp' ) )) {
			for ( $i=0 ; $i < count($this->image) ; $i++ )
				$this->url[$i]="http://".$this->url[$i]; }

		$this->imgwidth					= trim ( $params->get ( 'imgwidth', '170px' ) );
		$this->imgheight				= trim ( $params->get ( 'imgheight', '128px' ) );
		$this->imgborder				= trim ( $params->get ( 'imgborder', 0 ) );
		$this->imgbordersize			= trim ( $params->get ( 'imgbordersize', '5px' ) );
		$this->imgbordercolor			= trim ( $params->get ( 'imgbordercolor', '#eee' ) );

		if(strpos($this->imgwidth,'px') === false && strpos($this->imgwidth,'%') === false) $this->imgwidth = 0;
		if(strpos($this->imgheight,'px') === false && strpos($this->imgheight,'%') === false) $this->imgheight = 0;

		if ($this->imgborder == 1) {
			if(strpos($this->imgwidth,'px')) $this->imgwidth = ((str_replace('px','',$this->imgwidth)) - ($this->imgbordersize * 2) ).'px';
			if(strpos($this->imgheight,'px')) $this->imgheight = ((str_replace('px','',$this->imgheight)) - ($this->imgbordersize * 2) ).'px';
			if(strpos($this->imgwidth,'%')) $this->imgwidth = ((str_replace('%','',$this->imgwidth)) - ($this->imgbordersize / 2)).'%';
			if(strpos($this->imgheight,'%')) $this->imgheight = ((str_replace('%','',$this->imgheight)) - ($this->imgbordersize / 2)).'%';
		}

		// Navigation Bar, Previous - Next navigation buttons, and Box name
		$this->navigationbar			= trim ( $params->get ( 'navigationbar', 0 ) );
		$this->navigationbarposition	= trim ( $params->get ( 'navigationbarposition', 'bottom' ) );
		$this->navigationborder			= trim ( $params->get ( 'navigationborder', 1 ) );
		$this->navigationbordercolor	= trim ( $params->get ( 'navigationbordercolor', '#ccc' ) );

		$this->loadjquery				= trim ( $params->get ( 'loadjquery', 1 ) );
		$this->boxname 					= trim ( $params->get ( 'boxname', 'slideshowbox' ) );

		$this->next						= $this->boxname. "next";
		$this->prev						= $this->boxname. "prev";

		// If show caption is ON
		if ( $this->showcaption == 1 ) {
			$this->before = "function(idx, slide) { var caption = jQuery('img',slide).attr('alt'); jQuery('#". $this->boxname ."Caption').html(' ' + caption + ' '); }";
			$this->after = "function(idx, slide) { var caption = jQuery('img',slide).attr('alt'); jQuery('#". $this->boxname ."Caption').html(' ' + caption + ' '); }";
		}	
		
		// If navigation bar is ON
		if ( $this->navigationbar == 1 )
			$this->after = "function(curr, next, opts) { var index = opts.currSlide; jQuery('#". $this->prev ."')[index == 0 ? 'hide' : 'show'](); jQuery('#". $this->next ."')[index == opts.slideCount - 1 ? 'hide' : 'show'](); }";		

		// Pagination params
		$this->pagination				= trim ( $params->get ( 'pagination', 0 ) );
		$this->paginationbarposition	= trim ( $params->get ( 'paginationbarposition', 'top' ) );
		$this->paginationbarborder		= trim ( $params->get ( 'paginationbarborder', 0 ) );
		$this->paginationbarbordercolor	= trim ( $params->get ( 'paginationbarbordercolor', '#eee' ) );
		$this->paginationitemsborder	= trim ( $params->get ( 'paginationitemsborder', 1 ) );
		$this->paginationbaralign		= trim ( $params->get ( 'paginationbaralign', 'center' ) );

		if ( $this->paginationbaralign == "caption" ) $this->paginationbaralign = $this->captionalign;

		// Gallery params
		$this->gallery					= trim ( $params->get ( 'gallery', 0 ) );
		$this->galleryposition			= trim ( $params->get ( 'galleryposition', 'top' ) );

		if ( $this->galleryposition  == 'top' ) $params->set ( 'gallerywidth', 'auto' );

		$this->gallerywidth				= trim ( $params->get ( 'gallerywidth', 'auto' ) );
		
		if ( $this->galleryposition  == 'left' || $this->galleryposition  == 'right')
			if(strpos($this->gallerywidth,'px') === false && strpos($this->gallerywidth,'%') === false) $this->gallerywidth = 'auto';
		
		$this->gallerydirection			= trim ( $params->get ( 'gallerydirection', 'left' ) );

		$this->gallerythumbnailboxwidth		= trim ( $params->get ( 'gallerythumbnailboxwidth', '90px' ) );
		$this->gallerythumbnailboxheight	= trim ( $params->get ( 'gallerythumbnailboxheight', '90px' ) );
		
		$this->galleryfitthumbnail		= trim ( $params->get ( 'galleryfitthumbnail', 0 ) );

		$this->gallerythumbnailwidth	= trim ( $params->get ( 'gallerythumbnailwidth', '180px' ) );
		$this->gallerythumbnailheight	= trim ( $params->get ( 'gallerythumbnailheight', '100%' ) );
		
		if ($this->galleryfitthumbnail == 1) {
			$this->gallerythumbnailwidth = $this->gallerythumbnailboxwidth;
			$this->gallerythumbnailheight = $this->gallerythumbnailboxheight;
		}
		
		$this->gallerythumbnailspace	= trim ( $params->get ( 'gallerythumbnailspace', '5px' ) );

		if(strpos($this->gallerythumbnailspace,'px') === false && strpos($this->gallerythumbnailspace,'%') === false) $this->gallerythumbnailspace = 0;

		$this->gallerythumbnailborder		= trim ( $params->get ( 'gallerythumbnailborder', 1 ) );
		$this->gallerythumbnailbordercolor	= trim ( $params->get ( 'gallerythumbnailbordercolor', '#ccc' ) );
		$this->gallerythumbnailbordersize	= trim ( $params->get ( 'gallerythumbnailbordersize', '3px' ) );

		if(strpos($this->gallerythumbnailbordersize,'px') === false && strpos($this->gallerythumbnailbordersize,'%') === false) $this->gallerythumbnailbordersize = 0;

		// Caption
		$this->caption = '<div id="'. $this->boxname .'Caption" style="text-align: '. $this->captionalign .'"></div>';

		// Loading message and/or image
		$this->loading					= '<div id="'. $this->boxname . 'loading"><img src="' . JURI::root() . 'modules/mod_jt_slideshow/images/loading.gif" border="0" alt="' . JText::_( 'LOADING') . '" title="' . JText::_( 'LOADING') .'" /></div>';
		
		// Navigation Bar Content
		$this->navigationbarcontent = '';
		
		if ( $this->navigationbar == 1 ) {
			$this->navigationbarcontent = '<div id="'. $this->boxname . 'navigationbar" style="text-align:center;">'  
				. '<a id="'.$this->prev.'" href="javascript:void(0);"><img src="'.JURI::root().'/modules/mod_jt_slideshow/images/prev.png" border="0" /></a>'
				. '<a id="'.$this->next.'" href="javascript:void(0);"><img src="'.JURI::root().'/modules/mod_jt_slideshow/images/next.png" border="0" /></a>'
				. '</div>';
		}
		
		// Pagination Bar Content
		$this->paginationbarcontent = '';

		if ( $this->pagination == 1 && $this->gallery == 0 ) {
			$this->paginationbarcontent = '<div id="'.$this->boxname.'nav" style="text-align: '. $this->paginationbaralign .'"></div><div style="clear:both"></div>';
		}
		
		// Gallery params and layer
		$this->gallerycontent = '';
		$this->showgallery = 0;
		
		if ( $this->pagination == 0 && $this->gallery == 1 ) {
			$this->showgallery = 1;

			if ( $this->galleryposition  == 'left') $this->slideshowboxposition = 'float: right;';
			if ( $this->galleryposition  == 'right') $this->slideshowboxposition = 'float: left;';
			
			$this->gallerycontent = '<div id="'.$this->boxname.'gallery"></div>';
			
			if ( $this->galleryposition  == 'top' ) $this->gallerycontent = $this->gallerycontent . '<div class="JT-ClearBox"></div>';

			if ( $this->galleryposition  == 'top' ) $this->galleryposition = '';
			if ( $this->galleryposition  == 'left' || $this->galleryposition  == 'right') $this->galleryposition = 'float: '.$this->galleryposition;
		}

		// Show all images
		if ($this->showallimages) {
			// Directory SlideShow
			// if subdirectory parameter is yes
			$jpgimages = glob("".$this->folder."/*.jpg");
			$pngimages = glob("".$this->folder."/*.png");
			$gifimages = glob("".$this->folder."/*.gif");

			// Generating image array
			// Adding jpeg files to (directory) slideshow
			$this->image = $jpgimages;

			// Adding png files to (directory) slideshow
			$j=0;
			for ($i = count($jpgimages); $i < count($jpgimages)+count($pngimages); $i++) {
				$this->image[$i]=$pngimages[$j];
				$j=$j+1;
			}
		
			// Adding gif files to (directory) slideshow
			$j=0;
			for ($i = count($this->image); $i < count($jpgimages)+count($pngimages)+count($gifimages); $i++) {
				$this->image[$i]=$gifimages[$j];
				$j=$j+1; 
			}	
		}

		// SlideShow Content - Loop
		for ( $i=0 ; $i < count($this->image) ; $i++ ) {
			// Preparing Titles
			$this->alt[$i] 				= $this->title[$i] ? ' alt="'. $this->title[$i] .'"' : '';
			$this->alttitle[$i] 		= $this->title[$i] ? ' title="'. $this->title[$i] .'"' : '';
			// Preparing Links
			$this->imagelinkstart[$i] 	= $this->linked ? '<a href="'. $this->url[$i] .'" target="'. $this->target .'">' : '<a href="javascript:void(0);">';
			$this->imagelinkend		 	= '</a>';
			
			// Show Only Entered Images
			if (!$this->showallimages) {
				// External Image Resource
				if (strstr($this->image[$i],'<ext>')) {
					$this->image[$i] = str_replace('<ext>','',$this->image[$i]);
					$this->imagewithpath[$i] = '<img src="'. $this->image[$i] . '" border="0"'. $this->alt[$i] . $this->alttitle[$i] .'/>';
				}
				// Internal Image Resource
				else $this->imagewithpath[$i] = '<img src="'.JURI::root() . $this->folder . '/' . $this->image[$i] . '" border="0"'. $this->alt[$i] . $this->alttitle[$i] .'/>';			
			}
			// Show All Images in the folder
			else $this->imagewithpath[$i] = '<img src="'.JURI::root() . $this->image[$i] . '" border="0"'. $this->alt[$i] . $this->alttitle[$i] .'/>';
			
			// Prepared SlideShow (Content) Image:
			$this->slideshowcontent[$i]	= $this->imagelinkstart[$i].$this->imagewithpath[$i].$this->imagelinkend;
		}

		// JT SlideShow Footer
		$this->jtslideshowfooter = '';
		if ( $params->get ( 'jtslideshowfooter' ) == null || $params->get ( 'jtslideshowfooter' ) == ''  ) $params->set ( 'jtslideshowfooter', 1 );
		if ( $params->get ( 'jtslideshowfooter' ) == 1 )
			$this->jtslideshowfooter = '<div id="'.$this->boxname.'footer">'.JText::_( 'JT-SlideShow-Footer').'</div><div class="JT-ClearBox"></div>';

		// Notifications, warnings and errors
		if ( $this->boxname == null || $this->boxname == ''  ) JError::raiseWarning('ERROR_CODE', JText::_('ERRORBOXNAME'));
		if ( $this->fx == null || $this->fx == ''  ) JError::raiseWarning('ERROR_CODE', JText::_('ERRORFX'));
		if ( $this->pagination == 1 && $this->gallery == 1 ) JError::raiseWarning('ERROR_CODE', JText::_('ERRORPAGINATIONANDGALLERY'));
		if ( $this->image[0] == null || $this->image[0] == '' ) JError::raiseWarning('ERROR_CODE', JText::_('ERRORIMAGE'));
		
		// Preparing CSS style
		// Clear Box
		$css = ' div.JT-ClearBox { display: block; height: 0; clear: both; visibility: hidden; } ';
		// JT SlideShow Footer
		$css = $css . ' DIV#'.$this->boxname.'footer { display:none; padding-top: 10px; font-family: Tahoma,Verdana,sans-serif; font-size: 8px; font-weight: bold; } ';
		// Loading Message Box
		$css = $css . ' DIV#'.$this->boxname.'loading { color: #eee; font-weight: bold; text-align: center; margin: 0px auto; } ';
		// SlideShow Box
		$css = $css . ' DIV#'.$this->boxname.' { display:none; margin: 0px auto; '.$this->slideshowboxposition.' } ';
		// SlideShow Box - Images
		$css = $css . ' DIV#'.$this->boxname.' img { width: '.$this->imgwidth.'; height: '.$this->imgheight.'; } ';
		if ($this->imgborder == 1) $css = $css . ' DIV#'.$this->boxname.' img { border-width: '. $this->imgbordersize .'; border-style: solid; border-color: '. $this->imgbordercolor .'; } ';
		// Caption
		$css = $css . ' DIV#'.$this->boxname.'Caption { font-weight: bold; font-size: 110%; line-height: 2em; } ';
		// Navigation Bar
		$css = $css . ' DIV#'.$this->boxname.'navigationbar { display:none; margin: 5px auto; } ';
		if ( $this->navigationborder == 1 ) $css = $css . ' DIV#'.$this->boxname.'navigationbar { width: 40px; background-color: '.$this->navigationbordercolor.'; } ';
		// Pagination Bar Group
		if ( $this->pagination == 1 && $this->gallery == 0 ) :
		// Pagination Bar - Line
		$css = $css . ' #'.$this->boxname.'nav { display:none; margin-top:5px; margin-bottom:5px; } ';
		if ($this->paginationbarborder == 1) $css = $css . ' #'.$this->boxname.'nav { background-color: '.$this->paginationbarbordercolor.'; } ';
		// Pagination Bar - Links
		$css = $css . ' #'.$this->boxname.'nav a { margin: 2px; padding: 2px; text-decoration: none; font-size: 110%; line-height: 1.5em; font-weight: bold; } ';
		if ($this->paginationitemsborder == 1) $css = $css . ' #'.$this->boxname.'nav a { border: 1px solid #ccc; background: '.$this->paginationbarbordercolor.'; } ';
		$css = $css . ' #'.$this->boxname.'nav a:focus { outline: none; } ';
		// Pagination Bar - Active Links
		$css = $css . ' #'.$this->boxname.'nav a.activeSlide { color: #000; background: #ccc; } ';
		endif;
		// Gallery Group
		if ( $this->pagination == 0 && $this->gallery == 1 ) :
		// Gallery Box
		$css = $css . ' #'.$this->boxname.'gallery { width: '.$this->gallerywidth.'; list-style-type: none; display: block; overflow:hidden; margin: 0; padding: 0; '.$this->galleryposition. ' } ';
		// Gallery Items
		$css = $css . ' #'.$this->boxname.'gallery li { position: relative; width: '.$this->gallerythumbnailboxwidth.'; height: '.$this->gallerythumbnailboxheight.'; display: block; overflow:hidden; float:'.$this->gallerydirection.'; margin:'.$this->gallerythumbnailspace.'; }';
		if ($this->gallerythumbnailborder == 1) $css = $css . ' #'.$this->boxname.'gallery li { border-width: '. $this->gallerythumbnailbordersize .'; border-style: solid; border-color: '. $this->gallerythumbnailbordercolor .'; }';
		// Gallery Links
		$css = $css . ' #'.$this->boxname.'gallery a { display: block; }';
		// Gallery Thumbnails
		$css = $css . ' #'.$this->boxname.'gallery a img { width: '.$this->gallerythumbnailwidth.'; height: '.$this->gallerythumbnailheight.'; display: block; overflow:hidden;}';		
		// Gallery Active Links
		$css = $css . ' #'.$this->boxname.'gallery a.activeSlide { filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5; }';
		$css = $css . ' #'.$this->boxname.'gallery a:focus { outline: none; }';
		// Gallery Images
		$css = $css . ' #'.$this->boxname.'gallery img { border: none; display: block }';
		endif;
		
		// loading jQuery
		$jQuery = '';
		if ($this->loadjquery == 1)
			$jQuery = '<script src = "'. JURI::root() .'modules/mod_jt_slideshow/scripts/jquery.js" type="text/javascript"></script>' . "\n";
		$jQuery .= '<script src = "'. JURI::root() .'modules/mod_jt_slideshow/scripts/jquery.cycle.all.min.js" type="text/javascript"></script>';
		$jQuery .= '<script src = "'. JURI::root() .'modules/mod_jt_slideshow/scripts/jquery.easing.1.3.js" type="text/javascript"></script>';
		$jQuery .= '<script src = "'. JURI::root() .'modules/mod_jt_slideshow/scripts/jquery.easing.compatibility.js" type="text/javascript"></script>';
		
		// Apply CSS Styles & JavaScript
		$document =& JFactory::getDocument();
		$document->addCustomTag($jQuery);
		$document->addStyleDeclaration($css);
		
		// Preloading images with jQuery
		echo '<script type="text/javascript">jQuery.preloadImages = function(){for(var i = 0; i<arguments.length; i++){jQuery("<img>").attr("src", arguments[i]);}}</script>';
		for ( $i=0 ; $i < count($this->image) ; $i++ ) echo '<script type="text/javascript">jQuery.preloadImages("<?php echo JURI::root() . $this->folder . "/" . $this->image[$i]; ?>");</script>';
	}
}