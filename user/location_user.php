<?php 
// 1. Sertakan keamanan sesi (hanya yang sudah login yang bisa akses)
include 'session.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Location - Lumoo Coffee</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Permanent+Marker&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>" />
  <style>
    /* hero banner */
    .location-hero {
      width: 100%;
      line-height: 0;
      padding: 0;
    }
    .location-hero img {
      width: 100%;
      height: auto;
      display: block;
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
  <section class="location-hero">
    <img src="../img/Bannerlocation.png" alt="Coffee Shops Illustration">
  </section>

  <!-- location grid -->
  <section class="location-area">
    <div class="location-wrapper">
      <h2 class="location-section-title">Location</h2>
      <div class="location-grid">
        <article class="location-card">
          <img src="../location_img/Frame 1193.png" alt="Jl. Ahmad Yani Km. 5 No. 18" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="../location_img/Frame 1200.png" alt="Jl. Gatot Subroto No. 27" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="../location_img/Frame 1201.png" alt="Jl. Sultan Adam No. 14" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="../location_img/Frame 1202.png" alt="Jl. A. Yani Raya No. 32" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="../location_img/Frame 1203.png" alt="Jl. Veteran Komplek Harmoni No. 21" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="../location_img/Frame 1204.png" alt="Jl. Pramuka No. 9" style="width: 100%; display: block;">
        </article>
      </div>
    </div>
  </section>

  <!-- promo banner -->
  <section class="location-promo">
    <div class="location-promo-image">
      <img src="../img/Bannerfooterlocation.jpeg" alt="Cup of coffee" />
    </div>
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
