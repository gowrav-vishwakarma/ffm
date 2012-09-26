<?php
// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );
define('TEMPLATE', 'tx_zoe');

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JElementTxparamhelper extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Txparamhelper';

	function fetchElement( $name, $value, &$node, $control_name ) {
		if (substr($name, 0, 1) == '@'  ) {
			$name = substr($name, 1);
			if (method_exists ($this, $name)) {
				return $this->$name ($name, $value, $node, $control_name);
			}
		} else {
			$subtype = ( isset( $node->_attributes['subtype'] ) ) ? trim($node->_attributes['subtype']) : '';
			if (method_exists ($this, $subtype)) {
				return $this->$subtype ($name, $value, $node, $control_name);
			}
		}
		return; 
	}
	
	function fetchTooltip( $label, $description, &$node, $control_name, $name )
	{
		if (substr($name, 0, 1) == '@' || !isset( $node->_attributes['label'] ) || !$node->_attributes['label']) return;
		else return parent::fetchTooltip ($label, $description, $node, $control_name, $name);
	}
	
	/**
	 * render title: name="@title"
	 */
	function title( $name, $value, &$node, $control_name ) {	
		$_title			= ( isset( $node->_attributes['label'] ) ) ? $node->_attributes['label'] : '';
		$_description	= ( isset( $node->_attributes['description'] ) ) ? $node->_attributes['description'] : '';
		$_url			= ( isset( $node->_attributes['url'] ) ) ? $node->_attributes['url'] : '';
		$class			= ( isset( $node->_attributes['class'] ) ) ? $node->_attributes['class'] : '';
		$group			= ( isset( $node->_attributes['group'] ) ) ? $node->_attributes['group'] : '';
		$group			= $group ? "id='params$group-group'":"";
		if ( $_title ) {
			$_title = html_entity_decode( JText::_( $_title ) );
		}

		if ( $_description ) { $_description = html_entity_decode( JText::_( $_description ) ); }
		if ( $_url ) { $_url = " <a target='_blank' href='{$_url}' >[".html_entity_decode( JText::_( "Demo" ) )."]</a> "; }

		$html = '
		<h4 class="block-head" '.$group.'><span class='.$class.'>'.$_title.$_url.'</span></h4>
		<div class="block-des '.$class.'">'.$_description.'</div>
		';

		return $html;
	}
	/**
	 * include js: name="@js" file="filepath.js"
	 */
	function js( $name, $value, &$node, $control_name ) {
		$file = ( isset( $node->_attributes['file'] ) ) ? trim($node->_attributes['file']) : '';
		
		if(strpos($file, 'http') !== 0) {
			$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(dirname(__FILE__)) ));
			$uri = str_replace("/administrator/", "", $uri);
			$uri = $uri."/";
		} else {
			$uri = $file;
			$file = '';
		}
		JHTML::script($file, $uri);
		return ;
	}

	/**
	 * include css: name="@css" file="filepath.css"
	 */
	function css( $name, $value, &$node, $control_name ) {
		$file = ( isset( $node->_attributes['file'] ) ) ? trim($node->_attributes['file']) : '';
		
		if(strpos($file, 'http') !== 0) {
			$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(dirname(__FILE__)) ));
			$uri = str_replace("/administrator/", "", $uri);
			$uri = $uri."/";
		} else {
			$uri = $file;
			$file = '';
		}
		JHTML::stylesheet($file, $uri);
		return ;
	}
	
	/**
	 * render js to control setting form.
	 */
	function group( $name, $value, &$node, $control_name ){ 
		$attributes = $node->attributes(); // echo '<pre>'.print_r($attributes); die;
		$groups = array();
		if( isset($attributes['value']) && $attributes['value'] != "" ){
			$groups = preg_split("/[|]/", $attributes['value']);
		}
		
		if (!defined ('_TX_PARAM_HELPER')) {
			define ('_TX_PARAM_HELPER', 1);
            
			$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(__FILE__) ));
			$uri = str_replace("/administrator/", "", $uri);
            
			JHTML::stylesheet('txparamhelper.css', $uri."/");
			JHTML::script('txparamhelper.js', $uri."/");
		}
?>
<script type="text/javascript">
		window.addEvent( "domready", function(){
			<?php foreach ($groups as $group):?>
			inittxpramhelpergroup( "<?php echo $group; ?>", { hideRow:<?php echo(isset($attributes['hiderow']) ? $attributes['hiderow']:false) ?>} );
			<?php endforeach;?>
		} );
</script>
<?php		
	return;
	}
} 
