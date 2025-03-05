<?php

include 'connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){
   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
   $c_pass = sha1($_POST['c_pass']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);   

   $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_users->execute([$email]);

   if($select_users->rowCount() > 0){
      $warning_msg[] = 'email already taken!';
   }else{
      if($pass != $c_pass){
         $warning_msg[] = 'Password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(id, name, number, email, password) VALUES(?,?,?,?,?)");
         $insert_user->execute([$id, $name, $number, $email, $c_pass]);
         
         if($insert_user){
            $verify_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
            $verify_users->execute([$email, $pass]);
            $row = $verify_users->fetch(PDO::FETCH_ASSOC);
         
            if($verify_users->rowCount() > 0){
               setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
               header('location:homepage.php');
            }else{
               $error_msg[] = 'Something went wrong!';
            }
         }

      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="icon" type="image/png" href="images/icon.png">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>

<?php include 'user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <br><h3>Create Your Account!</h3><br>
      <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="box">
      <input type="email" name="email" required maxlength="20" placeholder="Enter your email" class="box">
      <input type="tel" name="number" required maxlength="11" placeholder="Enter your phone number" class="box">
      <input type="password" name="pass" required maxlength="20" placeholder="Enter your password" class="box">
      <input type="password" name="c_pass" required maxlength="20" placeholder="Confirm your password" class="box">
      <p>Already Have An Account? <a href="login.php" style="color:#6EADCA;">Login Now!</a></p><br>
      <br><input type="submit" value="SIGN UP" name="submit" class="btn"><br>

   </form>

</section>

<?php include 'footer.php'; ?>

<script src="user_script.js"></script>

</body>
</html>