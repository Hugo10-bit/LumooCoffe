<?php 
  // 1. Hubungkan ke database
  include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lumoo Coffee - Location</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Permanent+Marker&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
  <style>
    /* HERO: Image Banner */
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
    <a href="index.php" class="nav-logo">
      <img src="img/LumooCoffe.png" alt="Lumoo Coffee Logo">
    </a>
    <input type="checkbox" id="nav-toggle" class="nav-toggle" />
    <label for="nav-toggle" class="hamburger">
      <span></span><span></span><span></span>
    </label>

    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <ul class="nav-links">
      <li><a href="index.php"    class="<?= $current=='index.php'    ? 'active' : '' ?>">Home</a></li>
      <li><a href="aboutus.php"  class="<?= $current=='aboutus.php'  ? 'active' : '' ?>">About Us</a></li>
      <li><a href="ourmenu.php"  class="<?= $current=='ourmenu.php'  ? 'active' : '' ?>">Our Menu</a></li>
      <li><a href="location.php" class="<?= $current=='location.php' ? 'active' : '' ?>">Location</a></li>
      <li><a href="contact.php"  class="<?= $current=='contact.php'  ? 'active' : '' ?>">Contact</a></li>
    </ul>

    <a href="login.php" class="nav-user">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
    </a>
  </nav>

  <!-- location hero -->
  <section class="location-hero">
    <img src="img/Bannerlocation.png" alt="Coffee Shops Illustration">
  </section>

  <!-- location area -->
  <section class="location-area">
    <div class="location-wrapper">
      <h2 class="location-section-title">Location</h2>
      <div class="location-grid">
        <article class="location-card">
          <img src="location_img/Frame 1193.png" alt="Jl. Ahmad Yani Km. 5 No. 18" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="location_img/Frame 1200.png" alt="Jl. Gatot Subroto No. 27" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="location_img/Frame 1201.png" alt="Jl. Sultan Adam No. 14" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="location_img/Frame 1202.png" alt="Jl. A. Yani Raya No. 32" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="location_img/Frame 1203.png" alt="Jl. Veteran Komplek Harmoni No. 21" style="width: 100%; display: block;">
        </article>

        <article class="location-card">
          <img src="location_img/Frame 1204.png" alt="Jl. Pramuka No. 9" style="width: 100%; display: block;">
        </article>
      </div>
    </div>
  </section>

  <!-- location promo -->
  <section class="location-promo">
    <div class="location-promo-image">
      <img src="img/Bannerfooterlocation.jpeg" alt="Cup of coffee" />
    </div>
  </section>

  <!-- footer -->
  <footer class="footer">
    <div class="footer-top">
      <div class="ft-menu">
        <div class="ft-logo">
          <img src="img/LumooCoffe.png" alt="Lumoo Coffee Logo">
        </div>
        <p class="ft-slogan">By Light and Warmth</p>
      </div>

      <div class="ft-links">
        <div class="ft-col">
          <h4>Service</h4>
          <ul>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="location.php">Location</a></li>
          </ul>
        </div>
        <div class="ft-col">
          <h4>Menus</h4>
          <ul>
            <?php 
              // 1. Ambil seluruh data kategori dari database untuk dijadikan menu link otomatis di footer
              $ft_kategori = $conn ? mysqli_query($conn, "SELECT * FROM tb_category ORDER BY FIELD(category_name, 'Coffee', 'Non Coffee', 'Sweet', 'Light') ASC, category_id ASC") : false;
              
              // 2. Jika datanya ada (> 0), tampilkan satu per satu sebagai link tujuan (href)
              if($ft_kategori && mysqli_num_rows($ft_kategori) > 0){
                while($fk = mysqli_fetch_array($ft_kategori)){
            ?>
              <li><a href="ourmenu.php?kat=<?php echo $fk['category_id'] ?>"><?php echo $fk['category_name'] ?></a></li>
            <?php } } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="ft-copy">
      <p>&copy; 2026 Lumoo Coffee &nbsp; All Rights Reserved.</p>
    </div>
  </footer>
  <script src="app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
