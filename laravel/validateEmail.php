$email = $user->email;
// check if email is a valid email address
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email = null;
}
