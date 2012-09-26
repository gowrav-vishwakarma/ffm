<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if($type == 'logout') : ?>

	<form action="index.php" method="post" name="login" id="">
	<div class="zt-login-form">
		<div class="zt-field-submit"><input type="submit" name="Submit" class="button" value="Login" /></div>
		<?php if ($params->get('greeting')) : ?>
		<div class="zt-field-greeting">	
		<?php if ($params->get('name')) : {
			echo JText::sprintf( 'HINAME', $user->get('name') );
		} else : {
			echo JText::sprintf( 'HINAME', $user->get('username') );
		} endif; ?>
		</div>
		<?php endif; ?>
	</div>
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	</form>

<?php else : ?>

	<?php if(JPluginHelper::isEnabled('authentication', 'openid')) :
			$lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
			$langScript = 	'var JLanguage = {};'.
							' JLanguage.WHAT_IS_OPENID = \''.JText::_( 'WHAT_IS_OPENID' ).'\';'.
							' JLanguage.LOGIN_WITH_OPENID = \''.JText::_( 'LOGIN_WITH_OPENID' ).'\';'.
							' JLanguage.NORMAL_LOGIN = \''.JText::_( 'NORMAL_LOGIN' ).'\';'.
							' var modlogin = 1;';
			$document = &JFactory::getDocument();
			$document->addScriptDeclaration( $langScript );
			JHTML::_('script', 'openid.js');
	endif; ?>
	<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login">
	<div id="zt-login">
		<div class="clearfix">
			<div class="zt-user" style="margin-top:4px;">
				<input id="modlgn_username" type="text" name="username" class="inputbox" alt="username" size="18" value="<?php echo JText::_('Username') ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('Username') ?>';" onfocus="if(this.value=='<?php echo JText::_('Username') ?>') this.value='';" />
			</div>
			<div class="zt-user" style="margin-top:4px;">
				<input id="modlgn_passwd" type="password" name="passwd" class="inputbox" size="18" alt="password" value="<?php echo JText::_('Password') ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('Password') ?>';" onfocus="if(this.value=='<?php echo JText::_('Password') ?>') this.value='';" />
			</div>
			
			
			<div class="zt-user">
				<input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />
			</div>
		</div>
		

		<input type="hidden" name="option" value="com_user" />
		<input type="hidden" name="task" value="login" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</div>
	</form>
<?php endif; ?>