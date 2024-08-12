<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Fashion Fusion</title>
</head>
<body>
<?php session_start()?>
<?php include('layouts/header.php')?>

<!--Home-->
<section id="home"> 
  <div class="container">
  <div class=""></div>
  <h1><span>FASHION FUSION</span></h1>
  <a href="shop.php"><button>SHOP NOW</button></a>
</section>

<!--Brand-->
<section id="Brand" class="container">
  <div class="row">
      
      <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/img/amazon.png"/>
      <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/img/flipcart.png"/>
      <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/img/myntra.png"/>   
      <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/img/meesho.png"/> 
  </div>
</section>

 <!--new-->
<section id="new" class="w-100 py-1">
<div class="container">
  <div class="row">
      <!--one-->
      <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
          <a href="#men">
              <img class="img-fluid" src="assets/img/men.png" />
          </a>
      </div>
      <!--two-->
      <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
          <a href="#women">
              <img class="img-fluid" src="assets/img/women.png" />
          </a>
      </div>
      <!--three-->
      <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
          <a href="#kids">
              <img class="img-fluid" src="assets/img/kids.png" />
          </a>
      </div>
  </div>
</div>
</section>


<!--featured-->
<section id="featured" class="my-5 pb-5">
 <div class="container text-center mt-5 py-5">
  <h3>Our Featured</h3>
  <hr class="mx-auto">
  <p>Here are our featured products</p>
 </div>
 <div class="row mx-auto container-fluid">

  <!--featured-->
  <?php include('server/get_featured_products.php');?>

  <?php while($row=$featured_products->fetch_assoc()) {?>

  <div class="product text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="assets/img/<?php echo $row['product_image'];?>"/>
      <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
      </div>
      <h5 class="p-name"><?php echo $row['product_name'];?></h5>
      <h4 class="p=price">₹ <?php echo $row['product_price'];?></h4>
      <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
  </div>

  <?php } ?>

 </div>
</section>

<!--Banner-->
<section id="banner">
  <div class="container">
    <h4>MID SEASON'S SALE</h4>
    <h1>Summer Collection <br> </h1>
    <a href="shop.php"><button class="text-uppercase">Shop now</button></a>
  </div>
</section>

<!--Men-->

<section id="men" class="my-5">
  <div class="container text-center mt-5 py-5">
   <h3>Men's Collection</h3>
   <hr class="mx-auto">
   <p>Here you can check our amazing collection</p>
  </div>
  <div class="row mx-auto container-fluid">
   <!--Men-->

   <?php include('server/get_men.php');?>

   <?php while($row=$men_products->fetch_assoc()) {?>

   <div class="product text-center col-lg-3 col-md-4 col-sm-12">
       <img class="img-fluid mb-3" src="assets/img/<?php echo $row['product_image'];?>"/>
      
       <h5 class="p-name"><?php echo $row['product_name'];?></h5>
       <h4 class="p=price">₹ <?php echo $row['product_price'];?></h4>
       <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
   </div>

   <?php } ?>
  </div>
 </section>

 <!--women-->

 <section id="women" class="my-5">
  <div class="container text-center mt-5 py-5">
   <h3>Women's Collection</h3>
   <hr class="mx-auto">
   <p>Here you can check our amazing collection</p>
  </div>
  <div class="row mx-auto container-fluid">
   
  <!--Women-->

   <?php include('server/get_women.php');?>

   <?php while($row=$women_products->fetch_assoc()) {?>
   <div class="product text-center col-lg-3 col-md-4 col-sm-12">
   <img class="img-fluid mb-3" src="assets/img/<?php echo $row['product_image'];?>"/>
      
       <h5 class="p-name"><?php echo $row['product_name'];?></h5>
       <h4 class="p=price">₹ <?php echo $row['product_price'];?></h4>
       <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
   </div>

<?php } ?>
  </div>
 </section>

 <!--Kids-->

 <section id="kids" class="my-5">
  <div class="container text-center mt-5 py-5">
   <h3>Kids's Collection</h3>
   <hr class="mx-auto">
   <p>Here you can check our amazing collection</p>
  </div>
  <div class="row mx-auto container-fluid">
   <!--Kid-->

   <?php include('server/get_kid.php');?>

   <?php while($row=$kid_products->fetch_assoc()) {?>
   <div class="product text-center col-lg-3 col-md-4 col-sm-12">
       <img class="img-fluid mb-3" src="assets/img/<?php echo $row['product_image'];?>"/>
      
       <h5 class="p-name"><?php echo $row['product_name'];?></h5>
       <h4 class="p=price">₹ <?php echo $row['product_price'];?></h4>
       <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
       
   </div>

  
<?php } ?>

  </div>
 </section>

 <?php include('layouts/footer.php')?>
</body>
</html>
