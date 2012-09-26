<?php
/**
 * @package JV Headline module for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright(C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

$user 		= &JFactory::getUser();
$db 		= &JFactory::getDBO();
$menu 		= &JSite::getMenu();
$document	= &JFactory::getDocument();
$moduleclass_sfx = $params->get( 'moduleclass_sfx', 0 );

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

if(is_dir(JPATH_SITE.DS.'components'.DS.'com_k2'))
{
  require_once(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
  require_once(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');
}

class modJVHeadLineHelper
{
	function createdDirThumb($comp='com_content', $folderImage='', $thumbpath='')
	{
		global $moduleId;
		$thumbImgParentFolder = JPATH_BASE.DS.$thumbpath.DS.'thumbs'.DS.$moduleId.DS.$comp.$folderImage;
		if(!JFolder::exists($thumbImgParentFolder))
		{
			JFolder::create($thumbImgParentFolder);
		}
	}
	
	function grabData($source_to_grab, $delimiter_start, $delimiter_stop, $str_to_replace='', $str_replace='', $extra_data='')
	{
		$result		= '';
		$fd 		= "";
		$start_pos 	= $end_pos = 0;
		$source_to_grab = $source_to_grab;
		
		while(true)
		{
			if($end_pos > $start_pos)
			{
				$result = substr($fd, $start_pos, $end_pos-$start_pos);
				$result .= $delimiter_stop;
				break;
			}//10
			$data = @fread($source_to_grab, 8192);
			//echo $data;
			if(strlen($data) == 0) break;
			$fd .= $data;
			if(!$start_pos) $start_pos = strpos($fd, $delimiter_start);
			if($start_pos) $end_pos = strpos(substr($fd, $start_pos), $delimiter_stop) + $start_pos;
		}
		//echo $result;
		return str_replace($str_to_replace, $str_replace, $extra_data.$result);
	}
	/*
	 * Function get thumbnail size
	 * @Created by joomvision
	 */
	function getThumnailSize($params, &$thumbWidth, &$thumbHeight)
	{
		switch($params->get('layout_style'))
		{			
			case "jv_slide4":
				$thumbHeight = $params->get('sello2_thumb_height');
				$thumbWidth = $params->get('sello2_thumb_width');
				break;
			case "jv_slide3":				
				$thumbHeight = $params->get('lago_thumb_height');
				$thumbWidth = $params->get('lago_thumb_width');	
				break;
			case "jv_slide6":
				$thumbHeight = $params->get('sello1_thumb_height');
				$thumbWidth = $params->get('sello1_thumb_width');
				break;	
			case "jv_slide5":
				$thumbHeight = $params->get('maju_thumb_height');
				$thumbWidth = $params->get('maju_thumb_width');	
				break;
			case "jv_slide8":
				$thumbHeight = $params->get('pedon_thumb_height');
				$thumbWidth = $params->get('pedon_thumb_width');
				break;
			case "jv_slide9":
				$thumbHeight = $params->get('jv9_main_height',320);
				$thumbWidth = $params->get('jv9_expand_width',700);
				break;
		}
	}
	//End get thumbnail size

	/*
	 *Function get large thumbnail
	 *@Created by joomvision
	 */
	function getLargeThumbSize($params,&$thumbWidth,&$thumbHeight)
	{
		switch($params->get('layout_style'))
		{
			case "jv_slide8":
				$thumbHeight = $params->get('jv_pedon_height');
				$thumbWidth = $params->get('jv_pedon_width');
				break;
			case "jv_slide6":
				$thumbWidth = $params->get('sello1_imgslide_width');
				$thumbHeight = $params->get('sello1_imgslide_height');	
				break;
			case "jv_slide7":
				$thumbWidth = $params->get('jv7_main_width');
				$thumbHeight = $params->get('jv7_height');
				break;
			case "jv_slide3":
				$thumbHeight = $params->get('jv_lago_height');
				$thumbWidth = $params->get('jv_lago_main_width');
				break;
			case "jv_slide2":
				$thumbWidth = $params->get('jveoty_width');
				$thumbHeight = $params->get('jveoty_height');
				break;
			case "jv_slide5":
				$thumbWidth = $params->get('jv_maju_width');
				$thumbHeight = $params->get('jv_maju_height');
				break;	
			case "jv_slide1":
				$thumbWidth= $params->get('news_thumb_width');
				$thumbHeight = $params->get('news_thumb_height');
				break;
			case "jv_slide9":
				$thumbHeight = $params->get('jv9_main_height');
				$thumbWidth = $params->get('jv9_expand_width');
				break;
			case "jv_slide10":
				$thumbHeight = $params->get('zt_flow_thumb_height');
				$thumbWidth = $params->get('zt_flow_thumb_width');
				break;	
		}
	}
	//End get large thumbnail	
	function getImageSizes($file)
	{
		return getimagesize($file);
	}

	function checkImage($file)
	{
		//preg_match("/\<img.+?src=\"(.+?)\".+?\/>/", $file, $matches);
		preg_match('/<img(.*?)src="(.*?)"(.*?)>/', $file, $matches);
		if(count($matches))
		{
			return $matches[2];
		} else {return '';}
	}

	function FileExists($file)
	{
		if(file_exists($file))
			return true;
		else
			return false;
	}

	function FileDifferentExists($file)
	{
		$check = @fopen($file, "r");
		if(strpos($check, "Resource id") !== false)
			return true;
		else
			return false;
	}
	
	function checkCache($path)
	{
		global $moduleId, $cache_time;
		$now 		= time();
		$modified 	= date("Y-m-d H:i:s", filemtime($path));
		$modified 	= strtotime($modified);
		$expired	= (int)$modified + (int)($cache_time * 60);
		
		if($expired < $now) {
			@JFile::delete($path);
			return false;
		} else {
			return true;
		}	
	}
	
	function getThumb($text, $extraname, $tWidth,$tHeight, $reflections=false, $id=0, $isSmall = 1, $isComp='com_content', $thumbpath)
	{
		global $moduleId;		
		//preg_match("/\<img.+?src=\"(.+?)\".+?\/>/", $text, $matches);
		preg_match('/<img(.*?)src="(.*?)"(.*?)>/', $text, $matches);
		$paths 		= array();
		$showbug 	= true;
		
		//if(isset($matches[1]))
		if(isset($matches[2]))
		{
			//$image_path = $matches[1];
			$image_path = $matches[2];
			//joomla 1.5 only
			$isInternalLink = modJVHeadLineHelper::isInternalLink($image_path);			
			if(!$isInternalLink)
			{
				$path_parts = pathinfo($image_path);
				$imgName = $path_parts['basename'];													
				$internalLink = JPATH_BASE.DS."images".DS."stories".DS."thumbs".DS."externallink".DS.$imgName;
				modJVHeadLineHelper::saveImage($internalLink,$image_path);
				$image_path = "images/stories/thumbs/externallink/".$imgName;
			}
			else
			{
				if(!modJVHeadLineHelper::FileExists($image_path)) return '';
			}
			// create a thumb filename
			$file_div = strrpos($image_path,'.');
			$thumb_ext = substr($image_path, $file_div);
			$thumb_prev = substr($image_path, 0, $file_div);
			
			if($isSmall == 1)
			{
				$thumb_path =(($thumbpath != '') ? $thumbpath : '') . 'thumbs/'.$moduleId.'/'.$isComp.'/'.$id.'/thumbs_'.$tWidth.'x'.$tHeight.$thumb_ext;
			}
			else
			{
				$thumb_path =(($thumbpath != '') ? $thumbpath : '') . 'thumbs/'.$moduleId.'/'.$isComp.'/'.$id.'/thumbl_'.$tWidth.'x'.$tHeight.$thumb_ext;
			}
			
			//Check cache /
			$cache = false;
			if(file_exists($thumb_path)) $cache = modJVHeadLineHelper::checkCache($thumb_path);
			if($cache) return $thumb_path;
			//End
			
			// check to see if this file exists, if so we don't need to create it
			if($thumb_path !='' && function_exists("gd_info") && !file_exists($thumb_path)) {
				// file doens't exist, so create it and save it
				include_once('thumbnail.inc.php');
				$thumb = new JVThumbnail($image_path);
				if($thumb->error) {
					if($showbug)   echo "JV Image ERROR: " . $thumb->errmsg . ": " . $image_path;
					return false;
				}
				//$thumb->resize($size);
				$thumb->resize_image($tWidth,$tHeight);
				if($reflections) {
					$thumb->createReflection(30,30,60,false);
				}
				if(!is_writable(dirname($thumb_path))) {
					$thumb->destruct();
					return false;
				}
				$thumb->save($thumb_path);
				$thumb->destruct();
			}
			return($thumb_path);
		} else {
			return false;
		}
	}
	/*
	 * Function get thumbnail of image k2 component
	 * @Created by joomvision
	 */
	function getThumbK2Content($file, $tWidth,$tHeight, $reflections=false,$id=0,$isSmall=1)
	{
			$file_div = strrpos($file,'.');
			$thumb_ext = substr($file, $file_div);		
			if($isSmall == 1)$thumb_path = 'images/stories/thumbs/com_k2/'.$id.'/thumbs_'.$tWidth.'x'.$tHeight.$thumb_ext;
			else $thumb_path = 'images/stories/thumbs/com_k2/'.$id.'/thumbl_'.$tWidth.'x'.$tHeight.$thumb_ext;
			if(file_exists($thumb_path)) @unlink($thumb_path);
			// check to see if this file exists, if so we don't need to create it
			if($thumb_path !='' && function_exists("gd_info") && !file_exists($thumb_path)) {
				// file doens't exist, so create it and save it
				include_once('thumbnail.inc.php');
				$thumb = new JVThumbnail($file);
				if($thumb->error) {
					if($showbug)   echo "JV Image ERROR: " . $thumb->errmsg . ": " . $image_path;
					return false;
				}
				//$thumb->resize($size);
				$thumb->resize_image($tWidth,$tHeight);
				if($reflections) {
					$thumb->createReflection(30,30,60,false);
				}
				if(!is_writable(dirname($thumb_path))) {
					$thumb->destruct();
					return false;
				}
				$thumb->save($thumb_path);
				$thumb->destruct();
			}
			return($thumb_path);
	}
	//End
	function introContent( $str, $limit = 100,$end_char = '&#8230;' ) {
		if(trim($str) == '') return $str;
		// always strip tags for text
		$str = strip_tags($str);
		preg_match('/\s*(?:\S*\s*){'.(int)$limit.'}/', $str, $matches);		
		if(strlen($matches[0]) == strlen($str))$end_char = '';
		return rtrim($matches[0]).$end_char;
	}
	
	/*
	 * Function check image is internal link or external link
	 * @Created by joomvision
	 */
	function isInternalLink($image_path){
		$full_url = JURI::base();
		//remove any protocol/site info from the image path
		$parsed_url = parse_url($full_url);
		$paths[] = $full_url;
		if(isset($parsed_url['path']) && $parsed_url['path'] != "/") $paths[] = $parsed_url['path'];
		foreach($paths as $path) {
			if(strpos($image_path,$path) !== false) {
				$image_path = substr($image_path,strpos($image_path, $path)+strlen($path));
			}
		}			
		// remove any / that begins the path
		if(substr($image_path, 0 , 1) == '/') $image_path = substr($image_path, 1);
		//if after removing the uri, still has protocol then the image
		//is remote and we don't support thumbs for external images
		if(strpos($image_path,'http://') !== false || strpos($image_path,'https://') !== false) { 
			return false;
		} 
		return true;
			
	}
	//End check image
	
	/*
	 * Function save image from external link in our server
	 * @Created by joomvision
	 */
	function saveImage($inPath,$outPath){ //Download images from remote server		
	   	$ch = curl_init($outPath);
		$fp = fopen($inPath, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}
	//End save image
}

class modJVHeadlineCommonHelper
{
	function __construct()
	{
		/*modJVHeadLineHelper::createdDirThumb();
		modJVHeadLineHelper::createdDirThumb('externallink');
		modJVHeadLineHelper::createdDirThumb('com_k2');*/
	}
	
	function getSlideContent($params)
	{
		global $mainframe;
		$db         =& JFactory::getDBO();
		$user       =& JFactory::getUser();
		$userId     =(int) $user->get('id');

		$categories =( array )$params->get('categories',array());
		if(count($categories)){
			$strCatId = implode(',',$categories);
			$categoriesCondi = " AND cc.id IN($strCatId)";
		}
		$intro_length = intval($params->get( 'intro_length', 50) );
		//$count      =(int) $params->get('count', 0);
		$count = $this->getNoItemByStyle($params);
		$catid      = trim( $params->get('catid') );
		$secid      = trim( $params->get('secid') );
		$aid        = $user->get('aid', 0);
		//Init width and height of small or large thumbnail
		$sThumbWidth = '';
		$sThumbHeight = '';
		$lThumbWidth ='';
		$lThumbHeight ='';
		$thumbPath ='';
		//End init
		
		$layoutStyle = $params->get('layout_style');
		
		switch($layoutStyle) {
			case "jv_slide4":
				$thumbpath = $params->get('jv_sello2_thumbs');
				break;
			case "jv_slide3":		
				$thumbpath = $params->get('jv_lago_thumbs');	
				break;
			case "jv_slide6":
				$thumbpath = $params->get('jv_sello1_thumbs');	
				break;	
			case "jv_slide5":
				$thumbpath = $params->get('jv_maju_thumbs');
				break;
			case "jv_slide8":	
				$thumbpath = $params->get('jv_pedon_thumbs');
				break;
			case "jv_slide9":
				$thumbpath = $params->get('jv_jv9_main_thumbs');
				break;
			case "jv_slide7":
				$thumbpath = $params->get('jv_jv7_main_thumbs');	
				break;
			case "jv_slide2":
				$thumbpath = $params->get('jv_eoty_thumbs');
				break;
			case "jv_slide1":
				$thumbpath = $params->get('jv_news_thumbs');
				break;
			case "jv_slide10":	
				$thumbpath = $params->get('zt_flow_thumbs');
				break;
		}
		if($layoutStyle !='jv_slide2' && $layoutStyle !='jv_slide1' && $layoutStyle!='jv_slide9' && $layoutStyle!='jv_slide10')
		modJVHeadLineHelper::getThumnailSize($params,$sThumbWidth,$sThumbHeight);//Get small thumb size
		if($layoutStyle != 'jv_slide4') modJVHeadLineHelper::getLargeThumbSize($params,$lThumbWidth,$lThumbHeight);
		
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access     = !$contentConfig->get('shownoauth');
		$nullDate   = $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();
		$where      = 'a.state = 1'
		. ' AND( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
		. ' AND( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
		;
		// Ordering		
		$orderBy = $params->get('ordering');
		$ordering = 'a.'.$orderBy.' '.$params->get('sort_order');		
		if($catid)
		{
			$ids = explode( ',', $catid );
			JArrayHelper::toInteger( $ids );
			$catCondition = ' AND(cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
		}
		if($secid)
		{
			$ids = explode( ',', $secid );
			JArrayHelper::toInteger( $ids );
			$secCondition = ' AND(s.id=' . implode( ' OR s.id=', $ids ) . ')';
		}
		$show_readmore_link = false;
		$catidcount = count(explode( ',', $catid ));
		$secidcount = count(explode( ',', $secid ));
		if(($catidcount==1) &&($secidcount==1)) {
			$show_readmore_link = true;
		}
		$params->set('show_readmore_link', $show_readmore_link);
		// Content Items only
		$query = 'SELECT a.*,a.id as key1, cc.id as key2, cc.title as cat_title, ' .
            ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
            ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
            ' FROM #__content AS a' .             
            ' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
            ' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
            ' WHERE '. $where .' AND s.id > 0' .
		($access ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
		(count($categories) ? $categoriesCondi:'').
            ' AND s.published = 1' .
            ' AND cc.published = 1' .
            ' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();
		if(count($rows)){
		$i      = 0;
		$lists  = array();
		$article_count = count($rows);		
		foreach( $rows as $row ){
			$imageurl = modJVHeadLineHelper::checkImage($row->introtext);
			$folderImg = DS.$row->id;
			$lists[$i]->thumb_diff = '';
			$lists[$i]->thumbs = $lists[$i]->thumbl = '';
			modJVHeadLineHelper::createdDirThumb('com_content',$folderImg,$thumbpath);			
			$lists[$i]->title = $row->title;
			$lists[$i]->alias = $row->alias;
			//Execute with item id
			
			//End Item id
			$lists[$i]->link = JRoute::_($this->renderLinkArticle($params,$row->slug, $row->catslug, $row->sectionid));
			$lists[$i]->introtext = modJVHeadLineHelper::introContent($row->introtext, $intro_length);
			if($layoutStyle !='jv_slide2' && $layoutStyle !='jv_slide1' && $layoutStyle!='jv_slide9' && $layoutStyle!='jv_slide10') {
				if(modJVHeadLineHelper::checkImage($row->introtext)) $lists[$i]->thumbs = modJVHeadLineHelper::getThumb($row->introtext, '_headline', $sThumbWidth,$sThumbHeight,false,$row->id,1,'com_content', $thumbpath);	
			}
			if($params->get('layout_style') != 'jv_slide4') {			
				if(modJVHeadLineHelper::checkImage($row->introtext)) $lists[$i]->thumbl = modJVHeadLineHelper::getThumb($row->introtext, '_headline', $lThumbWidth,$lThumbHeight,false,$row->id,0,'com_content', $thumbpath);
			}
			$i++;			
		}		
		}
		return $lists;
	}
	function renderLinkArticle($params,$id, $catid = 0, $sectionid = 0){
		$menuItemType = $params->get('menuitem_type','default');
		$jvContentHelper = new JVContentHelperRouter();
		$currentItemId = JRequest::getVar('Itemid');
		$inputedItemId = $params->get('input_itemid',0);
		$link = 'index.php?option=com_content&view=article&id='. $id;		
		if($catid) {
			$link .= '&catid='.$catid;
		}
		switch($menuItemType){
			case 'default':
				if($jvContentHelper->isExistedItemId($id,$itemId,$catid,$sectionid)) {
					$link .= '&Itemid='.$itemId;
				} else if($currentItemId){
					$link .= '&Itemid='.$currentItemId;
				} else if($inputedItemId){
					$link .= '&Itemid='.$inputedItemId;
				} 
				break;
			case 'current_page':
				if($currentItemId){
					$link .= '&Itemid='.$currentItemId;
				} else if($inputedItemId){
					$link .= '&Itemid='.$inputedItemId;
				}
				break;
			case 'input_value':
				if($inputedItemId){
					$link .= '&Itemid='.$inputedItemId;
				}
				break;						
		}
		return $link;
	}
	function renderK2LinkItem($params,$id, $catid = 0){
		$menuItemType = $params->get('menuitem_type','default');
		$jvK2Helper = new JVK2HelperRouter();
		$currentItemId = JRequest::getVar('Itemid');
		$inputedItemId = $params->get('input_itemid',0);
		$link = 'index.php?option=com_k2&view=item&id='.$id;
		switch($menuItemType){
				case 'default':
					if($jvK2Helper->isExistedItemId($itemId,$id,$catid)) {
						$link .= '&Itemid='.$itemId;
					} else if($currentItemId){
						$link .= '&Itemid='.$currentItemId;
					} else if($inputedItemId){
						$link .= '&Itemid='.$inputedItemId;
					} 
					break;
				case 'current_page':
					if($currentItemId){
						$link .= '&Itemid='.$currentItemId;
					} else if($inputedItemId){
						$link .= '&Itemid='.$inputedItemId;
					}
					break;
				case 'input_value':
					if($inputedItemId){
						$link .= '&Itemid='.$inputedItemId;
					}
					break;						
		}
		return $link;	
	}
	/*
	 * Function get items of k2 component
	 * @Created by joomvision
	 */		 
	function getItemsByK2($params){
		$db	=& JFactory::getDBO();
		$categories =( array )$params->get('k2_category',array());
		if(count($categories)){
			$strCatId = implode(',',$categories);
			$categoriesCondi = " AND c.id IN($strCatId)";
		}
		$intro_length = intval($params->get( 'intro_length', 200) );	
		$count = $this->getNoItemByStyle($params);
		//Init width and height of small or large thumbnail
		$lThumbWidth = $sThumbHeight= $sThumbWidth = $lThumbHeight = '';	
		//End init
		$layoutStyle = $params->get('layout_style');
		
		switch($layoutStyle) {
			case "jv_slide4":
				$thumbpath = $params->get('jv_sello2_thumbs');
				break;
			case "jv_slide3":		
				$thumbpath = $params->get('jv_lago_thumbs');	
				break;
			case "jv_slide6":
				$thumbpath = $params->get('jv_sello1_thumbs');	
				break;	
			case "jv_slide5":
				$thumbpath = $params->get('jv_maju_thumbs');
				break;
			case "jv_slide8":	
				$thumbpath = $params->get('jv_pedon_thumbs');
				break;
			case "jv_slide9":
				$thumbpath = $params->get('jv_jv9_main_thumbs');
				break;
			case "jv_slide7":
				$thumbpath = $params->get('jv_jv7_main_thumbs');	
				break;
			case "jv_slide2":
				$thumbpath = $params->get('jv_eoty_thumbs');
				break;
			case "jv_slide1":
				$thumbpath = $params->get('jv_news_thumbs');
				break;
			case "jv_slide10":	
				$thumbpath = $params->get('zt_flow_thumbs');
				break;					
		}
		if($layoutStyle !='jv_slide2' && $layoutStyle !='jv_slide1')
		modJVHeadLineHelper::getThumnailSize($params,$sThumbWidth,$sThumbHeight);//Get small thumb size
		if($layoutStyle != 'jv_slide4') modJVHeadLineHelper::getLargeThumbSize($params,$lThumbWidth,$lThumbHeight);
		// Ordering		
		$orderBy = $params->get('ordering');
		$ordering = 'i.'.$orderBy.' '.$params->get('sort_order');
		$lists = array();			
		if(count($categories)){			
			$date = & JFactory::getDate();
			$user = & JFactory::getUser();
    		$aid = $user->get( 'aid', 0 );
	    	$now = $date->toMySQL();	
	    	$nullDate = $db->getNullDate(); 
    		$query = "SELECT i.*, c.alias as catalias,i.catid    
      				FROM #__k2_items AS i 
      				LEFT JOIN #__k2_categories AS c 
      					ON c.id = i.catid
      				WHERE i.published = 1 ".$categoriesCondi." AND i.access <={$aid}
			      	AND i.trash = 0 AND c.access<={$aid} AND c.trash =0
			      	AND( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )
                    AND( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." ) "." ORDER BY ".$ordering;
			$db->setQuery($query, 0, $count);			
			$rows = $db->loadObjectList();			
			$j = 0;
			if(count($rows)){
				foreach($rows as $row) {
					$folderImg = DS.$row->id;
					modJVHeadLineHelper::createdDirThumb('com_k2',$folderImg,$thumbpath);
					$lists[$j]->id = $row->id;
					$lists[$j]->title = $row->title;
					$lists[$j]->link = JRoute::_($this->renderK2LinkItem($params,$row->id.':'.urlencode($row->alias), $row->catid.':'.urlencode($row->catalias)));						
					$lists[$j]->created = $row->created; 					
					$lists[$j]->thumbs = $lists[$j]->thumbl = '';
					$folderImg = DS.$row->id;
					$lists[$j]->thumb_diff = '';
					$lists[$j]->thumbs = $lists[$j]->thumbl = '';
					modJVHeadLineHelper::createdDirThumb('com_k2',$folderImg,$thumbpath);	
					if($layoutStyle !='jv_slide2' && $layoutStyle !='jv_slide1' && $layoutStyle!='jv_slide9' && $layoutStyle!='jv_slide10') {
						if(modJVHeadLineHelper::checkImage($row->introtext)) {
							$lists[$j]->thumbs = modJVHeadLineHelper::getThumb($row->introtext, '_headline', $sThumbWidth,$sThumbHeight,false,$row->id,1,'com_k2',$thumbpath);
						} else {
							$imgFile = 'media/k2/items/cache/'.md5("Image".$row->id).'_XS.jpg';
							if(modJVHeadLineHelper::FileExists(JPATH_BASE.DS.$imgFile)) $lists[$j]->thumbs = modJVHeadLineHelper::getThumbK2Content($imgFile,$sThumbWidth,$sThumbHeight,false,$row->id,1);
						}				
					}
					if($params->get('layout_style') != 'jv_slide4') {
						if(modJVHeadLineHelper::checkImage($row->introtext)) {
							$lists[$j]->thumbl = modJVHeadLineHelper::getThumb($row->introtext, '_headline', $lThumbWidth,$lThumbHeight,false,$row->id,0,'com_k2',$thumbpath);	
						} else {
							$imgFile = 'media/k2/items/cache/'.md5("Image".$row->id).'_XL.jpg';
							if(modJVHeadLineHelper::FileExists(JPATH_BASE.DS.$imgFile)) $lists[$j]->thumbl = modJVHeadLineHelper::getThumbK2Content($imgFile,$lThumbWidth,$lThumbHeight,false,$row->id,0);
						}				
					}
					$lists[$j]->introtext = modJVHeadLineHelper::introContent($row->introtext, $intro_length);					
					$j++;
				}
			}				 				      	
				      	
		}		
		return $lists;		
	}
	//End
	/*
	 * Function get no of item default of each style
	 * @Created by joomvision
	 */	
	function getNoItemByStyle($params){
			switch($params->get('layout_style')){
				case "jv_slide3":
					return(int)$params->get('lago_no_item',3);
					break;
				case "jv_slide2":
					return(int) $params->get('jveoty_no_item',5);	
					break;
				case "jv_slide4":
					return(int) $params->get('sello2_no_item',10);
					break;
				case "jv_slide6":
					return(int) $params->get('sello1_no_item',8);
					break;
				case "jv_slide5":
					return(int)$params->get('maju_no_item',4);
					break;	
				case "jv_slide7":
					return(int)$params->get('jv7_no_item',10);
					break;
				case "jv_slide8":
					return(int)$params->get('pedon_no_item',6);
					break;	
				case "jv_slide1":
					return(int)$params->get('news_no_item');
					break;
				case "jv_slide9":
					return(int) $params->get('jv9_no_item',5);
					break;
				case "jv_slide10":
					return (int)$params->get('zt_flow_no_item',6);
					break;
				default:
					return(int)$params->get('count',0);
					break;	
			}
	}
	//End functiion
}
class modJVSlide7 {
	var $thumbpath;
	function __construct($params){
	$layoutStyle = $params->get('layout_style');
		
		switch($layoutStyle) {
			case "jv_slide4":
				$this->thumbpath = $params->get('jv_sello2_thumbs');
				break;
			case "jv_slide3":		
				$this->thumbpath = $params->get('jv_lago_thumbs');	
				break;
			case "jv_slide6":
				$this->thumbpath = $params->get('jv_sello1_thumbs');	
				break;	
			case "jv_slide5":
				$this->thumbpath = $params->get('jv_maju_thumbs');
				break;
			case "jv_slide8":	
				$this->thumbpath = $params->get('jv_pedon_thumbs');
				break;
			case "jv_slide9":
				$this->thumbpath = $params->get('jv_jv9_main_thumbs');
				break;
			case "jv_slide7":
				$this->thumbpath = $params->get('jv_jv7_main_thumbs');	
				break;
			case "jv_slide2":
				$this->thumbpath = $params->get('jv_eoty_thumbs');
				break;
			case "jv_slide1":
				$this->thumbpath = $params->get('jv_news_thumbs');
				break;
								
		}
	}
	function getSlideContent($params){
		global $mainframe;
		$db         =& JFactory::getDBO();
		$user       =& JFactory::getUser();
		$userId     =(int) $user->get('id');

		$categories =( array )$params->get('categories',array());
		if(count($categories)){
			$strCatId = implode(',',$categories);
			$categoriesCondi = " AND cc.id IN($strCatId)";
		}
		$intro_length = intval($params->get( 'intro_length', 200) );
		$count      = modJVHeadlineCommonHelper::getNoItemByStyle($params);
		$catid      = trim( $params->get('catid') );
		$secid      = trim( $params->get('secid') );
		$aid        = $user->get('aid', 0);
		//$thumbs  = $params->get('main_item_width');
		modJVHeadLineHelper::getLargeThumbSize($params,$width,$height);	
		
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access     = !$contentConfig->get('shownoauth');

		$nullDate   = $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$where      = 'a.state = 1'
		. ' AND( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
		. ' AND( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
		;
		// Ordering		
		$orderBy = $params->get('ordering');
		$ordering = 'a.'.$orderBy.' '.$params->get('sort_order');
		if($catid)
		{
			$ids = explode( ',', $catid );
			JArrayHelper::toInteger( $ids );
			$catCondition = ' AND(cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
		}
		if($secid)
		{
			$ids = explode( ',', $secid );
			JArrayHelper::toInteger( $ids );
			$secCondition = ' AND(s.id=' . implode( ' OR s.id=', $ids ) . ')';
		}
		$show_readmore_link = false;
		$catidcount = count(explode( ',', $catid ));
		$secidcount = count(explode( ',', $secid ));
		if(($catidcount==1) &&($secidcount==1)) {
			$show_readmore_link = true;
		}
		$params->set('show_readmore_link', $show_readmore_link);
		// Content Items only
		$query = 'SELECT a.*,a.id as key1, cc.id as key2, cc.title as cat_title, ' .
            ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
            ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
            ' FROM #__content AS a' .             
            ' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
            ' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
            ' WHERE '. $where .' AND s.id > 0' .
		($access ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
		(count($categories) ? $categoriesCondi:'').
            ' AND s.published = 1' .
            ' AND cc.published = 1' .
            ' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();
		$i      = 0;
		$lists  = array();
		$article_count = count($rows);
		foreach( $rows as $row ){
			$folderImg = DS.$row->id;
			modJVHeadLineHelper::createdDirThumb('com_content',$folderImg,$this->thumbpath,$module_id);
			$lists[$i]->thumb = $lists[$i]->thumb_diff = '';			
			$lists[$i]->title = $row->title;
			$lists[$i]->alias = $row->alias;
			$lists[$i]->link = JRoute::_(modJVHeadlineCommonHelper::renderLinkArticle($params,$row->slug, $row->catslug, $row->sectionid));
			$lists[$i]->introtext = modJVHeadLineHelper::introContent($row->introtext, $intro_length);
			if(modJVHeadLineHelper::checkImage($row->introtext))  $lists[$i]->thumb = modJVHeadLineHelper::getThumb($row->introtext, '_headline', $width,$height,false,$row->id,1,'com_content',$this->thumbpath);
			$i++;		
		}
		return $lists;
	}
	function getItemsByK2($params){
		$db	=& JFactory::getDBO();
		$categories =( array )$params->get('k2_category',array());
		if(count($categories)){
			$strCatId = implode(',',$categories);
			$categoriesCondi = " AND c.id IN($strCatId)";
		}
		$intro_length = intval($params->get( 'intro_length', 200) );	
		$count = modJVHeadlineCommonHelper::getNoItemByStyle($params);		
		modJVHeadLineHelper::getLargeThumbSize($params,$width,$height);	
		// Ordering		
		$orderBy = $params->get('ordering');
		$ordering = 'i.'.$orderBy.' '.$params->get('sort_order');
		$lists = array();			
		if(count($categories)){			
			$date = & JFactory::getDate();
			$user = & JFactory::getUser();
    		$aid = $user->get( 'aid', 0 );
	    	$now = $date->toMySQL();	
	    	$nullDate = $db->getNullDate(); 
    		$query = "SELECT i.*, c.alias as catalias,i.catid    
      				FROM #__k2_items AS i 
      				LEFT JOIN #__k2_categories AS c 
      					ON c.id = i.catid
      				WHERE i.published = 1 ".$categoriesCondi." AND i.access <={$aid}
			      	AND i.trash = 0 AND c.access<={$aid} AND c.trash =0
			      	AND( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )
                    AND( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." ) "." ORDER BY ".$ordering;
			$db->setQuery($query, 0, $count);			
			$rows = $db->loadObjectList();			
			$j = 0;
			if(count($rows)){
				foreach($rows as $row) {
					$folderImg = DS.$row->id;
					modJVHeadLineHelper::createdDirThumb('com_k2',$folderImg);
					$lists[$j]->id = $row->id;
					$lists[$j]->title = $row->title;
					$lists[$j]->link = JRoute::_(modJVHeadlineCommonHelper::renderK2LinkItem($params,$row->id.':'.urlencode($row->alias), $row->catid.':'.urlencode($row->catalias))); 
					$lists[$j]->created = $row->created; 					
					$lists[$j]->thumbs = $lists[$j]->thumbl = '';
					$folderImg = DS.$row->id;
					$lists[$j]->thumb_diff = '';
					$lists[$j]->thumb = $lists[$j]->thumbl = '';
					modJVHeadLineHelper::createdDirThumb('com_k2',$folderImg);						
					if(modJVHeadLineHelper::checkImage($row->introtext)) {
						$lists[$j]->thumb = modJVHeadLineHelper::getThumb($row->introtext, '_headline', $width,$height,false,$row->id,1,'com_k2',$this->thumbpath);
					} else {
						$imgFile = 'media/k2/items/cache/'.md5("Image".$row->id).'_XL.jpg';
						if(modJVHeadLineHelper::FileExists(JPATH_BASE.DS.$imgFile)) $lists[$j]->thumb = modJVHeadLineHelper::getThumbK2Content($imgFile,$width,$height,false,$row->id,1);
					}					
					$lists[$j]->introtext = modJVHeadLineHelper::introContent($row->introtext, $intro_length);				
					$j++;
				}
			}				 				      	
				      	
		}		
		return $lists;		
	}	
}
class JVContentHelperRouter {
	function JVContentHelperRouter(){
		
	}
	function isExistedItemId($id,&$itemId, $catid = 0, $sectionid = 0){
		$needles = array(
			'article'  =>(int) $id,
			'category' =>(int) $catid,
			'section'  =>(int) $sectionid,
		);
		$existedItemId = 0;
		if($item = $this->_findItem($needles)) {
			$existedItemId = 1;
			$itemId = $item->id;
		};
		return $existedItemId;
	}
	function _findItem($needles){
		$component =& JComponentHelper::getComponent('com_content');
		$menus	= &JApplication::getMenu('site', array());
		$items	= $menus->getItems('componentid', $component->id);
		$match = null;
		if(count($needles))
		foreach($needles as $needle => $id){
			if(count($items))
			foreach($items as $item){
				if((@$item->query['view'] == $needle) &&(@$item->query['id'] == $id)) {
					$match = $item;
					break;
				}
			}
			if(isset($match)) {
				break;
			}
		}
		return $match;
	}
	
}
class JVK2HelperRouter{
	function JVK2HelperRouter(){
		
	}
	function isExistedItemId($itemId,$id, $catid = 0){
		$needles = array(
				'item'=>(int)$id,
				'itemlist'=>(int)$catid,
		);
		$existedItemId = 0;
		if($item = $this->_findItem($needles)) {
			$itemId = $item->id;
			$existedItemId = 1;
		}
		return $existedItemId;
	}
	function _findItem($needles)	{

		$component = & JComponentHelper::getComponent('com_k2');

		$menus = & JApplication::getMenu('site', array());
		$items = $menus->getItems('componentid', $component->id);

		$match = null;

		foreach($needles as $needle=>$id)
		{
			if(count($items)){
				foreach($items as $item)
				{
					if($needle=='user'){
						if((@$item->query['task'] == $needle) &&(@$item->query['id'] == $id)) {
							$match = $item;
							break;
						}

					}
					else if($needle=='tag'){
						if((@$item->query['task'] == $needle) &&(@$item->query['tag'] == $id)) {
							$match = $item;
							break;
						}
					}
					else {

						if((@$item->query['view'] == $needle) &&(@$item->query['id'] == $id)) {
							$match = $item;
							break;
						}

						$menuparams = new JParameter( $item->params );
						$catids=$menuparams->get('categories');

						if(is_array($catids)){
							foreach($catids as $catid)	{
								if((@$item->query['view'] == $needle) &&(@(int)$catid == $id)){
									$match = $item;
									break;
								}
							}
						}
						/*else{

							if((@$item->query['view'] == $needle) &&(!isset($item->query['task'])) &&(@$item->query['view'] == 'itemlist') ) {
								$match = $item;
							}

						}*/

					}

				}
			}

			if( isset($match)) {
				break;
			}
		}

		return $match;
	}
	
}
?>