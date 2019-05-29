<?php
/**
 * Created by Eyob.
 * Date: 8/23/2018
 * Time: 10:59 AM
 */

class Session{

    public $message;

    function __construct(){
        session_start();
        $this->check_message();

    }
    private function check_message(){
        if (isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        }else{
            $this->message = "";
        }
    }

    public function message($msg=""){
        if (!empty($msg)){
            $_SESSION['message'] = $msg;
        }else{
            return $this->message;
        }
    }



}
$session = new Session();
$message = $session->message();