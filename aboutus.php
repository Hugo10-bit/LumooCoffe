<?php
  // Hubungkan ke database (disiapkan jika nanti butuh ambil data dinamis)
  include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - Lumoo Coffee</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Permanent+Marker&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
  <style>
    /* ============================
       ABOUT PAGE — SPECIFIC STYLES
    ============================ */

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
      border-radius: 0;
    }

    /* Mission */
    .mission {
      display: grid;
      grid-template-columns: 1fr 1fr;
      min-height: 450px;
    }

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

    .mission .col-right {
      overflow: hidden;
      line-height: 0;
    }

    .mission .col-right img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    /* Values */
    .values {
      display: grid;
      grid-template-columns: 1fr 1fr;
      min-height: 500px;
    }

    .values .col-left {
      overflow: hidden;
      line-height: 0;
    }

    .values .col-left img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .values .col-right {
      background: #7a503a;
      color: #fff;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 30px;
    }

    .values .col-right p {
      font-size: 28px;
      line-height: 1.8;
      font-weight: 600;
    }

    /* Stats */
    .stats-row {
      background: #4b2c1d;
      padding: 60px 10%;
      display: flex;
      justify-content: center;
      gap: 30px;
    }

    .stat {
      background: #fff;
      padding: 25px;
      border-radius: 20px;
      text-align: center;
      flex: 1;
      max-width: 200px;
      box-shadow: 0 10px 0 #321d13;
    }

    .stat h3 {
      margin: 0;
      font-size: 42px;
      color: #3d2b1f;
      font-family: 'Anton', sans-serif;
    }

    .stat p {
      margin: 10px 0 0;
      color: #666;
      font-size: 14px;
      font-weight: 800;
    }

    /* Gallery */
    .gallery-strip {
      width: 100%;
      background: #f6efe6;
      line-height: 0;
      overflow: hidden;
    }

    .gallery-grid { width: 100%; }

    .gallery-grid img {
      width: 100%;
      height: auto;
      max-height: 400px;
      object-fit: cover;
      display: block;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .about-hero { aspect-ratio: 16 / 10; }
      .mission,
      .values {
        grid-template-columns: 1fr;
        min-height: auto;
      }

      .mission .col-left,
      .values .col-right {
        padding: 40px 24px;
      }

      .stats-row {
        padding: 40px 20px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
      }

      .stat {
        max-width: none;
        padding: 20px 14px;
      }

      .stat h3 { font-size: 34px; }

      .mission .col-left p { font-size: 22px; }
      .values .col-right p { font-size: 20px; }
    }

    @media (max-width: 480px) {
      .mission .col-left p { font-size: 18px; }
      .values .col-right p { font-size: 17px; gap: 18px; }
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

  <!-- hero -->
  <section class="about-hero">
    <img src="img/Banneraboutus.jpg" alt="Hero Illustration">
  </section>

  <!-- mission -->
  <section class="mission">
    <div class="col-left">
      <p>To become a modern coffee brand that brings warmth, comfort, and meaningful connections through every experience.</p>
    </div>
    <div class="col-right">
      <img src="img/Aboutusmisi.jpg" alt="Misi Lumoo">
    </div>
  </section>

  <!-- values -->
  <section class="values">
    <div class="col-left">
      <img src="img/Aboutusvisi.png" alt="Visi Lumoo">
    </div>
    <div class="col-right">
      <p>Serving quality coffee with passion and consistency.</p>
      <p>Creating a cozy space for connection and comfort.</p>
      <p>Bringing people together through warm experiences.</p>
    </div>
  </section>

  <!-- stats -->
  <section class="stats-row">
    <?php $total_produk = $conn ? (int) mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_product WHERE product_status = 1"))[0] : 18; ?>
    <div class="stat"><h3><?php echo $total_produk; ?></h3><p>Available Products</p></div>
    <div class="stat"><h3>2023</h3><p>Established</p></div>
    <div class="stat"><h3>300+</h3><p>Happy Customers</p></div>
    <div class="stat"><h3>6</h3><p>Sales Locations</p></div>
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