
<?php

$msg = $this->vars['msg'];
$pageTitle = $this->vars['pageTitle'];
$pageMessage = $this->vars['pageMessage'];
include_once ROOT_DIR.'views/header.inc';

?>

<br><br>
<form action="<?php echo URL_DIR.'login/resetpassword';?>" method="post">
    <table align="center">
        <tr>
            <td>
                <?php echo $msg;?>
                <h1>Récupération du mot de passe</h1>
                E-mail:<br><input type="email" name="recoveryMail" size="25"/><br><br>
                <input class="btn btn-primary" type="submit" name="Submit" value="  OK  "/>

                <br/><br/>
            </td>
        </tr>
    </table>
</form>







<?php

include_once ROOT_DIR.'views/footer.inc';

?>
