<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APP_PATH . "/vendor/autoload.php";

function sendEmail(string $title, string $body, string $emailTo): bool
{
    $mail = new PHPMailer();
    $is_send = false;
    try {
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->CharSet    = 'UTF-8';
        $mail->Host       = 'smtp.gmail.com';
        $mail->Username   = '587noreply@gmail.com';
        $mail->Password   = 'sxgf oocu crxw gggs';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->Subject    = $title;
        $mail->Body       = $body;
        $mail->setFrom('587noreply@gmail.com');
        $mail->addAddress($emailTo);
        $mail->isHTML(true);
        $mail->send();
        $mail->SMTPDebug = 2;
        $is_send = true;
    } catch (Exception $e) {
        die($e->getMessage());
    }
    return $is_send;
}

function sendVerificationEmail(string $email, int $user_id, string $activationCode): bool
{
    $activation_link = APP_URL . "reset/new-password?uid=$user_id&ver=$activationCode";
    $body = "
    <h1>Hello!</h1><br>
    <p style='font-size: 18px;'>To change your password, pleace click <a href='$activation_link'>here</a>.</p><br>
    ";
    $title = 'Note System Password Change';
    return sendEmail($title, $body, $email);
}