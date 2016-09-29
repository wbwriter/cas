<?php
class loginController extends Controller{
    /**
     * Method called by the form of the page login.php
     */

    function connection(){
        //Get data posted by the form
        $mail = $_POST['mail'];
        $pwd = $_POST['password'];

        //Check if data valid
        if(empty($mail) or empty($pwd)){
            $_SESSION['msg'] = '<span class="error">A required field is empty!</span>';
            $this->redirect( 'login');
        }
        else{
            //Load user from DB if exists
            $result = User::connect($mail, $pwd);

            //Put user in session if exists or return error msg
            if(!$result){
                $_SESSION['msg'] = '<span class="error">Username or password incorrect!</span>';
                $this->redirect( 'login');
            }
            else{
                $_SESSION['msg'] = '';
                $_SESSION['user'] = $result;
                $this->redirect('welcome');
            }
        }

    }




    function  sendMail($destinationAddress,$destinationName,$subject,$message){
        require_once 'dependencies/mailer/class.phpmailer.php';
        require_once 'dependencies/mailer/class.smtp.php';


        $mail = new PHPMailer(true);

        //Send mail using gmail

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = "tls"; // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 587; // set the SMTP port for the GMAIL server
        $mail->Username = "casphphes@gmail.com"; // GMAIL username
        $mail->Password = "qwertzuio"; // GMAIL password


        //Typical mail data
        $mail->AddAddress($destinationAddress, $destinationName);
        $mail->SetFrom('casphphes@gmail.com');
        $mail->Subject = $subject;
        $mail->Body = $message;

        try{
            $mail->Send();


        } catch(Exception $e){
            //Something went bad


        }
    }


    /**
     * Method that controls the page 'login.php'
     */
    function login(){
        //if a user is active he cannot re-login
        if($this->getActiveUser()){
            $this->redirect('login', 'welcome');
            exit;
        }

        /*dsda*/
        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['pageTitle'] = "Connection";
        $this->vars['pageMessage'] = "Connectez vous pour vous inscrire aux évenements.";

    }

    /**
     *  Method that controls the page 'resetpassword.php'
     */

    function resetPassword(){

        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['pageTitle'] = "Récupération de mot de passe";
        $this->vars['pageMessage'] = "";



        if(!empty($_POST)){

            try{
                $this->sendMail($_POST['recoveryMail'],$_POST['recoveryMail'],'CAS password recovery','Ce message est la pour recuperer votre mdp');
                $_SESSION['msg'] = '<span class="success">A recuperation email was sent to your address</span>';
                $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
            }catch(Exception $e){
                $_SESSION['msg'] = '<span class="error">Failed to deliver</span>';
                $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
            }

        }



    }

    function changePassword(){

        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['pageTitle'] = "Changement de mot de passe";
        $this->vars['pageMessage'] = "";

        if(!empty($_POST)){

            $newPassword = $_POST['newPassword'];
            $newPasswordConfirmation = $_POST['newPasswordConfirmation'];

            //check if fields are empty
            if(empty($newPassword) or empty($newPasswordConfirmation)) {

                $_SESSION['msg'] = '<span class="error">Veuillez remplir les champs</span>';
                $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
                return;
        }
            //check if passwords match
            if($newPassword != $newPasswordConfirmation){
                $_SESSION['msg'] = '<span class="error">Passwords dont match</span>';
                $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
                return;
            }
            else{
                $loggeduser = $this->getActiveUser();
                $result = $loggeduser->changePwd($newPassword);
                if(is_string($result)){
                    $_SESSION['msg'] = '<span class="error">'.$result.'</span>';
                }
                else{
                    $_SESSION['msg'] = '<span class="success">Password change successful!</span>';
                    $this->getActiveUser()->setPassword(sha1($newPassword));

                }

                $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';

               $this->redirect( 'welcome');
            }


        }
    }

    /**
     * Method called by the logout hyperlink
     */
    function logout(){
        session_destroy();
        $this->redirect('login');
    }


    /**
     * Method that controls the page 'newuser.php'
     */
    function newuser(){

        $this->vars['pageTitle'] = "Créez votre compte";
        $this->vars['pageMessage'] = "";
        //if a user is active he cannot re-register
        if($this->getActiveUser()){
            $this->redirect('login', 'welcome');
            exit;
        }

        //Get message and data from registration process
        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['persistence'] = isset($_SESSION['persistence']) ? $_SESSION['persistence'] : array('','','','','','');
    }

    /**
     * Method called by the form of the page newuser.php
     */
    function register(){


        //Get data posted by the form
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $mail = $_POST['mail'];
        $phone = $_POST['phone'];
        $memberNumber = $_POST['memberNumber'];
        $pwd = $_POST['password'];


        //check user type
        $finalMemberNumber = 1;

        if(!empty($memberNumber)){
            if($memberNumber % 2 == 0)
                $finalMemberNumber = 2;
            else
                $finalMemberNumber = 3;

        }


        //Check if data valid
        if(empty($fname) or empty($lname) or empty($mail) or empty($pwd) or empty($phone)){
            $_SESSION['msg'] = '<span class="error">A required field is empty!</span>';
            $_SESSION['persistence'] = array($fname, $lname, $mail, $phone, $finalMemberNumber, $pwd);
        }
        else{
            //Save new user into the db
            $user = new User(null, $fname, $lname, $mail,$phone,$finalMemberNumber, $pwd);
            $result = $user->save();
            if(is_string($result)){
                $_SESSION['msg'] = '<span class="error">'.$result.'</span>';
                $_SESSION['persistence'] = array($fname, $lname,$mail,$phone,$memberNumber, $pwd);
            }
            else{
                $_SESSION['msg'] = '<span class="success">Registration successful!</span>';
                unset($_SESSION['persistence']);
                $this->sendMail($mail,"$lname $fname",'Bienvenue sur le site du CAS','Ceci est un mail automatique pour vous informer de votre inscription au site.');

            }
        }



        $this->redirect('login', 'newuser');
    }

    /**
     * Method that controls the page 'welcome.php'
     */
    function welcome(){
        //The page cannot be displayed if no user connected
        if(!$this->getActiveUser()){
            $this->redirect('login');
            exit;
        }

        //Get message from connection process
        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';

    }

}