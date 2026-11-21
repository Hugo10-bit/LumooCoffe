<?php 
// 1. Sertakan keamanan sesi (hanya yang sudah login yang bisa akses)
include 'session.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - Lumoo Coffee</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Permanent+Marker&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>" />
  <style>
    /* about page styles */
    .about-hero {
      width: 100%;
      aspect-ratio: 16 / 9;
      max-height: 750px;
      overflow: hidden;
      line-height: 0;
    }
    .about-hero img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      display: block;
    }

    .mission { display: grid; grid-template-columns: 1fr 1fr; min-height: 450px; }
    .mission .col-left {
      background: #e6d5c0;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 50px;
    }
    .mission .col-left p {
      font-size: 32px;
      color: #3d2b1f;
      line-height: 1.7;
      text-align: center;
      max-width: 400px;
      font-weight: 700;
    }
    .mission .col-right { overflow: hidden; line-height: 0; }
    .mission .col-right img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .values { display: grid; grid-template-columns: 1fr 1fr; min-height: 500px; }
    .values .col-left { overflow: hidden; line-height: 0; }
    .values .col-left img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .values .col-right {
      background: #7a503a;
      color: #fff;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 30px;
    }
    .values .col-right p { font-size: 28px; line-height: 1.8; font-weight: 600; }

    .stats-row { background: #4b2c1d; padding: 60px 10%; display: flex; justify-content: center; gap: 30px; }
    .stat {
      background: #fff;
      padding: 25px;
      border-radius: 20px;
      text-align: center;
      flex: 1;
      max-width: 200px;
      box-shadow: 0 10px 0 #321d13;
    }
    .stat h3 { margin: 0; font-size: 42px; color: #3d2b1f; font-family: 'Anton', sans-serif; }
    .stat p { margin: 10px 0 0; color: #666; font-size: 14px; font-weight: 800; }

    @media (max-width: 900px) {
      .about-hero { aspect-ratio: 16 / 10; }
      .mission, .values { grid-template-columns: 1fr; min-height: auto; }
      .mission .col-left, .values .col-right { padding: 40px 24px; }
      .stats-row {
        padding: 40px 20px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
      }
      .stat { max-width: none; padding: 20px 14px; }
      .stat h3 { font-size: 34px; }
      .mission .col-left p { font-size: 22px; }
      .values .col-right p { font-size: 20px; }
    }
    @media (max-width: 480px) {
      .mission .col-left p { font-size: 18px; }
      .values .col-right p { font-size: 17px; }
    }
  </style>
</head>
<body>

  <!-- navbar -->
  <nav class="navbar">
    <a href="dashboard_user.php" class="nav-logo">
      <img src="../img/LumooCoffe.png" alt="Lumoo Coffee Logo">
    </a>
    <input type="checkbox" id="nav-toggle" class="nav-toggle" />
    <label for="nav-toggle" class="hamburger">
      <span></span><span></span><span></span>
    </label>

    <?php 
    // 2. Ambil nama file halaman saat ini untuk menandai menu navbar mana yang sedang menyala (aktif)
    $current = basename($_SERVER['PHP_SELF']); 
    ?>
    <ul class="nav-links">
      <li><a href="dashboard_user.php" class="<?= $current=='dashboard_user.php' ? 'active' : '' ?>">Home</a></li>
      <li><a href="aboutus_user.php"   class="<?= $current=='aboutus_user.php'   ? 'active' : '' ?>">About Us</a></li>
      <li><a href="ourmenu_user.php"   class="<?= $current=='ourmenu_user.php'   ? 'active' : '' ?>">Our Menu</a></li>
      <li><a href="location_user.php"  class="<?= $current=='location_user.php'  ? 'active' : '' ?>">Location</a></li>
      <li><a href="contact_user.php"   class="<?= $current=='contact_user.php'   ? 'active' : '' ?>">Contact</a></li>

    </ul>

    <div class="nav-user-dropdown" id="userDropdown">
      <button class="nav-user-btn" onclick="this.closest('.nav-user-dropdown').classList.toggle('open')">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        <span class="nav-username">Hi, <?php echo $user_row['nama']; ?></span>
        <svg class="nav-user-chevron" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round">
          <path d="M6 9l6 6 6-6"/>
        </svg>
      </button>
      <div class="nav-user-menu">
        <a href="logout_user.php" onclick="return confirm('Are you sure you want to logout?')" class="nav-user-menu-item">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" y1="12" x2="9" y2="12"/>
          </svg>
          Logout
        </a>
      </div>
    </div>
  </nav>

  <!-- hero -->
  <section class="about-hero">
    <img src="../img/Banneraboutus.png" alt="Hero Illustration">
  </section>

  <!-- mission -->
  <section class="mission">
    <div class="col-left">
      <p>To become a modern coffee brand that brings warmth, comfort, and meaningful connections through every experience.</p>
    </div>
    <div class="col-right">
      <img src="../img/Aboutusmisi.jpg" alt="Misi Lumoo">
    </div>
  </section>

  <!-- values -->
  <section class="values">
    <div class="col-left">
      <img src="../img/Aboutusvisi.png" alt="Visi Lumoo">
    </div>
    <div class="col-right">
      <p>Serving quality coffee with passion and consistency.</p>
      <p>Creating a cozy space for connection and comfort.</p>
      <p>Bringing people together through warm experiences.</p>
    </div>
  </section>

  <!-- stats -->
  <section class="stats-row">
    <?php $total_produk = (int) mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_product WHERE product_status = 1"))[0]; ?>
    <div class="stat"><h3><?php echo $total_produk; ?></h3><p>Available Products</p></div>
    <div class="stat"><h3>2023</h3><p>Established</p></div>
    <div class="stat"><h3>300+</h3><p>Happy Customers</p></div>
    <div class="stat"><h3>6</h3><p>Sales Locations</p></div>
  </section>

  <!-- footer -->
  <footer class="footer">
    <div class="footer-top">
      <div class="ft-menu">
        <div class="ft-logo"><img src="../img/LumooCoffe.png" alt="Lumoo Coffee Logo"></div>
        <p class="ft-slogan">By Light and Warmth</p>
      </div>
      <div class="ft-links">
        <div class="ft-col">
          <h4>Service</h4>
          <ul>
            <li><a href="contact_user.php">Contact Us</a></li>
            <li><a href="aboutus_user.php">About Us</a></li>
            <li><a href="location_user.php">Location</a></li>
          </ul>
        </div>
        <div class="ft-col">
          <h4>Menus</h4>
          <ul>
            <?php
              $ft_kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY FIELD(category_name, 'Coffee', 'Non Coffee', 'Sweet', 'Light') ASC, category_id ASC");
              while($fk = mysqli_fetch_array($ft_kategori)){
            ?>
              <li><a href="ourmenu_user.php?kat=<?php echo $fk['category_id'] ?>"><?php echo $fk['category_name'] ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="ft-copy"><p>&copy; 2026 Lumoo Coffee &nbsp; All Rights Reserved.</p></div>
  </footer>

  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>