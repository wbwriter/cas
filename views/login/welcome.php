<?php


//Collect data from controller and session
$msg = $this->vars['msg'];
$user = $_SESSION['user'];
$events = $this->vars['user_events']; //Declared in the controller
$events_msg = $this->vars['user_events_msg'];
include_once ROOT_DIR . 'views/header.inc';
?>
<<<<<<< HEAD
<br><br>

<section id="sorties_container" class="row col-lg-12">
<h1><?php echo $lang['WELCOME_H1_LISTEVENTS']; ?></h1>
    <table class="table table-striped col-lg-5">
    <tr>
        <th>Date start</th>
        <th>Date end</th>
        <th>Status</th>
        <th>Title</th>
    </tr>
    <?php

    foreach ($events as $e) {
        $status = "Coming soon.."; //TODO : Add status in the DB
        $startDate = $e->getStartDate();
        $endDate = $e->getEndDate();
        $title = $e->getTitle();
        $description = $e->getDescription(); //For the tooltip

        $startDate = $startDate->format('Y-m-d H:i:s');
        $endDate = $endDate->format('Y-m-d H:i:s');
        
        echo "<tr><td>$startDate</td><td>$endDate</td><td>$status</td><td>$title</td></tr>";
    }

    ?>

</table>
	
    <?php if ($events_msg != 'rien'){
    echo "<div id=\"message\" class=\"col-md-12\">
=======

<div class="content">
    <div class="container">
        <div class="row">
            <section id="sorties_container" class="row col-lg-12">
                <h1><?php echo $lang['WELCOME_H1_LISTEVENTS']; ?></h1>
                <table class="table table-striped col-lg-5">
                    <tr>
                        <th>Date start</th>
                        <th>Date end</th>
                        <th>Status</th>
                        <th>Title</th>
                    </tr>
                    <?php

                    foreach ($events as $e) {
                        $status = "Coming soon.."; //TODO : Add status in the DB
                        $startDate = $e->getStartDate();
                        $endDate = $e->getEndDate();
                        $title = $e->getTitle();
                        $description = $e->getDescription(); //For the tooltip

                        /*$startDate = $startDate->format('Y-m-d H:i:s');
                        $endDate = $endDate->format('Y-m-d H:i:s');
                        */


                        echo "<tr><td>$startDate</td><td>$endDate</td><td>$status</td><td>$title</td></tr>";
                    }

                    ?>

                </table>

                <?php if ($events_msg != 'rien'){
                    echo "<div id=\"message\" class=\"col-md-12\">
>>>>>>> origin/master
        <p> $events_msg  </p>
    </div>";
                } ?>


            </section>

            <table align="center">
                <tr>
                    <td>
                        <?php echo $msg; ?>
                        <h1><?php echo $lang['WELCOME'], ' ' . $user->getFirstname() . ' ' . $user->getLastname(); ?></h1>
                        <h3><?php echo $lang['MY_PERSONNAL_DATA']; ?></h3>
                        <form action="<?php echo URL_DIR . '/login/welcome'; ?>" method="post">
                            <?php echo $lang['FIRSTNAME']; ?> :<br><input type="text" name="firstname" size="25"
                                                                          value="<?php echo $user->getFirstname(); ?>"/><br>
                            <?php echo $lang['LASTNAME']; ?> :<br><input type="text" name="lastname" size="25"
                                                                         value="<?php echo $user->getLastname(); ?>"/><br>
                            <?php echo $lang['PHONE']; ?> :<br><input type="text" name="phone" size="25"
                                                                      value="<?php echo $user->getPhone(); ?>"/><br><br>
                            <input type="submit" name="action" value="<?php echo $lang['CHANGE_DATA']; ?>"><br><br>
                        </form>
                        <br>
                        <a href="<?php echo URL_DIR . '/login/logout'; ?>"><?php echo $lang['LOGOUT']; ?></a><br>
                        <a href="<?php echo URL_DIR . '/login/changepassword'; ?>"><?php echo $lang['PASSWORD_CHANGE']; ?></a>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</div>



<?php
unset($_SESSION['msg']);
include_once ROOT_DIR . 'views/footer.inc';
?>

