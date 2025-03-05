<?php  

include 'connect.php';

if(isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
}

// Handle the clear all request (only for logged-in users)
if(isset($_POST['clear_history']) && $user_id != ''){
    $delete_query = $conn->prepare("DELETE FROM searchHistory WHERE userID = ?");
    $delete_query->execute([$user_id]);
}

// Fetch search history ONLY for logged-in users
$searchHistory = [];
if($user_id != ''){
    $query = $conn->prepare("SELECT * FROM searchHistory WHERE userID = ? ORDER BY searchHistoryID DESC");
    $query->execute([$user_id]);
    $searchHistory = $query->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search History</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="icon" type="image/png" href="images/icon.png">
   <link rel="stylesheet" href="style.css">
</head>
<body>
   
<?php include 'user_header.php'; ?>

<section>
   <h2 style="text-align: center; margin-top: 20px; font-size: 3rem;">Search History</h2>
   
   <?php if($user_id != ''): ?>
      <table class="history-table">
         <tr>
            <th>Location</th>
            <th>Offer Type</th>
            <th>Property Type</th>
            <th>Min Budget</th>
            <th>Max Budget</th>
            <th>Status</th>
            <th>Furnished</th>
         </tr>
         <?php if (!empty($searchHistory)): ?>
            <?php foreach($searchHistory as $row): ?>
               <tr>
                  <td><?= htmlspecialchars($row['loc']) ?></td>
                  <td><?= htmlspecialchars($row['offertype']) ?></td>
                  <td><?= htmlspecialchars($row['propertyType']) ?></td>
                  <td><?= htmlspecialchars($row['minBudget']) ?></td>
                  <td><?= htmlspecialchars($row['maxBudget']) ?></td>
                  <td><?= htmlspecialchars($row['status']) ?></td>
                  <td><?= htmlspecialchars($row['furnished']) ?></td>
               </tr>
            <?php endforeach; ?>
         <?php else: ?>
            <tr>
               <td colspan="7" style="text-align: center;">No search history found.</td>
            </tr>
         <?php endif; ?>
      </table>
      <form method="post" style="text-align: center; border-radius: 15px;">
         <button type="submit" name="clear_history" class="clear-btn">Clear All</button>
      </form>
   <?php else: ?>
      <p style="text-align: center; font-size: 1.5rem; color: #777;"><br>You must be logged in to view your search history.</p>
   <?php endif; ?>
   
</section>

<?php include 'footer.php'; ?>
<script src="user_script.js"></script>
</body>
</html>
