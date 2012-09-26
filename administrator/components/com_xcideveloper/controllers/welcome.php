 <?php
/*------------------------------------------------------------------------
# com_xcideveloper - Seamless merging of CI Development Style with Joomla CMS
# ------------------------------------------------------------------------
# author    Xavoc International / Gowrav Vishwakarma
# copyright Copyright (C) 2011 xavoc.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.xavoc.com
# Technical Support:  Forum - http://xavoc.com/index.php?option=com_discussions&view=index&Itemid=157
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
            xDeveloperToolBars::getDefaultToolBar();
            $this->load->model('projects');
            $data['result']=$this->projects->getAll()->result();
            $data['com_extplorer']=is_dir(JPATH_ADMINISTRATOR.DS."components".DS."com_extplorer");
            $this->load->view('xcideveloper.html',$data,false,true);
	}

        function help(){
            xRedirect("../index.php?option=com_xcideveloper");
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */