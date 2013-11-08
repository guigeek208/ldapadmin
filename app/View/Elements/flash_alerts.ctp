<?php 
if(!isset($class)) { 
    $class="success";
}
?>
<div class="alert alert-<?php echo $class; ?> alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>
      <?php
      if ($class == "danger") {
          echo "Erreur : ";
      }
      ?>
  </strong> <?php echo h($message);?>
  
</div>
