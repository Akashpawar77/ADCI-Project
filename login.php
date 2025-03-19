<?php
    $con=mysqli_connect("localhost","root","","student")or die("not connect");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap"
      rel="stylesheet"
    />
    <script>
      /*function redirectToDashboard(event) {
        event.preventDefault();
        let role = document.querySelector('input[name="role"]:checked').value;
        if (role === "admin") {
          window.location.href = "login.html";
        } else {
          window.location.href = "student_dashboard.html";
        }
      }*/
    </script>
  </head>
  <body>
    <div class="login-container">
      <div class="login-box">
        <div class="logo">Attendance System</div>
        <h2>Login</h2>
        <p>Please enter your details</p>

        <!-- Role Selection -->
        <div class="role-selection">
          <label>
            <input type="radio" name="role" value="admin" checked /> Admin
          </label>
          <label>
            <input type="radio" name="role" value="student" /> Student
          </label>
        </div>

        <!--form onsubmit="redirectToDashboard(event)" action="login.php" method="POST"-->
        <form action="login.php" method="POST">
          <div class="input-group">
            <input type="email" placeholder="Email" required name="email" />
          </div>
          <div class="input-group">
            <input type="password" placeholder="Password" name="password"required />
          </div>
          <div class="options">
            <label> Remember me <input type="checkbox" /></label>
            <a href="#">Forgot Password?</a>
          </div>
          <button type="submit" class="login-btn" name="login">Log In</button>
        </form>
      </div>
    </div>
  </body>
</html>
<?php
    if(isset($_POST['login']))
    {
        $email=$_POST['email'];
        $password=$_POST['password'];

        $res=mysqli_query($con,"SELECT * FROM admin WHERE email='".$email."' AND password='".$password."'");
        $row=mysqli_fetch_row($res);
        
        if($num=mysqli_num_rows($res)>0)
        {
            $_SESSION['admin']=$row[0];
            echo'
                <script>
                    window.location.href="admin.html";
                </script>
            ';
        }
        else
        {
            echo'
                <script>
                    alert("Wrong Username OR Password");
                    window.location.href="login.php";
                </script>
            ';
        }
    }
?>