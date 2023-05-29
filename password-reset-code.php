<?php

include("config/db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
function password_reset($get_uname, $get_email, $token)
{
    $mail = new PHPMailer();
    $mail->isSMTP();

    $mail->SMTPAuth = true;
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->Username = '469e7e8943daba';
    $mail->Password = '4aa6d9ea9ae721';

    $mail->SMTPSecure = 'tls';
    $mail->Port = 2525;

    $mail->setFrom('home430000@gmail.com', $get_uname);
    $mail->addAddress($get_email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset';

    $email_template = "
    <h2>Hello, $get_uname</h2>
    <h3>You are receiving this email because we received a password reset request for your account.</h3><br><br>
    <a href='http://localhost/php/basic_project/password-change.php?token=$token&email=$get_email'>Click Here</a>
    ";

    $mail->Body = $email_template;
    $mail->send();
}

if (isset($_POST['reset_link'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand());

    $check_email = mysqli_query($con, "SELECT * FROM register WHERE `email`='$email' LIMIT 1");

    if (mysqli_num_rows($check_email) > 0) {

        $row = mysqli_fetch_assoc($check_email);
        $get_uname = $row['username'];
        $get_email = $row['email'];

        $update_token = mysqli_query($con, "UPDATE register SET `token`='$token' WHERE `email`='$get_email' LIMIT 1");

        if ($update_token) {
            password_reset($get_uname, $get_email, $token);
            echo 'we sent password reset link';
            header('refresh:5;url=password-reset.php');
        } else {
            echo 'Somthing Went To Wrong';
            header('refresh:5;url=password-reset.php');
        }
    } else {
        echo 'No Email Found';
        header('refresh:5;url=password-reset.php');
    }
}

if (isset($_POST['update_password'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['npassword']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['cpassword']);
    $token = mysqli_real_escape_string($con, $_POST['token']);

    if (!empty($token)) {
        if ((!empty($email)) && (!empty($new_password)) && (!empty($confirm_password))) {
            $check_token = mysqli_query($con, "SELECT token FROM register WHERE `token`='$token' LIMIT 1");
            if (mysqli_num_rows($check_token) > 0) {
                if ($new_password == $confirm_password) {
                    $update_password = mysqli_query($con, "UPDATE register SET `password`='$new_password' WHERE `token`='$token' LIMIT 1");
                    if ($update_password) {
                        echo 'Password Updated';
                        header('refresh:5;url=login.php');
                    } else {
                        echo 'Somthing Went To Wrong';
                        header('refresh:5;url=password-change.php?token=$token&email=$email');
                    }
                } else {
                    echo 'Password Not Matched';
                    header('refresh:5;url=password-change.php?token=$token&email=$email');
                }
            } else {
                echo 'Invalid Token';
                header('refresh:5;url=password-change.php?token=$token&email=$email');
            }
        } else {
            echo 'All Field Are Mandatory';
            header('refresh:5;url=password-change.php?token=$token&email=$email');
        }
    } else {
        echo 'No Token Found';
        header('refresh:5;url=password-change.php');
    }
}
