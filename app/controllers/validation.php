<?php 
require_once 'controller.php';
class Validation extends Controller {

  private $data;
  private $errors = [];
  private static $fields = ['name', 'email','password','retype_password'];

  public function __construct($post_data){
    $this->data = $post_data;
    // echo "hi";
  }

  public function validateForm(){

    foreach(self::$fields as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }

    $this->validateUsername();
    $this->validateEmail();
    $this->validatePassword();
    return $this->errors;

  }

  private function validateUsername(){

    $val = trim($this->data['name']);

    if(empty($val)){
      $this->addError('errorname', 'username is empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{8,12}$/', $val)){
        $this->addError('errorname','Error:username must be max 8 and min 12  chars ');
      }
    }

  }

  private function validateEmail(){

    $val = trim($this->data['email']);

    if(empty($val)){
      $this->addError('erroremail', 'email is empty');
    } else {
      if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
        $this->addError('erroremail', 'Error:email must be  email address');
      }
    }

  }
  private function validatePassword(){

    $val = trim($this->data['password']);
    $val2 = trim($this->data['retype_password']);

    if(empty($val) && empty($val2)){
      $this->addError('errorpassword', 'password is empty');
    } else {
      if($val!==$val2){
        $this->addError('errorpassword', 'Error:passwords must be the same');
      }
    }

  }

  private function addError($key, $val){
    $this->errors[$key] = $val;
  }

}

?>