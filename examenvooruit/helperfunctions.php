<?php

class HelperFunctions{

  public function has_provided_input_for_required_fields($fields){
    // check if parameter contains an array
    if(is_array($fields)){

      // variabele met default boolean false
      $error = false;

      // loopt door alle naam attribute in input fields
      foreach ($fields as $fieldname) {
          // checkt of field geset is als niet dan is error true
          if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
            // echo "Field $fieldname has not been set or empty";
            $error = true;
          }
      }

      // als we geen error hebben gehad dan krijg je een true terug
      if(!$error){
        return true;
      }

      // returned false wanneer een input field geen value heeft
      return false;
    }else{
      echo "No array has been supplied as arg";
    }

  }


}

?>
