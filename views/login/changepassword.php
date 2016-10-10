<?php
$msg = $this->vars['msg'];
$pageTitle = $this->vars['pageTitle'];
$pageMessage = $this->vars['pageMessage'];
include_once ROOT_DIR.'views/header.inc';
?>

    <br><br>
    <form action="<?php echo URL_DIR.'login/changePassword';?>" method="post">
        <table align="center">
            <tr>
                <td>
                    <?php echo $msg;?>
                    <h1><?php echo $lang['PASSWORD_CHANGE']; ?> :</h1>
                    <?php echo $lang['NEW_PASSWORD']; ?> :<br><input type="password" name="newPassword" size="25"/><br><br>
                    <?php echo $lang['NEW_PASSWORD']; ?> :<br><input type="password" name="newPasswordConfirmation" size="25"/><br><br>
                    <input class="btn btn-primary" type="submit" name="Submit" value="<?php echo $lang['CHANGE']; ?>"/>

                    <br/><br/>
                </td>
            </tr>
        </table>
    </form>







<?php

include_once ROOT_DIR.'views/footer.inc';

?>