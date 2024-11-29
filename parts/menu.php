<?php
 include_once "classes/Table.php";

 use classes\Table;
 $table = new Table(); 
 ?>

  <!-- Coffee Menu -->
  <section id="coffee-menu" class="tm-section">
          <h2 class="tm-section-header">Coffee Menu</h2>
          <div class="tm-responsive-table">          
          <?php 
            //echo $table->getTableFromFile("table");
            echo $table->getTableFromDatabase("table");
           ?>
          </div>
        </section>

        <!-- Tea Menu -->
        <section id="tea-menu" class="tm-section">
          <h2 class="tm-section-header">Tea Menu</h2>
          <div class="tm-responsive-table">
          <?php 
            //echo $table->getTableFromFile("tableTea"); 
            echo $table->getTableFromDatabase("tableTea"); 
          ?>
          </div>
        </section>