<?php 
include 'session.php'; 

// Fetch statistics
$prod_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_product");
$prod_data = mysqli_fetch_assoc($prod_query);
$total_products = $prod_data['total'];

$cat_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_category");
$cat_data = mysqli_fetch_assoc($cat_query);
$total_categories = $cat_data['total'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styleadmin.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Dashboard Overview</div>
        </div>
        
        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include 'sidebar.php'; ?>
            </ul>
        </div>

        <div class="section">
            <div class="dashboard-header">
                <h2>Welcome, <?php echo htmlspecialchars($user_row["admin_name"] ?? $user_row["nama"]); ?>! 👋</h2>
                <p>This is the main control page for managing LumooCoffee website content.</p>
            </div>

            <div class="dashboard-cards">
                <!-- Card 1 -->
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-coffee"></i>
                    </div>
                    <div class="card-info">
                        <h3><?php echo $total_products; ?></h3>
                        <p>Total Products</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="card-info">
                        <h3><?php echo $total_categories; ?></h3>
                        <p>Total Categories</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>