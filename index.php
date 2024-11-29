<!DOCTYPE html>
<html lang="en">
 <?php
 include_once("parts/head.php");
 ?>
  <body>
   
  <?php
  # Header Section
  include_once("parts/header.php");
  # Navigation Section
  include_once("parts/nav.php");
  ?>

    <div class="tm-container">
     
      <div class="tm-main-content">
        <div id="tm-intro-img"></div>       
       
       <?php
       // Coffee and Tea menu
        include_once("parts/menu.php");
        // Special Items
        include_once("parts/special_items.php");
        // About our cafe
        include_once("parts/about.php");
        // Contact us
        include_once("parts/contact.php");
       ?>     
       
      </div>      
      <?php   
      # Footer Section 
       include_once("parts/footer.php");
       ?>
      ?>
  </body>
</html>