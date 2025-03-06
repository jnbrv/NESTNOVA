<?php  

include 'connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'save_send.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/icon.png">

</head>
<body>

<?php include 'user_header.php'; ?>
<div class="main-content">
   
<div class="home">
    <section class="center">
        <div class="home-content">
            <h2>Find Your Home,</h2>
            <h3>Where Life’s Best Moments Happen.</h3>
            <div class="btn-box">
            <button class="button-1" onclick="window.location.href='allProperties.php';">EXPLORE</button>
            </div>
        </div>
    </section>
</div>

<!----------------------- recommend section starts  ----------------------->

<section class="listings">

   <h1 class="heading">Search your dream house!</h1>

   <div class="box-container">
      <?php
         $total_images = 0;
         $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 3");
         $select_properties->execute();
         if($select_properties->rowCount() > 0){
            while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){
               
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_user->execute([$fetch_property['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

            if(!empty($fetch_property['image_02'])){
               $image_coutn_02 = 1;
            }else{
               $image_coutn_02 = 0;
            }
            if(!empty($fetch_property['image_03'])){
               $image_coutn_03 = 1;
            }else{
               $image_coutn_03 = 0;
            }
            if(!empty($fetch_property['image_04'])){
               $image_coutn_04 = 1;
            }else{
               $image_coutn_04 = 0;
            }
            if(!empty($fetch_property['image_05'])){
               $image_coutn_05 = 1;
            }else{
               $image_coutn_05 = 0;
            }

            $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);

            $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
            $select_saved->execute([$fetch_property['id'], $user_id]);

      ?>
      <form action="" method="POST">
         <div class="box">
            
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_property['date']; ?></span>
               </div>
            </div>
            <div class="thumb">
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
               <?php
                  if($select_saved->rowCount() > 0){
               ?>
               <button type="submit" name="save" class="save"><a href="saved.php"><i class="fas fa-heart"></i></button>
               <?php
                  }else{ 
               ?>
               <button type="submit" name="save" class="save"><i class="far fa-heart"></i></button>
               <?php
                  }
               ?>
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
            </div>
            

            <div class="price"><i class="fa-solid fa-peso-sign"></i><span><?= $fetch_property['price']; ?></span></div>
            <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
               <p><i class="fas fa-tag"></i><span><?= $fetch_property['offer']; ?></span></p>
               <p><i class="fas fa-trowel"></i><span><?= $fetch_property['status']; ?></span></p>
               <p><i class="fas fa-couch"></i><span><?= $fetch_property['furnished']; ?></span></p>
               <p><i class="fas fa-maximize"></i><span><?= $fetch_property['carpet']; ?>sqft</span></p>
            </div>
            <div class="flex-btn">
               <a href="viewProperty.php?get_id=<?= $fetch_property['id']; ?>" class="btn">view property</a>
            </div>
         </div>
      </form>
      <?php
         }
      }else{
         echo '<p class="empty"><img src="images/house-icon.png" alt="" style="height: 150px"><br><br>No Properties Added Yet. <br><a href="postProperty.php" style="margin-top:1.5rem; border-radius: 30px; width: 50%" class="btn">add new</a></p>';
      }
      ?>
      
   </div>
   <?php
      $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 3");
      $select_properties->execute();
      
      if($select_properties->rowCount() > 2){
   ?>
   <div style="margin-top: 2rem; text-align:center; width: 100%; display: flex; justify-content: center;">
      <a href="allProperties.php" class="inline-btn">view all</a>
   </div>
   <?php
      }
   ?>

</section>

<!------------------------ recommend section ends  ----------------------->

<!----------------------- services section starts  ----------------------->

<div style="background-color: #fff; padding: 50px 0;">
    <section class="services" style="background-color: #fff; max-width: 1200px; margin: auto; padding: 20px;">
        <div class="services-content">
            <h1 class="heading">Would You Like To...</h1>
        </div>

        <div class="box-container">

            <div class="box" onclick="window.location.href='allProperties.php?offer=sale'">
                <img src="images/icon-1.png" alt="">
                <h3>buy</h3>
                <p>Discover your dream home with our listings. Browse through a variety of properties, compare prices, and connect with sellers to make your home-buying experience and hassle-free.</p>
            </div>

            <div class="box" onclick="window.location.href='allProperties.php?offer=rent'">
                <img src="images/icon-3.png" alt="">
                <h3>rent</h3>
                <p>Find the perfect rental property that suits your needs and budget. Explore a wide range of apartments, condos, and houses available for rent, with flexible options and secure transactions.</p>
            </div>

            <div class="box" onclick="window.location.href='postProperty.php'">
                <img src="images/icon-2.png" alt="">
                <h3>sell</h3>
                <p>Easily list your property and reach buyers. Our platform helps you showcase your home with high-quality images, detailed descriptions, and guidance for a fast and profitable sale.</p>
            </div>

        </div>
    </section>
</div>

 
 <!----------------------- services section ends ----------------------->
 
</div>

<!-- Footer section starts -->
<?php include 'footer.php'; ?>
<!-- Footer section ends -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="user_script.js"></script>
<?php include 'message.php'; ?>
</body>
</html>
