function check_email($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if(preg_match("/^(\w{3,})@(\w{3,}).(\d{2,})*$/", $email)) {
            return true;
        }
    }
    return false;
}

function check_username($username) {
    if(preg_match(), $username) {

    }
}

function check_password($password) {
    if(preg_match(), $password) {

    }
}
