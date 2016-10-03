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
				<h1>Welcome <?php echo ' '.$user->getFirstname().' '.$user->getLastname();?></h1>
				<h3>Mes données personnelles</h3>
				<form action="<?php echo URL_DIR.'login/welcome';?>" method="post">
					Firstname:<br><input type="text" name="firstname" size="25" value="<?php echo $user->getFirstname(); ?>"/><br>
					Lastname:<br><input type="text" name="lastname" size="25" value="<?php echo $user->getLastname(); ?>"/><br>
					Phone number:<br><input type="text" name="phone" size="25" value="<?php echo $user->getPhone(); ?>"/><br><br>
					<input type="submit" name="action" value="Changer"><br><br>
				</form>
				<br>
				<a href="<?php echo URL_DIR.'login/logout';?>">Logout</a><br>
				<a href="<?php echo URL_DIR.'login/changepassword';?>">Change password</a>
			</td>
		</tr>
	</table>
</form>
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

