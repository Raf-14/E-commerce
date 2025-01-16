<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    <link rel="stylesheet" type="text/css"  href="../assets/style/style.css"> <!-- link to your CSS file -->
</head>
<body>
    <!-- header include since includes header.php -->
     <?php include '../includes/header.php';?>

     <!-- success or error message divs -->
       <div id="success_message" class="success"></div>
       <div id="error_message" class="error"></div>

       <!-- form container -->
       <div class="form-container">
        <h2>Create an Account</h2>
        
        <!-- form -->
           <!-- form starts here -->
            <form action="process_account.php" method="post">
                <!-- all inputs for creating an account -->
            
                <div class="form-groupe">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-groupe">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-groupe">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-groupe">
                    <label for="password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-groupe">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                
                <div class="form-groupe">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                
                <div class="form-groupe">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                
                <div class="form-groupe">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-groupe">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to the terms and conditions</label>
                </div>
                
            
                
                <button type="submit">Create Account</button>
                <!-- add a link to login page -->
                 <p><a href="login.php">Already have an account? Login here</a></p>             
           </form>
        
       </div>
   
    <!-- footer include since includes footer.php -->
     <?php include '../includes/footer.php';?>

     <script src="../assets/script/app.js"></script>

</body>
</html>