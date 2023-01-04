<?php

include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(isset($_POST["signin"]))
    {
    // Check if the user is present in the users table
      $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
      $result = mysqli_query($conn, $query);
      
      if (mysqli_num_rows($result) > 0) {
          // User is present, login successful
          $user_info = mysqli_fetch_assoc($result);
          session_start();
          $_SESSION['email'] = $email;
          $_SESSION['name'] = $user_info['name'];
          $_SESSION['id']=$user_info['users_id'];
          header('Location: home.php');
          exit;
      } else {
          // User is not present, login failed
          $error = 'Invalid email or password';
      }
    }
    elseif (isset($_POST["signup"])) {
      // Check if the email is already taken
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $query = "SELECT * FROM users WHERE email='$email'";
      $result = mysqli_query($conn, $query);
      
      if (mysqli_num_rows($result) > 0) {
          // email is already exsists
          $error = 'email already exsists';
      } else {
          // Insert the new user into the users table
          $query = "INSERT INTO users (name,email, password) VALUES ('$name','$email', '$password')";
          if (mysqli_query($conn, $query)) {
              // Signup successful, login the user
              session_start();
              $_SESSION['email'] = $email;
              $_SESSION['name'] = $name;
              $_SESSION['id']=$user_info['users_id'];
              header('Location: home.php');
              exit;
          } else {
              // Signup failed
              $error = 'Error: ' . mysqli_error($conn);
          }
      }
  }
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/index.css" />
    <script src="./js/index.js" defer></script>
    <title>Document</title>
</head>
<body>
  <!-- Display error message if there is one -->
<?php if (isset($error)) {
  echo "<script>alert('$error')</script>";
} ?>
    <section class="user">
        <div class="user_options-container">
          <div class="user_options-text">
            <div class="user_options-unregistered">
              <h2 class="user_unregistered-title">Don't have an account?</h2>

              <button class="user_unregistered-signup" id="signup-button">Sign up</button>
            </div>
      
            <div class="user_options-registered">
              <h2 class="user_registered-title">Have an account?</h2>
              <button class="user_registered-login" id="login-button">Login</button>
            </div>
          </div>
          
          <div class="user_options-forms" id="user_options-forms">
            <div class="user_forms-login">
              <h2 class="forms_title">Login</h2>
              <form class="forms_form" method="post" action="">
                <fieldset class="forms_fieldset">
                  <div class="forms_field">
                    <input type="email" name = "email" placeholder="Email" class="forms_field-input" required autofocus />
                  </div>
                  <div class="forms_field">
                    <input type="password" name = "password" placeholder="Password" class="forms_field-input" required />
                  </div>
                </fieldset>
                <div class="forms_buttons">
                  <input type="submit" name = "signin" value="Log In" class="forms_buttons-action">
                </div>
              </form>
            </div>
            <div class="user_forms-signup">
              <h2 class="forms_title">Sign Up</h2>
              <form class="forms_form" method = "post" action="">
                <fieldset class="forms_fieldset">
                  <div class="forms_field">
                    <input type="text" name = "name" placeholder="Full Name" class="forms_field-input" required />
                  </div>
                  <div class="forms_field">
                    <input type="email" name = "email" placeholder="Email" class="forms_field-input" required />
                  </div>
                  <div class="forms_field">
                    <input type="password" name = "password" placeholder="Password" class="forms_field-input" required />
                  </div>
                </fieldset>
                <div class="forms_buttons">
                  <input type="submit" name = "signup" value="Sign up" class="forms_buttons-action">
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
</body>
</html>
