<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }
        label, input, textarea {
            display: block;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        p {
            color: red;
            margin-top: 10px;
        }
        /* Responsive design for smaller screens */
        @media screen and (max-width: 600px) {
            form {
                max-width: 100%;
            }
        }
        /* Styling for success message */
        .success {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
        /* Styling for error message */
       .error {
        color: red;
            font-weight: bold;
            margin-top: 10px;
        }
        
    </style>
</head>
<body>
    
    <!-- Start of contact form -->
     <form action="./send_mail.php" method="post">
        <h2>Contactez-nous</h2>
        <p>Veuillez remplir tous les champs obligatoires.</p>
        <div class="display-message">
            <!-- Display success or error messages here -->
        </div>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" required></textarea><br>
        <input type="submit" value="Submit">
    </form>
    <!-- End of contact form -->
      <script>
        // Get the form element
        const form = document.querySelector('form');
        
        // Add an event listener for form submission
        form.addEventListener('submit', (event) => {
            // Prevent the form from submitting
            event.preventDefault();
            
            // Reset the success and error messages
            document.querySelector('.display-message').innerHTML = '';
            document.querySelector('.success').style.display = 'none';
            document.querySelector('.error').style.display = 'none';
            
            // Get the form data
            const formData = new FormData(form);
            
            // Send the form data to the server
            fetch('./send_mail.php', {
                method: 'POST',
                body: formData
            })
           .then(response => response.json())
           .then(data => {
             // Check if the request was successful
             if (data.success) {
                 // Display success message
                 document.querySelector('.display-message').innerHTML = data.message;
                 document.querySelector('.success').style.display = 'block';
             } else {
                 // Display error message
                 document.querySelector('.display-message').innerHTML = data.message;
                 document.querySelector('.error').style.display = 'block';
             }
           })
           .catch(error => {
                 // Display error message
                 document.querySelector('.display-message').innerHTML = 'Erreur lors de la soumission du formulaire.';
                 document.querySelector('.error').style.display = 'block';
             });
             // Clear the form inputs
             form.reset();
        });
        
         // Validate form inputs on real-time
         const inputs = form.querySelectorAll('input, textarea');
         inputs.forEach(input => {
             input.addEventListener('input', validateInput);
         });
         function validateInput(event) {
             const input = event.target;
             const isValid = input.checkValidity();
             input.classList.toggle('valid', isValid);
             input.classList.toggle('invalid',!isValid);
         }
         // Disable the submit button if any input is invalid
         const submitBtn = document.querySelector('form button');
         submitBtn.disabled = inputs.some(input =>!input.checkValidity());
         // Show error message if the form is submitted without any valid inputs
         form.addEventListener('submit', (event) => {
             if (inputs.some(input =>!input.checkValidity())) {
                 event.preventDefault();
                 document.querySelector('.display-message').innerHTML = 'Veuillez remplir tous les champs obligatoires correctement.';
                 document.querySelector('.error').style.display = 'block';
             }
         });
         // Close the success and error messages after 3 seconds
         setTimeout(() => {
             document.querySelector('.display-message').innerHTML = '';
             document.querySelector('.success').style.display = 'none';
             document.querySelector('.error').style.display = 'none';
         }, 3000);
         
      </script>


</body>
</html>