<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);

  $restock_id = (int)$_GET['id'];
  if(!$restock_id){
    $session->msg("d","Missing restock id.");
    redirect('restock.php');
  }

  // Attempt to delete the restock item
  if (delete_by_id('restock', $restock_id)) {
      $session->msg("s","Restock deleted.");
      redirect('restock.php');
  } else {
      // Capture detailed error messages
      $session->msg("d","Restock deletion failed: " . $db->error);
      redirect('restock.php');
  }
?>
<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $product = find_by_id('',(int)$_GET['id']);
  if(!$product){
    $session->msg("d","Missing Product id.");
    redirect('productz.php');
  }
?>
<?php
  $delete_id = delete_by_id('restock',(int)$restock['id']);
  if($delete_id){
      $session->msg("s","Products deleted.");
      redirect('product.php');
  } else {
      $session->msg("d","Products deletion failed.");
      redirect('product.php');
  }
?>
