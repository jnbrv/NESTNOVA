<header class="header">
   <nav class="navbar nav-1">
      <section class="flex">
         <a href="homepage.php" class="logo">
            <img src="images/icon.png" class="icon"> NEST<span class="nova">NOVA</span>
         </a>        
     
         <button class="searchbtn" onclick="window.location.href='search.php'">Search Property <i class="fa fa-search"></i></button>
            
      </section>
   </nav>
     
   <nav class="navbar nav-2">
      <section class="flex">
         <div id="menu-btn" class="fas fa-bars"></div>
     
         <div class="menu">
            <ul>
               <li><a href="dashboard.php">DASHBOARD</a>
               </li>
                  <li><a href="#">OPTIONS</a>
                     <ul class="firstList">
                           <li><a href="postProperty.php">Post property</a></li>
                           <li><a href="mylistings.php">My Listing</a></li> 
                           <li><a href="searchHistory.php">Search History</a></li> 
                     </ul>
                  </li>
                    <li><a href="#">HELP</a>
                       <ul class="secondList">
                           <li><a href="about.php">about us</a></i></li>
                           <li><a href="contact.php">contact us</a></i></li>
                           <li><a href="contact.php#faq">FAQ</a></i></li>
                       </ul>
                    </li>
                 </ul>
              </div>
     
              <ul>
                 <li><a href="saved.php">SAVED <i class="far fa-heart"></i></a></li>
                 <li><a href="#">ACCOUNT</a>
                    <ul class="fifthList">
                        <li><a href="login.php">login</a></li>
                        <li><a href="register.php">register</a></li>
                        <?php if($user_id != ''){ ?>
                        <li><a href="updateProfile.php">update profile</a></li>
                        <li><a href="userlogout.php" onclick="return confirm('logout from this website?');">logout</a>
                        <?php } ?></li>
                    </ul>
                 </li>
              </ul>
           </section>
        </nav>
</header>
     