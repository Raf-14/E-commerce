<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>page error</title>
    <link rel="icon" type="image/png" href="./assets/images/logo.jpeg">
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        h1 {
            font-size: 4em;
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: #007BFF;
            font-size: 1.2em;
        }
        a:hover {
            color: #555;
        }
        p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- page to display when error occured when post panet in db -->
     <h1>Error <?php echo $errorCode;?></h1>
     <p>Nous sommes désolés, mais la page demandée n'existe pas.</p>
     <p>Veuillez vérifier l'URL ou contacter le support technique si vous rencontrez ce problème plus tard.</p>
     <a href="index.php">Retour à l'accueil</a>
</body>
</html>