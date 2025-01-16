<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" type="text/css"  href="../assets/style/style.css"> <!-- link to your CSS file -->
</head>

<body>
    <!-- Header of page include since includes header.php -->
     <?php include '../includes/header.php';?>
     
    <!-- Log in form -->
     <form action="login.php" method="post" class="log_in">
         <h2>Login</h2>
         <div class="form-groupe">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
         </div>
         <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
         </div>

         <button type="submit">Login</button>
        <!-- add a link to login page -->
         <p><a href="register.php"> haven't an account? register here</a></p>
         <br><br>
         

          <!-- display loading spinner if user is currently logged in -->
            <?php if (isset($_SESSION['logged_in'])) {?>
                <div class="lds-spinner"></div>
            <?php }?>
     </form>

     
    <!-- Footer of page include since includes footer.php -->
     <?php include '../includes/footer.php';?>


     <script src="../assets/js/script.js"></script> <!-- link to your JavaScript file -->
</html>
</body>
</html>