<?php
namespace UTILITIES;
//require_once "resources.php";

function isValidCarrello($cart_id){
    $reg_expr = "/^\d+$/";
    if(preg_match($reg_expr,$cart_id)!=0){
        return true;
    }else{
        error_log("Invalid cartID! Must be a number");
        return false;
    }
}

function isValidShipping($shipping_id){
    $reg_expr = "/^\d+$/";
    if(preg_match($reg_expr,$shipping_id)!=0){
        return true;
    }else{
        error_log("Invalid shippingID! Must be a number");
        return false;
    }
}

?>