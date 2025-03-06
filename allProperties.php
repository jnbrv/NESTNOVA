<?php  

include 'connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'save_send.php';

// Get filter parameter from URL
$offer = isset($_GET['offer']) ? $_GET['offer'] : '';

if ($offer == 'rent' || $offer == 'sale') {
   $select_properties = $conn->prepare("SELECT * FROM `property` WHERE offer = ? ORDER BY date DESC");
   $select_properties->execute([$offer]);
} else {
   $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC");
   $select_properties->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>All Properties</title>

   <!-- Font Awesome & CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="icon" type="image/png" href="images/icon.png">
   <link rel="stylesheet" href="style.css">
</head>
<body>
   
<?php include 'user_header.php'; ?>

<section class="listings">
   <h1 class="heading">All Properties</h1>

   <div class="box-container">
      <?php
         if($select_properties->rowCount() > 0){
            while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){

            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_user->execute([$fetch_property['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

            $total_images = 1 + !empty($fetch_property['image_02']) + !empty($fetch_property['image_03']) + !empty($fetch_property['image_04']) + !empty($fetch_property['image_05']);

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
            <button type="submit" name="save" class="save">
               <i class="<?= $select_saved->rowCount() > 0 ? 'fas' : 'far'; ?> fa-heart"></i>
               <span><?= $select_saved->rowCount() > 0 ? 'saved' : 'save'; ?></span>
            </button>
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
               <a href="viewProperty.php?get_id=<?= $fetch_property['id']; ?>" class="btn">View Property</a>
            </div>
         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty"><img src="images/house-icon.png" alt="" style="height: 150px"><br><br>No properties found. <br><a href="postProperty.php" style="margin-top:1.5rem;" class="btn">Add New</a></p>';
      }
      ?>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'footer.php'; ?>
<script src="user_script.js"></script>
<?php include 'message.php'; ?>

</body>
</html>
