<?php foreach($productDetail as $detail){
  ?>
  <li rel="<?php echo $detail->productRef; ?>" class="currentProduct" src="getProductDetails"><?php echo $detail->brandName; ?></li>
  <?php
}
?>
