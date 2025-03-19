<?php
    $con=mysqli_connect("localhost","root","","student")or die("not connect");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration Form</title>


  <script>
    /*document.getElementById('registrationForm').addEventListener('submit', function(event) {
      event.preventDefault();
      
      // Basic form validation
      const firstName = document.getElementById('firstName').value.trim();
      const lastName = document.getElementById('lastName').value.trim();
      const email = document.getElementById('email').value.trim();
      const standard = document.getElementById('standard').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirmPassword').value;
      const gender = document.querySelector('input[name="gender"]:checked');
      
      // Clear previous error messages
      document.querySelectorAll('.error').forEach(el => el.remove());
      
      // Check if required fields are filled
      let isValid = true;
      
      if (!firstName) {
        showError('firstName', 'First name is required');
        isValid = false;
      }
      
      if (!lastName) {
        showError('lastName', 'Last name is required');
        isValid = false;
      }
      
      if (!standard) {
        showError('standard', 'Please select a standard/grade');
        isValid = false;
      }
      
      if (!email) {
        showError('email', 'Email address is required');
        isValid = false;
      } else if (!isValidEmail(email)) {
        showError('email', 'Please enter a valid email address');
        isValid = false;
      }
      
      if (!password) {
        showError('password', 'Password is required');
        isValid = false;
      } else if (password.length < 8) {
        showError('password', 'Password must be at least 8 characters long');
        isValid = false;
      }
      
      if (password !== confirmPassword) {
        showError('confirmPassword', 'Passwords do not match');
        isValid = false;
      }
      
      if (!gender) {
        showError('male', 'Please select a gender option');
        isValid = false;
      }
      
      // If everything is valid, submit the form
      if (isValid) {
        alert('Registration successful! Redirecting to login page...');
        // In a real application, you would submit the form data to the server
        // this.submit();
      }
    });
    
    function showError(fieldId, message) {
      const field = document.getElementById(fieldId);
      const errorElement = document.createElement('div');
      errorElement.classList.add('error');
      errorElement.textContent = message;
      field.parentNode.appendChild(errorElement);
    }
    
    function isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }*/
  </script>
  <style>
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    
    .container {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 550px;
      padding: 35px;
    }
    
    h1 {
      text-align: center;
      color: #1e3a8a;
      margin-bottom: 30px;
      font-weight: 600;
    }
    
    .form-group {
      margin-bottom: 22px;
    }
    
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #374151;
      font-size: 15px;
    }
    
    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      box-sizing: border-box;
      font-size: 16px;
      transition: all 0.2s ease;
    }
    
    input:focus, select:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    
    .name-fields {
      display: flex;
      gap: 12px;
    }
    
    .name-fields .form-group {
      flex: 1;
    }
    
    .radio-group {
      display: flex;
      gap: 25px;
      margin-top: 10px;
    }
    
    .radio-option {
      display: flex;
      align-items: center;
    }
    
    .radio-option input {
      margin-right: 8px;
      width: 18px;
      height: 18px;
      accent-color: #3b82f6;
    }
    
    button {
      background-color: #1e3a8a;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 14px 20px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      width: 100%;
      margin-top: 15px;
      transition: background-color 0.2s, transform 0.1s;
    }
    
    button:hover {
      background-color: #1e40af;
    }
    
    button:active {
      transform: scale(0.98);
    }
    
    .login-link {
      text-align: center;
      margin-top: 22px;
      font-size: 15px;
      color: #6b7280;
    }
    
    .login-link a {
      color: #3b82f6;
      text-decoration: none;
      font-weight: 600;
    }
    
    .login-link a:hover {
      text-decoration: underline;
    }
    
    .error {
      color: #ef4444;
      font-size: 14px;
      margin-top: 6px;
      font-weight: 500;
    }
    
    .required-field::after {
      content: " *";
      color: #ef4444;
    }
    
    .form-header {
      border-bottom: 1px solid #e5e7eb;
      padding-bottom: 15px;
      margin-bottom: 25px;
      color: #1e3a8a;
    }
    
    .password-rules {
      font-size: 13px;
      color: #6b7280;
      margin-top: 6px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-header">
      <h1>Student Registration</h1>
    </div>
    
    <form id="registrationForm" action="student_registration.php" method="POST">
      <!-- Name Fields -->
      <div class="name-fields">
        <div class="form-group">
          <label for="firstName" class="required-field">First Name</label>
          <input type="text" id="firstName" name="firstName" required placeholder="Enter first name">
        </div>
        
        <div class="form-group">
          <label for="middleName">Middle Name</label>
          <input type="text" id="middleName" name="middleName" placeholder="Enter middle name">
        </div>
        
        <div class="form-group">
          <label for="lastName" class="required-field">Last Name</label>
          <input type="text" id="lastName" name="lastName" required placeholder="Enter last name">
        </div>
      </div>
      
      <!-- Standard/Grade - Moved to after names -->
      <div class="form-group">
        <label for="standard" class="required-field">Standard/Grade</label>
        <select id="standard" name="standard" required>
          <option value="">Select Standard</option>
          <option value="1">1st Grade</option>
          <option value="2">2nd Grade</option>
          <option value="3">3rd Grade</option>
          <option value="4">4th Grade</option>
          <option value="5">5th Grade</option>
          <option value="6">6th Grade</option>
          <option value="7">7th Grade</option>
          <option value="8">8th Grade</option>
          <option value="9">9th Grade</option>
          <option value="10">10th Grade</option>
          <option value="11">11th Grade</option>
          <option value="12">12th Grade</option>
        </select>
      </div>
      
      <!-- Email -->
      <div class="form-group">
        <label for="email" class="required-field">Email Address</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email address">
      </div>
      
      <!-- Password -->
      <div class="form-group">
        <label for="password" class="required-field">Create Password</label>
        <input type="password" id="password" name="" required placeholder="Create a strong password">
        <div class="password-rules">Password must be at least 8 characters long and include letters and numbers</div>
      </div>
      
      <!-- Confirm Password -->
      <div class="form-group">
        <label for="confirmPassword" class="required-field">Confirm Password</label>
        <input type="password" id="Password" name="password" required placeholder="Confirm your password">
      </div>
      
      <!-- Gender - Moved to the end -->
      <div class="form-group">
        <label class="required-field">Gender</label>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" id="male" name="gender" value="male" required>
            <label for="male">Male</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="other" name="gender" value="other">
            <label for="other">Other</label>
          </div>
        </div>
      </div>
      
      <!-- Register Button - Color changed to match heading -->
      <button type="submit" name="save">Register</button>
      
      <!-- Login Link -->
      <div class="login-link">
        Already have an account? <a href="login.php">Login</a>
      </div>
    </form>
  </div>
</body>
</html>
<?php
if(isset($_POST['save']))
{
    $FNAME=$_POST['firstName'];
    $MNAME=$_POST['middleName'];
    $LNAME=$_POST['lastName'];
    $STANDARD=$_POST['standard'];
    $EMAIL=$_POST['email'];
    $PASSWORD=$_POST['password'];
    $GENDER=$_POST['gender'];

    $query=mysqli_query($con,"INSERT INTO studentreg VALUES('','".$FNAME."','".$MNAME."','".$LNAME."','".$STANDARD."','".$EMAIL."','".$PASSWORD."','".$GENDER."')");
        if($query)
        {
            echo'
                <script>
                    alert("Inserted");
                    window.location.href="student_registration.php";
                </script>

            ';
        }
        else
        {
            echo'
                <script>
                    alert("Not inserted");
                </script>

            ';
        }

}
?>