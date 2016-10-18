<?php

class newsletterController extends Controller
{
    /***
     * echoes int values, representing messages
     * 0 : success
     * 1 : user already exists
     * 2 : error
     */
    function subscription()
    {
        $success = 0;
        $already_subscribed = 1;
        $error = 2;
        $valid = false;

        //0. Get the posted e-mail address
        $emailAddress = $_POST['newsletter_email'];
        $domain_arr = explode("@", $emailAddress);
        $domain = $domain_arr[1];

        //1. Check the e-mail address

        if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL) && checkdnsrr($domain)) {
            $valid = true;
        }

        if ($valid) {

            $rowID = Newsletter::subscribe("$emailAddress");

            //Check if the previousURL is from our website. If it's not the case, redirect the user to our landing page.
            if (!strpos($_SERVER['HTTP_REFERER'], SITE_NAME)) {
                header('Location: ' . ROOT_DIR);
                exit();
            } else {
                if ($rowID > 0) {
                    header('Content-type: text/plain');
                    echo $success;
                    exit();
                } else {
                    header('Content-type: text/plain');
                    echo $already_subscribed;
                    exit();
                }
            }
        } else {
            header('Content-type: text/plain');
            echo $error;
            exit();
        }
    }

    function newsletter()
    {
        //TODO : Display forbidden in case the user is not an admin.

        $this->vars['subject'] = "";
        $this->vars['message'] = "";

        $this->vars['display_error']['general'] = 'none';
        $this->vars['display_error']['subject'] = 'none';
        $this->vars['display_error']['message'] = 'none';

        //Get the session variables
        if (isset($_SESSION['subject'])) {
            $this->vars['subject'] = $_SESSION['subject'];
            unset($_SESSION['subject']);
        }

        if (isset($_SESSION['message'])) {
            $this->vars['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        if (isset($_SESSION['error_subject'])) {
            if ($_SESSION['error_subject'] == true) {
                $this->vars['display_error']['subject'] = 'block';
                $this->vars['display_error']['general'] = 'block';
                unset($_SESSION['error_subject']);
            }
        }

        if (isset($_SESSION['error_message'])) {
            if ($_SESSION['error_message'] == true) {
                $this->vars['display_error']['message'] = 'block';
                $this->vars['display_error']['general'] = 'block';
                unset($_SESSION['error_message']);
            }
        }
    }

    function sendnewsletter()
    {
        //0. Check : the previous page should be newsletter/newsletter

        $error_subject = false;
        $error_message = false;

        $subject = $_POST['subject'];
        $message = $_POST['message'];

        if (!isset($subject) || empty($subject) || (strlen($subject) > 120)) {
            $error_subject = true;
        }

        if (!isset($message) || empty($message) || (strlen($message) > 3000)) {
            $error_message = true;
        }

        $_SESSION['error_subject'] = $error_subject;
        $_SESSION['error_message'] = $error_message;

        if ($error_subject || $error_message) {
            $_SESSION['subject'] = $subject;
            $_SESSION['message'] = $message;

            //Redirect to the previous page.
            header('Location: ' . ROOT_DIR . '/' . SITE_NAME . '/newsletter/newsletter');
            exit();
        }

        //1. Get the e-mail addresses.
        $emailAddresses = Newsletter::getSubscribers();

        //2. Send the e-mails

        $this->vars['sending_success'] = 0;
        $this->vars['sending_errors'] = array();


        foreach ($emailAddresses as $email) {

            $hashed_email = md5(SALT_NEWSLETTER . $email);
            $incfile = ROOT_DIR . "views/mail.inc";
            error_log($incfile);
            $template_message = $this::requireToVar($incfile, $subject, $message, $hashed_email);

            try {
                $this::sendMail($email, "CAS", $subject, $template_message, null);
                $this->vars['sending_success']++;
            } catch (Exception $e) {

                $exception = array();
                array_push($exception, $email);
                array_push($exception, $e);
                array_push($this->vars['sending_errors'], $exception);
            }
        }
    }

    function unsubscribe()
    {
        $hashed_email = $GLOBALS['value'];
        $found = false;

        $emailAddresses = Newsletter::getSubscribers();
        foreach($emailAddresses as $e)
        {
            if($hashed_email == md5(SALT_NEWSLETTER . $e)){
                $found = true;
                //Delete the entry from the database
                Newsletter::unsubscribe($e);
                break;
            }
        }

        /*
        if(!$found)
        {
            //TODO : À changer par la métode redirect après le déploiement.
            header('Location: http://localhost/cas/error/http404');
            exit();
        }
        */
    }
}