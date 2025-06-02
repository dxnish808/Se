<?php
  $page_title = 'Edit Restock';
  require_once('includes/load.php');
  // Check what level user has permission to view this page
  page_require_level(3);
?>
<?php
$restock = find_all_restock_product((int)$_GET['id']);
$restock = $restock[0];
$all_products = find_all('products');

if(!$restock){
  $session->msg("d","Missing restock id.");
  redirect('restock.php');
}
?>
<?php

  if(isset($_POST['update_restock'])){
    $req_fields = array('product_id','quantity', 'date' );
    validate_fields($req_fields);
    if(empty($errors)){
      $pid  = $db->escape((int)$_POST['product_id']);
      $quantity     = $db->escape((int)$_POST['quantity']);
      $date         = $db->escape($_POST['date']);

      $sql  = "UPDATE restock SET";
      $sql .= " product_id='{$pid}', quantity='{$quantity}', date='{$date}'";
      $sql .= " WHERE id ='{$restock['id']}'";
      $result = $db->query($sql);
      if($result && $db->affected_rows() === 1){
        $session->msg('s',"Restock updated.");
        redirect('edit_restock.php?id='.$restock['id'], false);
      } else {
        $session->msg('d',' No data updated!');
        // redirect('restock.php', false);
        redirect('edit_restock.php?id='.$restock['id'], false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('edit_restock.php?id='.(int)$restock['id'],false);
    }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <?php if($restock['status'] == 0){ ?>
        <span>Edit Restock</span>
        <?php }else{ ?>
              View Restock
        <?php } ?>
     </strong>
     <div class="pull-right">
       <a href="restock.php" class="btn btn-info btn-sm">Show all restocks</a>
     </div>
    </div>
    <div class="panel-body">
       <table class="table table-bordered">
         <thead>
          <th> Product Name </th>
          <th> Quantity </th>
          <th> Date </th>
           <?php if($restock['status'] == 0){ ?>
          <th> Action </th>
           <?php } ?>
         </thead>
           <tbody  id="product_info">
              <tr>
              <form method="post" action="edit_restock.php?id=<?php echo $restock['id']; ?>">
                <td id="r_name">
                  <select class="form-control" name="product_id" required>
                    <option value="">Select Product</option>
                    <?php foreach ($all_products as $pro): ?>
                      <option value="<?php echo (int)$pro['id'] ?>" <?php echo ($pro['id'] == $restock['product_id']) ? 'selected' : '' ?>>
                        <?php echo $pro['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </td>
             
                <td id="r_quantity">
                  <input type="number" class="form-control" name="quantity" value="<?php echo (int)$restock['quantity']; ?>">
                </td>
        
                <td id="r_date">
                  <input type="date" class="form-control datepicker" name="date" value="<?php echo remove_junk($restock['date']); ?>">
                </td>
                 <?php if($restock['status'] == 0){ ?>
                <td>
                  <div class="btn-group">
                    <form method="post" action="delete_restock.php?id=<?php echo (int)$restock['id']; ?>" style="display: inline;">
                      <button type="submit" name="delete_restock" class="btn btn-danger btn-xs" title="Delete">
                        <i class="glyphicon glyphicon-trash"></i>
                      </button>
                    </form>
                    <button type="submit" name="update_restock" class="btn btn-primary btn-xs" title="Update">
                      <i class="glyphicon glyphicon-check"></i>
                    </button>
                  </div>
                </td>
                 <?php } ?>
              </form>
              </tr>
           </tbody>
       </table>
    </div>
  </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
