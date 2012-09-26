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


<h1>XCIDEVELOPER USER GUIDE</h1>
<p>XCI system merges the two wonder full systems available in PHP development word CI (Codeigniter the powerfull framework for developers) and Joomla (Powerful CMS to manage your sites). Yes joomla has its own framework but there is a huge community working on CI and once a person starts working in CI he/she rarely accepts any other framework for development due to its simplisity, very fast learning curve and still its complete for any kind of development. But Joomla regularly attracts them as a CMS to deliver their sites faster but again component development in joomla looks complex for CI developers so .. here we are.. Now develop your components in CI with <strong>xCIDeveloper.</strong></p>
<p>Here are a few additions you can use for much faster process</p>
<ol>
  <li>$this-&gt;load-&gt;view(viewname,data,return view true/false, <strong>parse of comntent.prepared true/false</strong>);<br />
    this is one addition to parse your contents with joomlas content plugins. meanse by this last argument as true your content is parsed by joomas plugins</li>
  <li>you can call any of your controller and its function by passing querystring index.php?option=com_{yourcomponent}&amp;controller={your ci controller}&amp;task={your ci function}<br />
  But from a lot of points as in admin you can pass only task as fastest way so intest of passing controller and task you can pass directly <strong>task=controller.function</strong> way meanse any url to <strong>index.php?option=com_{yourcomponent}&amp;task=welcome.help</strong> will call welcome controller's help function</li>
  <li>You can use default CI views but if you want to take advantages of joomlas layout just do the followings<br />
    a) in views folder make a FOLDER with your view name insted viewname.php file.<br />
    b) In that folder make <strong>view.html.php</strong> file (Yes always 
  view.html.php or view.raw.php or view.pdf.php etc. )<br />
  c) In your this View FOLDER make another FOLDER named <strong>tmpl<br />
  </strong>d) In this tmpl folder make default.php as your default layout or xyz.php for xyz layout<br />
  e) now put this code in your view.html.php file <strong>&lt;?php xCILoadTemplate();?&gt; (again yes, always this line without any change)</strong> and you are ready to go.<br />
  f) You can use this view.html.php file as another middle layer to work between controller and view or you just can leave this with above single line</li>
  <li>Every component you create through this system may have its own system folder in admin side, but if you are using more then one xCIDeveloper components then you just can plase this system folder in JOOMLA_ROOT path (No changes to be made in any file) and then create any new project by making off the option <strong>Include Code Igniter System with component</strong></li>
  <li>And yes now no more use of <strong>redirect()<br />
  </strong>insted use <strong>xRedirect(&quot;index.php?option=com_{anycomp}&amp;task={yourtask}&amp;other_parameters_to_pass&quot;,&quot;Message to show on next page after redirection&quot;,&quot;notice | error | {or leav it blank for default} is mode of message&quot;);, </strong>we have not overloaded function because Joomla redirect function has heigher priority then CI's redirect </li>
</ol>
<p>Thats it for now ... start using your CI skills to develop joomla components.</p>
<p>Keep coming on xavoc.com for updates as we are soon launching module and plugins development in CI</p>
<p>Thank you for using our product.</p>
<p>Regards</p>
<p>Xavoc International, Technical Team</p>