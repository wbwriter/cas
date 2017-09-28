<?php

/**
 * Created by PhpStorm.
 * User: andreasfi
 * Date: 27.09.16
 * Time: 14:46
 */
class contactController extends Controller
{
    function contact()
    {

        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';

        $this->vars['pageTitle'] = $this->lang['CONTACT_US'];
        $this->vars['pageMessage'] = $this->lang['LEAVE_VIDEO_MSG'];;

            if(!empty($_POST)){

                //0. Get the posted data from the form
                if( isset($_POST['name']) && isset($_POST['emailFrom']) && isset($_POST['subject']) && isset($_POST['message']) ){
                    $name = $_POST['name'];
                    $emailFrom = $_POST['emailFrom'];
                    $subject = $_POST['subject'];
                    $message = $_POST['message'];
                    $finalMessage = "From : $name\nEmail : $emailFrom\n\nMessage : $message";

                    try {
                        $this->sendMail("casphphes@gmail.com", "Contact message on cas website", $subject, $finalMessage, null);

                        $_SESSION['msg'] = '<span class="success">'. $this->lang['S_CONTACT_MAIL_SENT'].'</span>';
                        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
                    }catch(Exception $e){

                        $_SESSION['msg'] = '<span class="error">' . $this->lang['E_FAILED_TO_DELIVER_EMAIL'].'</span>';
                        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
                    }

                }

            }



    }



    function sendVideo()
    {
        //0. Create a tmp folder if not already existing

        if(!file_exists("tmp"))
        {
            if (!mkdir("tmp", 0777, true)) {
                die('Echec lors de la création des répertoires...');
            }
        }

        $date = new DateTime();
        $filename = "video_".$date->getTimestamp().".webm";

        $file = fopen("tmp/$filename", "w");
        $blob_file = file_get_contents('php://input');
        fwrite($file, $blob_file);
        fclose($file);

        //Check the size of the video.

        //Send the video by email
        $this->sendMail("casphphes@gmail.com", "CAS", "New video", "Hello, you have a new video ! ", "tmp/$filename");

        //Delete the video

        $this->deleteFile("tmp/$filename");

    }

    private function deleteFile($filename)
    {
        if(file_exists($filename))
            unlink($filename);
    }
}