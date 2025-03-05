<?php

include 'connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING); 
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 

   $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $select_users->execute([$email, $pass]);
   $row = $select_users->fetch(PDO::FETCH_ASSOC);

   if($select_users->rowCount() > 0){
      setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
      header('location:homepage.php');
   }else{
      $warning_msg[] = 'Incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="icon" type="image/png" href="images/icon.png">
   <link rel="stylesheet" href="style.css">

</head>
<body>

<?php include 'user_header.php'; ?>

<section class="form-container">

   <form action="" method="post"><br>
      <h3>Welcome!</h3><br>
      <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="box">
      <input type="password" name="pass" required maxlength="20" placeholder="Enter your password" class="box">
      <p>Don’t Have An Account Yet? <a href="register.php" style="color:#6EADCA;">Register Now! </a></p><br>
      <br><input type="submit" value="LOGIN NOW" name="submit" class="btn"><br>
   </form>

</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'footer.php'; ?>

<script src="user_script.js"></script>
<?php include 'message.php'; ?>

</body>
</html>