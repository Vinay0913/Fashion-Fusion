<?php
include('server/connection.php');
session_start();

if(isset($_POST['search'])) {
    if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
        // If already entered page
        $page_no= $_GET['page_no'];
    } else {
        $page_no=1;
    }

    // Query to get total records
    $stmt1 = $conn->prepare("SELECT count(*) AS total_records FROM products");
    $stmt1->execute();
    $result = $stmt1->get_result();
    $row = $result->fetch_assoc();
    $total_records = $row['total_records'];

    $category = isset($_POST['category']) ? $_POST['category'] : ''; // Check if category is set
    $price = $_POST['price'];

    // Build the query based on whether a category is selected or not
    if(!empty($category)) {
        if ($category == 'ALL') {
            header("Location: shop.php"); // Redirect to shop.php if ALL is selected
            exit();
        } else {
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price >=?");
            $stmt->bind_param("si", $category, $price);
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_price >=?");
        $stmt->bind_param("i", $price);
    }
    
    $stmt->execute();
    $products = $stmt->get_result();
} else {
    if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
        // If already entered page
        $page_no= $_GET['page_no'];
    } else {
        $page_no=1;
    }

    // Query to get total records
    $stmt1 = $conn->prepare("SELECT count(*) AS total_records FROM products");
    $stmt1->execute();
    $result = $stmt1->get_result();
    $row = $result->fetch_assoc();
    $total_records = $row['total_records'];

    $total_records_per_page = 8;
    $offset = ($page_no - 1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page =  $page_no + 1;
    $adjacents = 2;
    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    // Query to get products for the current page
    $stmt2 = $conn->prepare("SELECT * FROM products LIMIT ?, ?");
    $stmt2->bind_param("ii", $offset, $total_records_per_page);
    $stmt2->execute();
    $products = $stmt2->get_result();

    // Check if $products is null, if so, initialize it with an empty array
    if(!$products) {
        $products = array();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Shop</title>
</head>
<body>
    
<style>
    .pagination a {
        color: coral;
    }

    .pagination a:hover {
        color: white;
        background-color: coral;
    }
</style>
<?php include('layouts/header.php')?>

<div class="container">
    <div class="row">
        <!-- Search Section -->
        <div class="col-md-2">
            <section id="search" class="my-4 py-4 ms-2">
                <div class="container mt-4 py-4">
                    <p>Search Products</p>
                    <hr>
                </div>
                <form action="shop.php" method="POST">
                    <div class="row mx-auto container">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p>Category</p>

                          

                            <div class="form-check">
                                <input class="form-check-input" value="Men" type="radio" name="category" id="category_one">
                                <label class="form-check-label" for="flexRadioDefault">Men</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" value="Women" type="radio" name="category" id="category_two">
                                <label class="form-check-label" for="flexRadioDefault">Women</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" value="Kid" type="radio" name="category" id="category_three">
                                <label class="form-check-label" for="flexRadioDefault">Kids</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto container mt-4">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p>Price</p>
                            <input type="range" class="form-range w-50" name="price" value="100" min="1" max="10000" id="customRange2">
                            <div class="w-50">
                                <span style="float:  left;">1</span>
                                <span style="float:  right;">10000</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group my-3 mx-3">
                        <input type="submit" name="search" value="Search" class="btn btn-primary">
                    </div>
                </form>
            </section>
        </div>

        <!-- Featured Products Section -->
        <div class="col-md-10">
            <section id="featured" class="my-4 py-4">
                <div class="container text-center py-4 mt-3">
                    <h4>Our Products</h4>
                </div>
                <div class="row mx-auto container">
                    <?php while($row = $products->fetch_assoc() ){ ?>
                        <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id'];?>'" class="product text-center col-lg-3 col-md-4 col-sm-12">
                            <img class="img-fluid mb-3" src="assets/img/<?php echo $row['product_image']?>"/>
                            <div class="star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h5 class="p-name"><?php echo $row['product_name']?></h5>
                            <h4 class="p-price">₹ <?php echo $row['product_price']?></h4>
                            <a class="btn shop-buy-btn" href="single_product.php?product_id=<?php echo $row['product_id'];?>">Buy Now</a>
                        </div>
                    <?php } ?>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination mt-4">
                        <li class="Pag-item <?php if($page_no<=1){echo 'disabled';} ?>">
                        <a class="page-link" href="<?php if($page_no <= 1){echo "#";}else {echo "?page_no=".($page_no-1);} ?>">Previous</a>
                    </li>
                        <li class="Pag-item"><a class="page-link" href="?page_no=1">1</a></li>
                        <li class="Pag-item"><a class="page-link" href="?page_no=2">2</a></li>

                        <?php if($page_no>=3){?>
                        <li class="Pag-item"><a class="page-link" href="">...</a></li>
                        <li class="Pag-item"><a class="page-link" href="<?php echo "?page_no=".$page_no;?><?php echo $page_no; ?></a></li>
                        <?php } ?>
                        <li class="Pag-item <?php if($page_no>= $total_no_of_pages){echo 'disabled';}; ?>>
                        <a class="page-link" href="<?php if($page_no >=$total_no_of_pages ){echo "#";}else { echo "?page_no=".($page_no+1);} ?>">Next</a>
                    </li>
                    </ul>
                </nav>
            </section>
        </div>
    </div>
</div>

<?php include('layouts/footer.php')?>

</body>
</html>
