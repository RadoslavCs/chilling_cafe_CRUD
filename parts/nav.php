<?php
  include_once "classes/Menu.php";
  use classes\Menu;
  $menu = new Menu();
?>
<nav class="tm-nav" style="display: flex; justify-content: center; align-items: center; gap: 40px;">
    <ul class="tm-nav-list" style="list-style: none; margin: 0; padding: 0; display: flex; gap: 20px;">
      <?php echo $menu->getMenuFromDatabase();?>
    </ul>
  </nav>
