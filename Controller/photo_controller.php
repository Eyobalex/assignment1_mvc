<?php

require_once ("../included_files/initialize.php");
require_once ("../included_files/Session.php");
class PhotoController{

   public static function index()
   {
      $photos = Photograph::find_all();
      return $photos;
   }

   public static function find($id){
       return Photograph::find_by_id($id);
   }

   public static function upload($file,$name, $desc){
       $session = new Session();
       $photo = new Photograph();
       $photo->name = $name;
       $photo->description = $desc;
       $photo->attach_files($file);
       if ($photo->save()){
           $session->message("you have successfully uploaded an image");
           redirect_to("index.php");
       }
       else{
           $session->message(join("<br />", $photo->errors));
           redirect_to("index.php");
        }

   }

   public static function delete($id){
       $session = new Session();
       $photo = Photograph::find_by_id($id);
       if ($photo->destroy()){
           $session->message("you have successfully deleted an image");
           redirect_to("index.php");
       }
       else{
           $session->message("sth went wrong");
           redirect_to("index.php");
       }
   }


}