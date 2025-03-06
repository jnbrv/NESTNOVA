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
   <title>Search Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="icon" type="image/png" href="images/icon.png">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php include 'user_header.php'; ?>

<!-- search filter section starts  -->

<section class="filters" style="padding-bottom: 0;">

   <form action="" method="post">
      <div id="close-filter"><i class="fas fa-times"></i></div>
      <h3>Search Filter</h3>
         
         <div class="flex">
            <div class="box">
               <p>enter location</p>
               <input type="text" name="location" required maxlength="50" placeholder="Enter City name" class="input">
            </div>
            <div class="box">
               <p>offer type</p>
               <select name="offer" class="input" required>
                  <option value="sale">sale</option>
                  <option value="resale">resale</option>
                  <option value="rent">rent</option>
               </select>
            </div>
            <div class="box">
               <p>property type</p>
               <select name="type" class="input" required>
                  <option value="flat">flat</option>
                  <option value="house">house</option>
                  <option value="shop">shop</option>
               </select>
            </div>
            <div class="box">
               <p>minimum budget</p>
               <select name="min" class="input" required>
                  <option value="5000">5000</option>
                  <option value="10000">10000</option>
                  <option value="15000">15000</option>
                  <option value="20000">20000</option>
                  <option value="30000">30000</option>
                  <option value="40000">40k</option>
                  <option value="50000">50k</option>
                  <option value="100000">100k</option>
                  <option value="500000">500k</option>
                  <option value="1000000">10 lac</option>
                  <option value="2000000">20 lac</option>
                  <option value="3000000">30 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="5000000">50 lac</option>
                  <option value="6000000">60 lac</option>
                  <option value="7000000">70 lac</option>
                  <option value="8000000">80 lac</option>
               </select>
            </div>
            <div class="box">
               <p>maximum budget</p>
               <select name="max" class="input" required>
                  <option value="5000">5k</option>
                  <option value="10000">10k</option>
                  <option value="15000">15k</option>
                  <option value="20000">20k</option>
                  <option value="30000">30k</option>
                  <option value="40000">40k</option>
                  <option value="40000">40k</option>
                  <option value="50000">50k</option>
                  <option value="100000">1 lac</option>
                  <option value="500000">5 lac</option>
                  <option value="1000000">10 lac</option>
                  <option value="2000000">20 lac</option>
                  <option value="3000000">30 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="5000000">50 lac</option>
                  <option value="6000000">60 lac</option>
                  <option value="7000000">70 lac</option>
                  <option value="8000000">80 lac</option>
                  <option value="9000000">90 lac</option>
                  <option value="10000000">1 Cr</option>
                  <option value="20000000">2 Cr</option>
                  <option value="30000000">3 Cr</option>
                  <option value="40000000">4 Cr</option>
                  <option value="50000000">5 Cr</option>
                  <option value="60000000">6 Cr</option>
                  <option value="70000000">7 Cr</option>
                  <option value="80000000">8 Cr</option>
                  <option value="90000000">9 Cr</option>
                  <option value="100000000">10 Cr</option>
                  <option value="150000000">15 Cr</option>
                  <option value="200000000">20 Cr</option>
               </select>
            </div>
            <div class="box">
               <p>status</p>
               <select name="status" class="input" required>
                  <option value="ready to move">ready to move</option>
                  <option value="under construction">under construction</option>
               </select>
            </div>
            <div class="box">
               <p>furnished</p>
               <select name="furnished" class="input" required>
                  <option value="unfurnished">unfurnished</option>
                  <option value="furnished">furnished</option>
                  <option value="semi-furnished">semi-furnished</option>
               </select>
            </div>
         </div>
         <input type="submit" value="search property" name="filter_search" class="btn">
   </form>

</section>

<!-- search filter section ends -->

<div id="filter-btn" class="fas fa-filter"></div>

<?php

if(isset($_POST['h_search'])){

   $h_location = filter_var($_POST['h_location'], FILTER_SANITIZE_STRING);
   $h_type = filter_var($_POST['h_type'], FILTER_SANITIZE_STRING);
   $h_offer = filter_var($_POST['h_offer'], FILTER_SANITIZE_STRING);
   $h_min = filter_var($_POST['h_min'], FILTER_VALIDATE_INT);
   $h_max = filter_var($_POST['h_max'], FILTER_VALIDATE_INT);

   if ($h_min === false) $h_min = 0;
   if ($h_max === false) $h_max = PHP_INT_MAX;

   $select_properties = $conn->prepare("SELECT * FROM `property` WHERE address LIKE ? AND type LIKE ? AND offer LIKE ? AND price BETWEEN ? AND ? ORDER BY date DESC");
   $select_properties->execute(["%$h_location%", "%$h_type%", "%$h_offer%", $h_min, $h_max]);

} elseif(isset($_POST['filter_search'])){

   $location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
   $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
   $offer = filter_var($_POST['offer'], FILTER_SANITIZE_STRING);
   $min = filter_var($_POST['min'], FILTER_VALIDATE_INT);
   $max = filter_var($_POST['max'], FILTER_VALIDATE_INT);
   $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
   $furnished = filter_var($_POST['furnished'], FILTER_SANITIZE_STRING);

   if ($min === false) $min = 0;
   if ($max === false) $max = PHP_INT_MAX;

   $select_properties = $conn->prepare("SELECT * FROM `property` WHERE address LIKE ? AND type LIKE ? AND offer LIKE ? AND status LIKE ? AND furnished LIKE ? AND price BETWEEN ? AND ? ORDER BY date DESC");
   $select_properties->execute(["%$location%", "%$type%", "%$offer%", "%$status%", "%$furnished%", $min, $max]);

   // Insert search query into searchHistory (only if user is logged in)
   if(!empty($user_id)){
      $insert_history = $conn->prepare("INSERT INTO searchHistory (userID, loc, offertype, propertyType, minBudget, maxBudget, status, furnished) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $insert_history->execute([$user_id, $location, $offer, $type, $min, $max, $status, $furnished]);
   }

} else {
   $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
   $select_properties->execute();
}

?>



<!-- listings section starts  -->

<section class="listings">
   <?php 
      if(isset($_POST['h_search']) or isset($_POST['filter_search'])){
         echo '<h1 class="heading">search results</h1>';
      }else{
         echo '<h1 class="heading">latest listings</h1>';
      }
   ?>

   <div class="box-container">
      <?php
         $total_images = 0;
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
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
            </div>
            
         </div>
         <div class="box">
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
      }
      ?>
      
   </div>

   <?php
   // If no results are found, show the centered message with the image
   if ($select_properties->rowCount() == 0) {
      echo '<div class="no-properties" style="text-align:center; margin-top:20px;">
               <p class="empty">
                  <img src="images/house-icon.png" alt="" style="height: 150px"><br><br>
                  No results found!
                  <a href="allProperties.php" style="margin-top:1.5rem;" class="btn">Go Back</a>
               </p>
            </div>';
   }
   ?>

</section>

<!-- listings section ends -->











<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="user_script.js"></script>

<?php include 'message.php'; ?>

<script>

document.querySelector('#filter-btn').onclick = () =>{
   document.querySelector('.filters').classList.add('active');
}

document.querySelector('#close-filter').onclick = () =>{
   document.querySelector('.filters').classList.remove('active');
}

</script>

</body>
</html>
