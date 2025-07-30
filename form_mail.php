<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>POST = ";
    print_r($_POST);
    echo "</pre>";

    $email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ad3426057@gmail.com';
        $mail->Password   = 'qihw aeaz cmxm icgh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('ad3426057@gmail.com', 'Aliou Diop');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Test envoi unique';
        $mail->Body    = nl2br($message);

        if (!empty($_FILES['attachment']['tmp_name'])) {
            $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
        }

        $mail->send();
        echo "<h3 style='color:green'>✅ Email envoyé</h3>";
    } catch (Exception $e) {
        echo "<h3 style='color:red'>❌ Erreur PHPMailer :</h3> " . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire d'envoie de mail</title>
     <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Envoyer un email</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="email" name="email" placeholder="Email destinataire" required><br><br>
        <textarea name="message" placeholder="Message" required></textarea><br><br>
        <input type="file" name="attachment"><br><br>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
