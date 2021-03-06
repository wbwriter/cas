<?php

class loginController extends Controller
{
    /**
     * Method called by the form of the page login.php
     */

    function connection()
    {
        //Get data posted by the form
        $mail = $_POST['mail'];
        $pwd = $_POST['password'];
        $lang = $this->lang;


        //Check if data valid
        if (empty($mail) or empty($pwd)) {
            $_SESSION['msg'] = '<span class="error">' . $lang['E_REQUIRED_FIELD_EMPTY'] . '</span>';
            $this->redirect('/login');
        } else {
            //Load user from DB if exists
            $result = User::connect(htmlentities($mail), htmlentities($pwd));

            //Put user in session if exists or return error msg
            if (!$result) {
                $_SESSION['msg'] = '<span class="error">' . $lang['E_USERNAME_PASSWORD_INCORRECT'] . '</span>';
                $this->redirect('/login');

            } else {

                $_SESSION['msg'] = '';
                $_SESSION['user'] = $result;
                $this->redirect('/login', 'welcome');
            }
        }

    }

    /**
     * Method that controls the page 'login.php'
     */
    function login()
    {
        $lang = $this->lang;
        //if a user is active he cannot re-login
        if ($this->getActiveUser()) {
            $this->redirect('/login', 'welcome');
            exit;
        }

        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['pageTitle'] = $lang['CONNECT_MENU_BUTTON'];
        $this->vars['pageMessage'] = $lang['LOGIN_TO_ACCESS_EVENTS'];


    }

    /**
     *  Method that controls the page 'resetpassword.php'
     */

    function resetPassword()
    {

        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['pageTitle'] = "Récupération de mot de passe";
        $this->vars['pageMessage'] = "";

        /*
         * This bit of codes resets the password for the mail entered. it works as such.
         * 1. It ask the db which users corresponds to the mail entered.
         * 2. It creates a timed change password requests and stores a sha1 version of a secret key in the database.
         * 3. It sends by e-mail to the user a link with the secret key and a link to reset the password.
         * 4. It displays a confirmation or a failure message.
         */

        if (!empty($_POST)) {


            try {

                if (User::getUserFromMail($_POST['recoveryMail']) == null) {
                    $_SESSION['msg'] = '<span class="error">' . $this->lang['E_FAILED_TO_DELIVER_EMAIL'] . '</span>';
                    $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
                } else {
                    $secretKey = User::getUserFromMail($_POST['recoveryMail'])->createPwdChangeRequest();
                    $messageContent = $this->lang['MSG_TO_RECOVER_PASSWORD'] . "$secretKey";
                    $this->sendMail($_POST['recoveryMail'], $_POST['recoveryMail'], $this->lang['CAS_PWD_RECOVERY'], $messageContent, null);
                    $_SESSION['msg'] = '<span class="success">' . $this->lang['S_RECOVERY_MAIL_SENT'] . '</span>';
                    $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
                }
            } catch (Exception $e) {
                $_SESSION['msg'] = '<span class="error">' . $this->lang['E_FAILED_TO_DELIVER_EMAIL'] . '</span>';
                $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
            }
        }
    }

    function changePassword()
    {


        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['pageTitle'] = "Changement de mot de passe";
        $this->vars['pageMessage'] = "";



        /*
         * This bit of code does so
         * 1. it checks if the url contains sth , after changepassword/.   That is the secret key sent to the user (not hashed)
         * 2. It asks the database for the user corresponding to the passwordRequest , whose id matches the sha1 of the secret key
         * 4. It checks whether the key is outdated or not (15 min delay)
         * 5. If this user exists, it's put in the session and the user is prompted to change password.
         * 6. If not, the user is redirected to resetpassword and asked wether to redo the process, or to check his key again.
         */

        $requestUri = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($requestUri[4])) {
            try {

                $_SESSION['user'] = User::getUserCorrespondingToSecretKey($requestUri[4]);


            } catch (Exception $e) {
                if (!($_SESSION['user']->getId() != 0)) {

                    unset($_SESSION['user']);
                    $_SESSION['msg'] = '<span class="error">' . $this->lang['E_KEY_REJECTED'] . '</span>';
                    $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';

                }
            }


        }

        /*
         * If something is in the post, and the 2 passowrds aren't empty and match, the user logged password is updated in the database.
         */

        if (!empty($_POST)) {

            $newPassword = $_POST['newPassword'];
            $newPasswordConfirmation = $_POST['newPasswordConfirmation'];

            //check if fields are empty
            if (empty($newPassword) or empty($newPasswordConfirmation)) {

                $_SESSION['msg'] = '<span class="error">' . $this->lang['E_REQUIRED_FIELD_EMPTY'] . '</span>';
                $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
                return;
            }
            //check if passwords match
            if ($newPassword != $newPasswordConfirmation) {
                $_SESSION['msg'] = '<span class="error">' . $this->lang['E_PASSWORDS_DONT_MATCH'] . '</span>';
                $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
                return;
            } else {
                $loggeduser = $this->getActiveUser();
                $result = $loggeduser->changePwd($newPassword);

                if (is_string($result)) {
                    $_SESSION['msg'] = '<span class="error">' . $result . '</span>';
                } else {

                    $_SESSION['msg'] = '<span class="success">' . $this->lang['S_PASSWORD_CHANGE_SUCCESSFUL'] . '</span>';

                    if (isset($requestUri[4])) {
                        $_SESSION['user'] = User::getUserCorrespondingToSecretKey($requestUri[4]);
                    }

                    $this->getActiveUser()->setPassword(sha1($newPassword));



                }

                $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
                $this->redirect('/login/','welcome');
            }


        }
    }

    /**
     * Method called by the logout hyperlink
     */
    function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }


    /**
     * Method that controls the page 'newuser.php'
     */
    function newuser()
    {

        $this->vars['pageTitle'] = $this->lang['CREATE_ACCOUNT'];
        $this->vars['pageMessage'] = "";
        //if a user is active he cannot re-register
        if ($this->getActiveUser()) {
            $this->redirect('login', 'welcome');
            exit;
        }

        //Get message and data from registration process
        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['persistence'] = isset($_SESSION['persistence']) ? $_SESSION['persistence'] : array('', '', '', '', '', '');
    }

    /**
     * Method called by the form of the page newuser.php
     */
    function register()
    {

        //Sanitize les champs
        $fname = htmlentities($_POST['firstname'], ENT_QUOTES, "UTF-8");
        $lname = htmlentities($_POST['lastname'], ENT_QUOTES, "UTF-8");
        $mail = htmlentities($_POST['mail'], ENT_QUOTES, "UTF-8");
        $phone = htmlentities($_POST['phone'], ENT_QUOTES, "UTF-8");
        $memberNumber = htmlentities($_POST['memberNumber'], ENT_QUOTES, "UTF-8");
        $pwd = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");


        //check user type
        $finalMemberNumber = 1;

        if (!empty($memberNumber)) {
            if ($memberNumber % 2 == 0)
                $finalMemberNumber = 2;
            else
                $finalMemberNumber = 3;

        }

        $error = false;

        if((!preg_match($this->NAME_PATTERN, $_POST['firstname'])) || (!preg_match($this->NAME_PATTERN, $_POST['lastname'])))
        {
            $error = true;
        }

        if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
        {
            $error = true;
        }else
        {
            $arr = explode("@", $mail);
            $dn = $arr[1];
            if(!checkdnsrr($dn))
            {
                $error = true;
            }
        }

        if(!preg_match($this->PHONE_PATTERN, $_POST['phone']))
        {
            $error = true;
        }

        //Check if data valid
        if (empty($fname) or empty($lname) or empty($mail) or empty($pwd) or empty($phone) or $error) {
            $_SESSION['msg'] = '<span class="error">' . $this->lang['E_REQUIRED_FIELD_EMPTY'] . '</span>';
            $_SESSION['persistence'] = array($fname, $lname, $mail, $phone, $finalMemberNumber, $pwd);
        } else {
            //Save new user into the db
            $user = new User(null, $fname, $lname, $mail, $phone, $finalMemberNumber, $pwd);
            $result = $user->save();
            if (is_string($result)) {
                $_SESSION['msg'] = '<span class="error">' . $result . '</span>';
                $_SESSION['persistence'] = array($fname, $lname, $mail, $phone, $memberNumber, $pwd);
            } else {
                $_SESSION['msg'] = '<span class="success">' . $this->lang['S_REGISTRATION_SUCCESSFUL'] . '</span>';
                unset($_SESSION['persistence']);
                $this->sendMail($mail, "$lname $fname", $this->lang['REGISTRATION_MAIL_TITLE'], $this->lang['REGISTRATION_MAIL_BODY'], null);

            }
        }


        $this->redirect('/login');
    }

    /**
     * Method that controls the page 'welcome.php'
     */
    function welcome()
    {
        $this->vars['pageTitle'] = "Profil";
        $this->vars['pageMessage'] = "";
        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['eventUsers'] = EventUsers::getEventUsersByUserID_obj($_SESSION['user']->getId());

        //The page cannot be displayed if no user connected
        if (!$this->getActiveUser()) {
            $this->redirect('/login');
            exit;
        }

        //$this->sendSms($this->getActiveUser()->getPhone(), 'Salut monsieur X, ici c est Club alpin suisse. ca va?');

        if (!empty($_POST['firstname'])) {
            $newFirstname = $_POST['firstname'];
            $newLastname = $_POST['lastname'];
            $newPhone = $_POST['phone'];
            $tempId = $_SESSION['user']->getId();


            $modifiedUser = User::empty_construct();
            $modifiedUser->setId($tempId);
            $modifiedUser->setFirstname($newFirstname);
            $modifiedUser->setLastname($newLastname);
            $modifiedUser->setPhone($newPhone);

            $_SESSION['user']->update($modifiedUser);
            $_SESSION['user'] = User::getUserFromId($tempId);
            $_SESSION['msg'] = '<span class="success">' . $this->lang['S_CHANGES_SUCCESSFUL'] . '</span>';

        }
        //Get message from connection process
        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';

        //Get the events for the specified user
        $this->vars['user_events'] = Event::fetch_events_for_user($_SESSION['user']->getId());
        if (sizeof($this->vars['user_events']) == 0) {
            $this->vars['user_events_msg'] = $this->lang['USER_EVENTS_NO_DATA'];
        } else {
            $this->vars['user_events_msg'] = 'rien';
        }


    }

}