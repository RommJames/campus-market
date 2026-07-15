<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>CampusMarket</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/components.css">
<link rel="stylesheet" href="assets/css/home.css">

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container py-5">

    <div class="hero">

        <h1>Marketplace for CIIT Students</h1>

        <p>
            Buy, sell, and exchange school essentials with fellow CIIT students.
        </p>

        <div class="search-box mt-4">

            <input
            type="text"
            class="form-control"
            placeholder="Search products...">

        </div>

    </div>

    <h3 class="mt-5 mb-4 fw-bold">
        Featured Listings
    </h3>

    <div class="row">

        <!-- Product 1 -->
        <div class="col-lg-4 col-md-6 mb-4">

            <div class="product-card">

                <img src="https://placehold.co/600x400"
                class="img-fluid">

                <div class="p-3">

                    <h5>MacBook Air M2</h5>

                    <p class="price">
                        ₱25,000
                    </p>

                    <button class="btn btn-primary-custom w-100">

                        View Details

                    </button>

                </div>

            </div>

        </div>

        <!-- Product 2 -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="product-card">

                <img src="https://placehold.co/600x400"
                class="img-fluid">

                <div class="p-3">

                    <h5>Drawing Tablet</h5>

                    <p class="price">
                        ₱3,500
                    </p>

                    <button class="btn btn-primary-custom w-100">

                        View Details

                    </button>

                </div>

            </div>

        </div>

        <!-- Product 3 -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="product-card">

                <img src="https://placehold.co/600x400"
                class="img-fluid">

                <div class="p-3">

                    <h5>Programming Books</h5>

                    <p class="price">
                        ₱900
                    </p>

                    <button class="btn btn-primary-custom w-100">

                        View Details

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>