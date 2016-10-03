<?php

//Collect data from controller
$msg = $this->vars['msg'];
$pageTitle = $this->vars['pageTitle'];
$pageMessage = $this->vars['pageMessage'];
$persistence = $this->vars['persistence'];
include_once ROOT_DIR.'views/header.inc';

?>
<?php echo $msg;?>
<br><br>
<form method="post" action="<?php echo URL_DIR.'login/register';?>">
	<table align="center">		
		<tr>
			<td>
			<h1>S'enregistrer</h1>
			Prenom:<br><input type="text" name="firstname" value="<?php echo $persistence[0];?>"><br>
			Nom:<br><input type="text" name="lastname" value="<?php echo $persistence[1];?>"><br>
			Mail:<br><input type="email" name="mail" value="<?php echo $persistence[2];?>"><br>
			Téléphone:<br><input type="text" name="phone" value="<?php echo $persistence[3];?>"><br>
			N°Adhérent(si existant):<br><input type="number" name="memberNumber" value="<?php echo $persistence[4];?>"><br>
			Password:<br><input type="password" name="password" value="<?php echo $persistence[5];?>"><br><br>
			<input type="submit" name="action" value="Register"><br><br>
			<a href="<?php echo URL_DIR.'login/login';?>">Login</a>
			</td>
		</tr>
	</table>
</form>

<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';?>