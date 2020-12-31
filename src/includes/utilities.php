<?php
namespace UTILITIES;
//require_once "resources.php";

function isValidID($id){
    $reg_expr = "/^\d+$/";
    if(preg_match($reg_expr,$id)!=0){
        return true;
    }else{
        error_log("Invalid ID! Must be a number");
        return false;
    }
}

?>