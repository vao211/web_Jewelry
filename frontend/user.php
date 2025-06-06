<?php
session_start();
include '../backend/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}


if ($_SESSION['role'] === 'admin') {
    header("Location: ../backend/index_admin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewelry Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="/favicon.png" type="image/x-icon">
</head>
<body>
    <div id="notification" class="notification" style="display: none;">notification</div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light-blue">
        <a class="navbar-brand" href="#">Jewelry Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../backend/profile.php">
                        <img src="../<?php echo htmlspecialchars($user['image']); ?>" alt="Avatar" width="30" height="30" class="rounded-circle">
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="../backend/order_history.php">Orders History</a></li>
                <li class="nav-item"><a class="nav-link" href="../backend/cart.php">Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="../backend/logout.php">Log out</a></li>
            </ul>
        </div>
    </nav>

    <!-- Carousel -->
    <div id="introCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/frontend/asset/slide1.jpg" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to Jewelry Store</h5>
                    <p>Discover the finest jewelry pieces.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/frontend/asset/slide2.jpg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Unique Designs</h5>
                    <p>Handcrafted jewelry with meticulous care.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/frontend/asset/slide3.png" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Special Offers</h5>
                    <p>Up to 20% off this week!</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#introCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#introCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mt-4">
        <h1>Products</h1>
        <form id="search-form" class="mb-4">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-3">
                    <input type="text" class="form-control" id="search" placeholder="Search..." name="search">
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <select class="form-control" id="category" name="category">
                        <option value="">All Categories</option>
                        <option value="1">Men's Fashion</option>
                        <option value="2">Women's Fashion</option>
                        <option value="3">Accessories</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 mb-3">
                    <input type="number" class="form-control" id="min-price" placeholder="Min cost" name="min_price">
                </div>
                <div class="col-md-2 col-sm-6 mb-3">
                    <input type="number" class="form-control" id="max-price" placeholder="Max cost" name="max_price">
                </div>
                <div class="col-md-2 col-sm-6 mb-3">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>
        <div class="row" id="product-list"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <?php include '../backend/footer.php'; ?>
</body>
</html>