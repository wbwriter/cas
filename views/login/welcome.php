<?php 
include_once ROOT_DIR.'views/header.inc'; 

//Collect data from controller and session
$msg = $this->vars['msg'];
$user = $_SESSION['user'];

?>
<br><br>
	<table align="center">		
		<tr>
			<td>
				<?php echo $msg;?>
				<h1><?php echo $lang['WELCOME'], ' '.$user->getFirstname().' '.$user->getLastname();?></h1>
				<h3><?php echo $lang['MY_PERSONNAL_DATA']; ?></h3>
				<form action="<?php echo URL_DIR.'login/welcome';?>" method="post">
					<?php echo $lang['FIRSTNAME']; ?> :<br><input type="text" name="firstname" size="25" value="<?php echo $user->getFirstname(); ?>"/><br>
					<?php echo $lang['LASTNAME']; ?> :<br><input type="text" name="lastname" size="25" value="<?php echo $user->getLastname(); ?>"/><br>
					<?php echo $lang['PHONE']; ?> :<br><input type="text" name="phone" size="25" value="<?php echo $user->getPhone(); ?>"/><br><br>
					<input type="submit" name="action" value="<?php echo $lang['CHANGE_DATA']; ?>"><br><br>
				</form>
				<br>
				<a href="<?php echo URL_DIR.'login/logout';?>"><?php echo $lang['LOGOUT']; ?></a><br>
				<a href="<?php echo URL_DIR.'login/changepassword';?>"><?php echo $lang['PASSWORD_CHANGE']; ?></a>
			</td>
		</tr>
	</table>
</form>
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

