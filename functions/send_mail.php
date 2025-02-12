<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require "../functions/functions.php";
require '../config/database.php';

$bdd = bdd();


// Vérification des données du formulaire

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die('Tous les champs sont obligatoires.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("L'adresse email n'est pas valide.");
    }
    //Appelle de la fonction save-email pour sauvegarder l'email envoyé
    save_email($name, $email, $phone, $subject, $message);

    // Configuration du mailer PHPMailer
    
    $mail = new PHPMailer(true);

    try {
        // Configurer le serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Remplacez par votre hôte SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'lawalrafiou2@gmail.com'; // Votre adresse email
        $mail->Password = 'dtxcpmnmuwaqezyu'; // Mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Sécurisation
        $mail->Port = 587; // Port SMTP
        $mail->CharSet = 'UTF-8';

        // Paramètres de l'email
        $mail->setFrom($email, $name);
        $mail->addAddress('lawalrafiou2@gmail.com'); // Adresse du destinataire
        $mail->Subject = $subject;
        $mail->Body = "Nom : $name\nEmail : $email\n\nMessage :\n$message";

        // Envoyer l'email
        $mail->send();
        echo "Message envoyé avec succès.";
        // header('Location: contact.php?success=1');
        exit();

    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
