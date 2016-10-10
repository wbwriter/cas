<?php
/**
 * Parent class for every controllers classes
 * @author S. Martin
 * @link http://www.hevs.ch	
 */
class Controller {
    protected $vars = array();
    protected $controller;
    protected $method;
   
    /**
     * Constructor
     * @param string $controller
     * @param string $method
     */
        function __construct($controller, $method) {

            $this->vars['pageTitle'] = "CAS";
            $this->vars['pageMessage'] = "Club Alpin Suisse";
            $this->controller = $controller;
            $this->method = $method;

            if(isSet($_GET['lang']))
            {
                $clang = $_GET['lang'];

    // register the session and set the cookie
                $_SESSION['lang'] = $clang;
                setcookie('lang', $clang, time() + (3600 * 24 * 30));
            }
            else if(isSet($_SESSION['lang']))
            {
                $clang = $_SESSION['lang'];
            }
            else if(isSet($_COOKIE['lang']))
            {
                $clang = $_COOKIE['lang'];
            }
            else
            {
                $clang = 'en';
            }
            $lang = "";
            include ("lang/lang.$clang.php");

            $this->lang = $lang;


        }
    
    /**
     * Display view associated to a controller method
     */
    function display(){

    	$view = "{$this->controller}/{$this->method}.php";
        if(file_exists('views/'."{$this->method}.php")){
            include 'views/'."{$this->method}.php";
        } elseif(file_exists('views/'.$view)){
            include 'views/'.$view;
        }

    }
    
    /**
     * URL redirection
     * @param string $controller
     * @param string $method    
     */
    function redirect($controller, $method) {    	
    	$url = "Location: " . URL_DIR. $controller . '/' .$method;    	
    	header($url);
    }
    
    /**
     * Get active (logged-in) user
     * @return User
     */
    function getActiveUser(){
    	if(isset($_SESSION['user']))
    		return $_SESSION['user'];
    	else
    		return false;
    }

    function checkUser($userLevel, $redirectPage){
        // Verify the user level and redirects if not
        $user = $this->getActiveUser();
        if(($user && $user->getMemberType() >= $userLevel) || $userLevel == 0){

        } else {
            $this->redirect($redirectPage);
            exit;
        }
    }

    function checkParam($param, $redirectPage){
        // Verify if params are valid and redirects if not
        if(!isset($param) || $param == ""){
            $this->redirect($redirectPage);
            exit;
        }
    }


    function sendMail($destinationAddress, $destinationName, $subject, $message)
    {
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

        try {
            $mail->Send();


        } catch (Exception $e) {
            //Something went bad


        }
    }



    /*
    * 1. Sends the destinationNumber a message
    * 2. Mails comes from Pierre Baran, because that's how it's registered in the api key
    * 3. Only 100 sms
     * 4. All function is commented, until needed for presentation
     * 5 Account info username : casphphes
     * 6. mobile number +41793943353
     * 7. password : QWERTZUIO.123
     * 8. mail : casphphes@gmail.com
    */
    function sendSms($destinationNumber, $message)
    {
        /*
        $sender = "CAS";
        $mobile_number = "$destinationNumber";
        $msg = "$message";
        $apiKey = "PLTtt3bUazxZax5mG4pAXGKR128KhRAl";

            $curl = curl_init("https://api.swisscom.com/v1/messaging/sms/outbound/tel%3A%2B41" . $sender . "/requests");
            $header = array("client_id: " . $apiKey . "", "Accept: application/json; charset=utf-8", "Content-Type: application/json; charset=utf-8");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            $curl_post_data = array('outboundSMSMessageRequest' => array('address' => array(0 => 'tel:+41' . $mobile_number . '',), 'senderAddress' => 'tel:+41' . $sender . '', 'outboundSMSTextMessage' => array('message' => '' . $msg . '',),),);

            // Encode the post data in JSON.
            $json_post_data = json_encode($curl_post_data);

            // Add the encoded data to the curl request.
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json_post_data);

            // Makes curl_exec() return a string.
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // We are sending a POST request.
            curl_setopt($curl, CURLOPT_POST, true);

            // Similar to cmd-line curl's -k option during development
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

            // Ignore host verification for development
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);

            // Must be present to get request headers
            curl_setopt($curl, CURLINFO_HEADER_OUT, FALSE);

            // Make the actual call to the Swisscom server to send the SMS token
            $curl_response = curl_exec($curl);

            // Get the response back from the call.
            $curl_info = curl_getinfo($curl);

            // Check for any errors and show error on screen if there is an issue
            $http_response_code = $curl_info['http_code'];

            if (curl_error($curl) || $http_response_code != 200) {
                $curl_response = print_r($curl_response, true);
                $alert_error = 'Error ' . $http_response_code . ' ' . curl_error($curl) . ' API server response: ' . $curl_response;
                echo "<br>" . $alert_error;
            } else {
               $alert_success = "We sent you a verification code to: +41" . htmlspecialchars($mobile_number) . '.';
                echo "<br>" . $alert_success;
            }
            curl_close($curl);
            */
    }
}
