<?php
    $conn=mysqli_connect("localhost","root","","student_db")or die("not connect");
    session_start();
// Table creation query (run this once or check if table exists)
$create_table_query = "CREATE TABLE IF NOT EXISTS students (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    standard VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($create_table_query)) {
    echo "Error creating table: " . $conn->error;
}

// PHP code to handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = trim($_POST['firstName']);
    $middleName = trim($_POST['middleName']);
    $lastName = trim($_POST['lastName']);
    $standard = $_POST['standard'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    
    // Initialize error array
    $errors = [];
    
    // Validate form data
    if (empty($firstName)) {
        $errors['firstName'] = 'First name is required';
    }
    
    if (empty($lastName)) {
        $errors['lastName'] = 'Last name is required';
    }
    
    if (empty($standard)) {
        $errors['standard'] = 'Please select a standard/grade';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email address is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    } else {
        // Check if email already exists in database
        $check_email = $conn->prepare("SELECT email FROM students WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $result = $check_email->get_result();
        
        if ($result->num_rows > 0) {
            $errors['email'] = 'Email address already registered';
        }
        $check_email->close();
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
    }
    
    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = 'Passwords do not match';
    }
    
    if (empty($gender)) {
        $errors['gender'] = 'Please select a gender option';
    }
    
    // If no errors, process the form and save to database
    if (empty($errors)) {
        // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO students (first_name, middle_name, last_name, standard, email, password, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstName, $middleName, $lastName, $standard, $email, $hashedPassword, $gender);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful
            echo "<script>alert('Registration successful! Redirecting to login page...');</script>";
            echo "<script>window.location.href = 'login.html';</script>";
            exit;
        } else {
            // Registration failed
            $errors['general'] = "Registration failed: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration Form</title>
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
    
    .general-error {
      background-color: #fee2e2;
      border: 1px solid #ef4444;
      color: #b91c1c;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 500;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-header">
      <h1>Student Registration</h1>
    </div>
    
    <?php if (isset($errors['general'])): ?>
      <div class="general-error"><?php echo $errors['general']; ?></div>
    <?php endif; ?>
    
    <form id="registrationForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <!-- Name Fields -->
      <div class="name-fields">
        <div class="form-group">
          <label for="firstName" class="required-field">First Name</label>
          <input type="text" id="firstName" name="firstName" required placeholder="Enter first name" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>">
          <?php if (isset($errors['firstName'])): ?>
            <div class="error"><?php echo $errors['firstName']; ?></div>
          <?php endif; ?>
        </div>
        
        <div class="form-group">
          <label for="middleName">Middle Name</label>
          <input type="text" id="middleName" name="middleName" placeholder="Enter middle name" value="<?php echo isset($_POST['middleName']) ? htmlspecialchars($_POST['middleName']) : ''; ?>">
        </div>
        
        <div class="form-group">
          <label for="lastName" class="required-field">Last Name</label>
          <input type="text" id="lastName" name="lastName" required placeholder="Enter last name" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>">
          <?php if (isset($errors['lastName'])): ?>
            <div class="error"><?php echo $errors['lastName']; ?></div>
          <?php endif; ?>
        </div>
      </div>
      
      <!-- Standard/Grade -->
      <div class="form-group">
        <label for="standard" class="required-field">Standard/Grade</label>
        <select id="standard" name="standard" required>
          <option value="">Select Standard</option>
          <?php
          $grades = [
            '1' => '1st Grade',
            '2' => '2nd Grade',
            '3' => '3rd Grade',
            '4' => '4th Grade',
            '5' => '5th Grade',
            '6' => '6th Grade',
            '7' => '7th Grade',
            '8' => '8th Grade',
            '9' => '9th Grade',
            '10' => '10th Grade',
            '11' => '11th Grade',
            '12' => '12th Grade'
          ];
          
          foreach ($grades as $value => $label) {
            $selected = (isset($_POST['standard']) && $_POST['standard'] == $value) ? 'selected' : '';
            echo "<option value=\"$value\" $selected>$label</option>";
          }
          ?>
        </select>
        <?php if (isset($errors['standard'])): ?>
          <div class="error"><?php echo $errors['standard']; ?></div>
        <?php endif; ?>
      </div>
      
      <!-- Email -->
      <div class="form-group">
        <label for="email" class="required-field">Email Address</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email address" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        <?php if (isset($errors['email'])): ?>
          <div class="error"><?php echo $errors['email']; ?></div>
        <?php endif; ?>
      </div>
      
      <!-- Password -->
      <div class="form-group">
        <label for="password" class="required-field">Create Password</label>
        <input type="password" id="password" name="password" required placeholder="Create a strong password">
        <div class="password-rules">Password must be at least 8 characters long and include letters and numbers</div>
        <?php if (isset($errors['password'])): ?>
          <div class="error"><?php echo $errors['password']; ?></div>
        <?php endif; ?>
      </div>
      
      <!-- Confirm Password -->
      <div class="form-group">
        <label for="confirmPassword" class="required-field">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm your password">
        <?php if (isset($errors['confirmPassword'])): ?>
          <div class="error"><?php echo $errors['confirmPassword']; ?></div>
        <?php endif; ?>
      </div>
      
      <!-- Gender -->
      <div class="form-group">
        <label class="required-field">Gender</label>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" id="male" name="gender" value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'checked' : ''; ?> required>
            <label for="male">Male</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="female" name="gender" value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'checked' : ''; ?>>
            <label for="female">Female</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="other" name="gender" value="other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'other') ? 'checked' : ''; ?>>
            <label for="other">Other</label>
          </div>
        </div>
        <?php if (isset($errors['gender'])): ?>
          <div class="error"><?php echo $errors['gender']; ?></div>
        <?php endif; ?>
      </div>
      
      <!-- Register Button -->
      <button type="submit">Register</button>
      
      <!-- Login Link -->
      <div class="login-link">
        Already have an account? <a href="login.html">Login</a>
      </div>
    </form>
  </div>
</body>
</html>