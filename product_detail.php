<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('header.php');
?>
<?php

require 'config/config.php';
$stmt=$pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetch(PDO::FETCH_ASSOC);

?>

<!--================Single Product Area =================-->
<div class="product_image_area">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">

          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo $result['image']?>" style="display:block; margin-left:auto; margin-right:auto; width:60%; height:60%; !important;">
          </div>


      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo escape($result['name'])?></h3>
          <h2><?php echo escape($result['price'])?></h2>
          <ul class="list">
            <li><a href="#"><span>Availibility</span> : In Stock</a></li>
          </ul>
          <p><?php echo escape($result['description'])?></p>
          <div class="product_count">
             <label for="qty">Quantity:</label>
             <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
             <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
              class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
             <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
              class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
           </div>
           <div class="card_area d-flex align-items-center">
              <button class="primary-btn" href="#" style="border:1px">Add to Cart</button>
              <a class="primary-btn" href="index.php">Back</a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
