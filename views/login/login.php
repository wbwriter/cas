
<?php
$msg = $this->vars['msg'];
$pageTitle = $this->vars['pageTitle'];
$pageMessage = $this->vars['pageMessage'];
include_once ROOT_DIR.'views/header.inc';

//Collect data from controller


?>


<br><br>
<form action="<?php echo URL_DIR.'login/connection';?>" method="post">
	<table align="center">		
		<tr>
			<td>
				<?php echo $msg;?>
				<h1><?php echo $lang['CONNECT_MENU_BUTTON']; ?></h1>
				<?php echo $lang['EMAIL']; ?> :<br><input type="text" name="mail" size="25"/><br>
				<?php echo $lang['PASSWORD']; ?> :<br><input type="password" name="password" size="25"/><br><br>
				<input class="btn btn-primary" type="submit" name="Submit" value="<?php echo $lang['OK_BUTTON']; ?>"/>
				<br/><br/>
				<?php echo $lang['FORGOT_PASSWORD']; ?> ? <a href="<?php echo 'login/resetpassword';?>">(<?php echo $lang['RESET_PASSWORD']; ?>)</a><br>
				<?php echo $lang['NO_ACCOUNT']; ?> ? <a href="<?php echo 'login/newuser';?>">(<?php echo $lang['REGISTER']; ?>)</a>
			</td>
		</tr>
	</table>
</form>
<br/><br/><br/><br/>

<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';

?>