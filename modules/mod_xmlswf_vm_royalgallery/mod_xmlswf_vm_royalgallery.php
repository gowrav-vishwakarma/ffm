<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
if (!defined("VM_CATORDER_CLSSS")) {
class DgIparams
{
	var $id;
	var $ref;
	var $order;
	var $name;
}
class DGitem
{
	var $next;
	var $prev;
	var $par; // parrent
	var $firstc; //first child DGitem
	var $params;
	//var $curr_next;
	var $cii;
	var $c_info;
}

class Dgraph
{
	var $first; //first DGitem
	function Dgraph()
	{
		$this->first = New DGitem();
		$this->first->next = NULL;
		$this->first->prev = NULL;
		$this->first->par = NULL;
		$this->first->firstc = NULL;
		$this->first->params = New DgIparams();
		$this->first->params->id = 0;
		$this->first->params->ref = -1;
		$this->first->params->order = 0;
		$this->first->params->name = '';
		//$this->curr_next = $this->first;
		$this->cii = 0;
		$this->c_info = array();
	}
	function BuildGraph (&$arr_igr) {
		if ($arr_igr && is_array($arr_igr) && count($arr_igr) > 0) {
			foreach ($arr_igr as $akey => $curr_cigr) {
				if ($this->Add($curr_cigr, $this->first)) {
					//unset($arr_igr[$akey]);
				}
			}
			//return BuildGraph($arr_igr, $bgraph);
		} else {
			return false;
		}
	}
	function Add($newgi, $currgi)
	{
//echo '$newgi:';print_r($newgi);
//echo '$currgi:';print_r($currgi);
		if ($newgi->params->ref == $currgi->params->ref) {
			if ($newgi->params->order < $currgi->params->order) {
				$newgi->next = $currgi;
				$newgi->prev = $currgi->prev;
				$newgi->par = $currgi->par;
				$currgi->prev = $newgi;
				if ($newgi->prev) {
					$newgi->prev->next = $newgi;
				} else {
					$newgi->par->firstc = $newgi;
				}
				return $newgi;
			} else {
				if ($currgi->next) {
					return $this->Add($newgi, $currgi->next);
				} else {
					$currgi->next = $newgi;
					$newgi->prev = $currgi;
					$newgi->par = $currgi->par;
					$newgi->next = NULL;
					return $newgi;
				}
			}
		} else {
			if ($newgi->params->ref == $currgi->params->id && !$currgi->firstc) {
				$currgi->firstc = $newgi;
				$newgi->next = NULL;
				$newgi->prev = NULL;
				$newgi->par = $currgi;
				return $newgi;
			} else {
				$theNext = $this->Next($currgi);
				if ($theNext) {
					return $this->Add($newgi, $theNext);
				} else {
					return false;
				}
			}
		}
	}
	function GetCatInfo($curr_next)
	{
		//$this->curr_next = $this->first;
		//$this->cii = 0;
		$cnext = $this->Next($curr_next);
		if ($cnext) {
			$this->c_info[$this->cii]['id'] = $cnext->params->id;
			$this->c_info[$this->cii]['name'] = $cnext->params->name;
			$this->cii++;
			return $this->GetCatInfo($cnext);
		} else {
			return $this->c_info;
		}
	}
	function Next($currgi)
	{
		if ($currgi->firstc) {
			return $currgi->firstc;
		} elseif($currgi->next) {
			return $currgi->next;
		} else {
			$thePnex = $this->Pnex($currgi);
			if ($thePnex) {
				return $thePnex;
			} else {
				return false;
			}
		}
	}
	function Pnex($currgi)
	{
		if ($currgi === $this->first) {
			return false;
		} else {
			if ($currgi->par->next) {
				return $currgi->par->next;
			} else {
				return $this->Pnex($currgi->par);
			}
		}
	}
}
define("VM_CATORDER_CLSSS", 1);
}

$bannerWidth                   = intval($params->get( 'bannerWidth', 912 ));
$bannerHeight                  = intval($params->get( 'bannerHeight', 700 ));
$backgroundColor         = trim($params->get( 'backgroundColor', '#FFFFFF' ));
$wmode                 = trim($params->get( 'wmode', 'window' ));
$id    = intval($params->get( 'category_id', 0 ));
$catppv_id = '';

if( file_exists(dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' )) {
	require_once( dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' );
}
else {
	require_once( dirname(__FILE__).'/../components/com_virtuemart/virtuemart_parser.php' );
}

require_once(CLASSPATH.'ps_product.php');
$ps_product = new ps_product;


if (!function_exists('create_vmroyal_xml_files')) {
function create_vmroyal_xml_files($params, &$catppv_id)
{
$database = new ps_DB();
$cat_id                    = trim($params->get( 'category_id', '0' ));
$id                    = split(",",$cat_id);
$load_curr                 = trim($params->get( 'load_curr', '1' ));
$scolour                    = trim($params->get( 'scolour', '0x666666' ));
$bgcolour                    = trim($params->get( 'bgcolour', '0xffffff' ));
$textcolour                    = trim($params->get( 'textcolour', '0x333333' ));
$bordercolour                    = trim($params->get( 'bordercolour', '0xCCCCCC' ));
$thumbscale = (trim($params->get( 'thumbscale', '1' )) == 1) ? 'true' : 'false';
$imagescale = (trim($params->get( 'imagescale', '1' )) == 1) ? 'true' : 'false';
$showdesc = (trim($params->get( 'showdesc', '2' )) == 1) ? 'true' : 'false';

//echo 'before in load'; echo $load_curr; exit();
if ($load_curr == 1) {
	$curr_uri  =& JFactory::getURI();
	$curr_uri_query = $curr_uri->getQuery(true);
	if(isset($curr_uri_query['option']) && $curr_uri_query['option'] == 'com_virtuemart') {
		if (isset($curr_uri_query['category_id'])) {
			unset($id);
			$id = array(0=>$curr_uri_query['category_id']);
		}
	}
}

if (1 == trim($params->get( 'catppv_flag', '2' ))) {
	$catppv_id = implode("_", $id);
}
$module_path = dirname(__FILE__).DS;
if (1 == trim($params->get( 'catppv_flag', '2' )) && !file_exists($module_path . 'gallery'. $catppv_id . '.swf') ) {
	copy($module_path . 'gallery.swf', $module_path . 'gallery'. $catppv_id . '.swf');
}

if ($id[0]!=0)
{
	$query = "Select pc.category_id, pc.category_publish, pc.category_name FROM #__{vm}_category pc" ;		
	$query .= "\n where pc.category_publish = 'Y'";
	$query .= " and (";
	for ($i=0; $i<sizeof($id)-1; $i++) {
		$query .= "pc.category_id=".$id[$i]." or ";
	}
	$query .= "pc.category_id=".$id[$i].")";
	$query .= " ORDER BY pc.list_order";
	$database->query($query);
	$rows = $database->record;
	while ($database->next_record()) {
		$c_id_name[$database->f('category_id')] = $database->f('category_name');
	}
	$cats_info = array();
	$cii = 0;
	foreach($id as $curr_id) {
		$cats_info[$cii] = array();
		$cats_info[$cii]['id'] = $curr_id;
		$cats_info[$cii]['name'] = $c_id_name[$curr_id];
		$cii++;
	}
} else {
	$query = "Select pc.category_id, pc.category_publish, pc.category_name, pc.list_order, px.category_parent_id FROM #__{vm}_category pc, #__{vm}_category_xref px" ;
	$query .= "\n where pc.category_publish = 'Y' and px.category_child_id=pc.category_id";
	$query .= " ORDER BY px.category_parent_id, pc.list_order";
	$database->query($query);
	$rows = $database->record;
	$ci = 0;
	$cgr_info = array();
	while ($database->next_record()) {
		$cgr_info[$ci] = new DGitem();
		$cgr_info[$ci]->next = NULL;
		$cgr_info[$ci]->prev = NULL;
		$cgr_info[$ci]->par = NULL;
		$cgr_info[$ci]->firstc = NULL;
		$cgr_info[$ci]->params->id =  $database->f('category_id');
		$cgr_info[$ci]->params->ref = $database->f('category_parent_id');
		$cgr_info[$ci]->params->order = $database->f('list_order');
		$cgr_info[$ci]->params->name = $database->f('category_name');
		$ci++;
	}

	$cat_graph =  new Dgraph();
	$cat_graph->BuildGraph($cgr_info);
	
	$cats_info = array();
	
	$cats_info = $cat_graph->GetCatInfo($cat_graph->first);

}

$xml_data_filename = $module_path.'picturebase'.$catppv_id.'.xml';
$xml_data_data = '<gallery scrollcolour="'.$scolour.'" bgcolour="'.$bgcolour.'" textcolour="'.$textcolour.'" bordercolour="'.$bordercolour.'" thumbscale="'.$thumbscale.'" imagescale="'.$imagescale.'" showdesc="'.$showdesc.'">
';

$xml_data_data_btns = '';
$c_name = array();
$module_path = dirname(__FILE__).DS;
foreach ($cats_info as $curr_cat) {
	$get_catxml = write_vmroyal_xml_data($curr_cat['name'], $curr_cat['id'], $params);
	if ($get_catxml['flag']) {
		$xml_data_data_btns .= $get_catxml['xml_data'];
	}
}
$xml_data_data .= $xml_data_data_btns . '</gallery>';
$xml_prodgallery_file = fopen($xml_data_filename,'w');
fwrite($xml_prodgallery_file, $xml_data_data);
fclose($xml_prodgallery_file);
}
}

if (!function_exists('write_vmroyal_xml_data')) {
function write_vmroyal_xml_data($cat_name, $cat_id, $params)
{
global $mosConfig_absolute_path, $sess;
$tsize = $params->get('tsize', 14);

$ret_array = array('flag' => false, 'xml_data' => '');

$images_path    		 = trim($params->get( 'images_path', 'components/com_virtuemart/shop_image/product/' ));

	if ($params->get('show_price')=="yes")
			{
$query = "Select p.product_id, p.category_id, pc.category_publish, pc.category_flypage, pp.product_id  as pp_id, pp.product_parent_id, pp.product_name, pp.product_thumb_image, pp.product_weight, pp.product_weight_uom, pp.product_full_image, pp.product_s_desc, pr.product_id, pr.product_price,pr.price_quantity_start, pr.price_quantity_end, pt.tax_rate FROM #__{vm}_product_category_xref p,#__{vm}_category pc,#__{vm}_product pp LEFT JOIN  #__{vm}_product_price AS pr ON pp.product_id = pr.product_id" ;
			
$query .= " LEFT JOIN  #__{vm}_tax_rate AS pt ON pp.product_tax_id = pt.tax_rate_id \n where pc.category_id=".$cat_id." and pc.category_id=p.category_id and pc.category_publish = 'Y' and pp.product_id = p.product_id and pp.product_parent_id=0 and pp.product_publish = 'Y' ORDER BY p.product_list LIMIT 20";
			}
			else
			{
$query = "Select p.product_id, p.category_id, pc.category_publish, pc.category_flypage, pp.product_id as pp_id, pp.product_parent_id, pp.product_name, pp.product_thumb_image, pp.product_weight, pp.product_weight_uom, pp.product_full_image, pp.product_s_desc FROM #__{vm}_product_category_xref p,#__{vm}_category pc,#__{vm}_product pp" ;
			
$query .= "\n where pc.category_id=".$cat_id." and pc.category_id=p.category_id and pc.category_publish = 'Y' and pp.product_id = p.product_id and pp.product_parent_id=0 and pp.product_publish = 'Y' ORDER BY p.product_list LIMIT 20";
			
			}
$xml_data = '';
$db = new ps_DB();
$db->query($query);
$rows = $db->record;

$uri_root = JURI::root();
$uri_root_arr = explode('/', $uri_root);
if(count($uri_root_arr) > 4){
	$uri_r_flds = array_slice($uri_root_arr, 3);
	$uri_fldstr = implode ('/', $uri_r_flds);
	$uri_fldstr = (substr($uri_fldstr, 0, 4));
	if (substr($uri_fldstr, -1) == '/') {
		$uri_fldstr = substr($uri_fldstr, 0, -1);
	}
	$uri_rfirst_arr = array_slice($uri_root_arr, 0, 3);;
	$uri_rfirst = implode ('/', $uri_rfirst_arr);
} else {
	$uri_fldstr = false;
}
if (substr($uri_root, -1) == '/') {
		$uri_root = substr($uri_root, 0, -1);
}

	while ($db->next_record()) 
{
	$ret_array['flag'] = true;
	
	$price_txt = '';
	if ($params->get('show_price')=="yes") {
		//$price_txt .= $params->get('price_text', 'price: ');
		$price_txt .= ' ';
		$price_txt .= $params->get('currency', '$');
		$abs_price = abs($db->f('product_price'));
		$pricetax    = $params->get('pricetax', 'yes');
		if ($pricetax == 'yes') {
			$trate = abs($db->f('tax_rate'));
			if($trate > 0) {
				$abs_price = round((1 + $trate) * $abs_price, 2);
			}
		}
		$price_txt .= $abs_price;
	}
	
	if( !$db->f('category_flypage') ) {
		$flypage = ps_product::get_flypage( $db->f('pp_id'));
	} else {
		$flypage = $db->f('category_flypage');
	}
	
	$cu_url = $sess->url(URL.'index.php?page=shop.product_details&flypage='.$flypage.'&product_id='.$db->f('pp_id').'&category_id='.$db->f('category_id'));
	if (stripos('a' . $cu_url, 'http://') == 1) {
		$curr_link = $cu_url;
	} else {
		if ($uri_fldstr) {
			$stri_ufld = stripos ( 'a' . $cu_url, $uri_fldstr);
			if ($stri_ufld != 1 && $stri_ufld != 2) {
				if (substr($cu_url, 0, 1) == '/') {
					$curr_link = $uri_root . $cu_url;
				} else {
					$curr_link = $uri_root .'/'. $cu_url;
				}
			} else {
				if ($stri_ufld == 1) {//if no '/'
					$curr_link = $uri_rfirst.'/'.$cu_url;
				} else {
					if ($stri_ufld == 2) {
						if (substr($cu_url, 0, 1) == '/') {
							$curr_link = $uri_rfirst.$cu_url;
						} else {
							$curr_link = $uri_root .'/'. $cu_url;
						}
					}
				}
			}
		} else {
			if (substr($cu_url, 0, 1) == '/') {
				$curr_link = $uri_root . $cu_url;
			} else {
				$curr_link = $uri_root .'/'. $cu_url;
			}
		}
	}
		
		$xml_data .= '<image title="' . $db->f('product_name') . $price_txt . '" src="' .JURI::root(). $images_path . $db->f('product_full_image') . '" thmb="' .JURI::root(). $images_path . $db->f('product_thumb_image') . '" link="'.$curr_link.'" tsize="'.$tsize.'"  />
';
}
		$ret_array['xml_data'] = $xml_data;
		return $ret_array;
}
}

create_vmroyal_xml_files($params, $catppv_id);

?>
<div align="center">

<script language="javascript">AC_FL_RunContent = 0;</script>
<script src="<?php echo JURI::root()?>modules/mod_xmlswf_vm_royalgallery/AC_RunActiveContent.js" language="javascript"></script>
<script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
			AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0',
			'width', '<?php echo $bannerWidth;?>',
			'height', '<?php echo $bannerHeight; ?>',
			'src', '<?php echo JURI::root()?>modules/mod_xmlswf_vm_royalgallery/gallery<?php echo $catppv_id; ?>',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', '<?php echo $wmode;?>',
			'devicefont', 'false',
			'flashvars','&lifeline=<?php echo JURI::root()?>modules/mod_xmlswf_vm_royalgallery/picturebase<?php echo $catppv_id; ?>.xml',
			'id', 'vertsh',
			'bgcolor', '<?php echo $backgroundColor; ?>',
			'name', 'vertsh',
			'menu', 'true',
			'allowFullScreen', 'false',
			'allowScriptAccess','sameDomain',
			'movie', '<?php echo JURI::root()?>modules/mod_xmlswf_vm_royalgallery/gallery<?php echo $catppv_id; ?>',
			'salign', ''
			); //end AC code
	}
</script>

<noscript>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?php echo $bannerWidth;?>" height="<?php echo $bannerHeight; ?>" id="vertsh" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="flashvars" value="&lifeline=modules/mod_xmlswf_vm_royalgallery/picturebase<?php echo $catppv_id; ?>.xml"/>
	<param name="movie" value="<?php echo JURI::root()?>modules/mod_xmlswf_vm_royalgallery/gallery<?php echo $catppv_id; ?>.swf" />
	<param name="quality" value="high" />
	<param name="bgcolor" value="<?php echo $backgroundColor; ?>" />	
	<embed src="<?php echo JURI::root()?>modules/mod_xmlswf_vm_royalgallery/gallery<?php echo $catppv_id; ?>.swf" flashvars="&lifeline=modules/mod_xmlswf_vm_royalgallery/picturebase<?php echo $catppv_id; ?>.xml" quality="high" bgcolor="<?php echo $backgroundColor; ?>" width="<?php echo $bannerWidth;?>" height="<?php echo $bannerHeight; ?>" name="vertsh" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>
</div>