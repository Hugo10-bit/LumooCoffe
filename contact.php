<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lumoo Coffee - Contact</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Permanent+Marker&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
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

  <main class="contact-page">
    <section class="contact-hero">
      <div class="contact-hero-copy">
        <h1>Contact</h1>
        <p class="contact-hero-subtitle">We're ready to help you.</p>
        <p class="contact-hero-text">Contact us using the form or information below.</p>
      </div>
    </section>

    <div class="contact-divider"></div>

    <section class="contact-content">
      <div class="contact-left">
        <div class="contact-heading-wrap">
          <h2>GET IN TOUCH</h2>
        </div>

        <?php
          $admin = $conn ? mysqli_query($conn, "SELECT * FROM tb_admin WHERE level = 'admin' ORDER BY admin_id ASC LIMIT 1") : false;
          $a = ($admin && mysqli_num_rows($admin) > 0) ? mysqli_fetch_object($admin) : null;
          $adminEmail = $a ? htmlspecialchars($a->email) : 'lumoo_coffee@gmail.com';
          $adminTelpon = $a ? htmlspecialchars($a->telpon) : '081234567890';
        ?>

        <div class="contact-card">
          <div class="contact-icon">
            <img src="img/contact_email.png?v=1" alt="Email" style="width:24px;height:24px;object-fit:contain;">
          </div>
          <div>
            <p class="contact-label">Email</p>
            <p class="contact-detail"><?php echo $adminEmail; ?></p>
          </div>
        </div>

        <div class="contact-card">
          <div class="contact-icon">
            <img src="img/contact_phone.png?v=1" alt="Phone" style="width:24px;height:24px;object-fit:contain;">
          </div>
          <div>
            <p class="contact-label">Telephone/WhatsApp</p>
            <p class="contact-detail"><?php echo $adminTelpon; ?></p>
          </div>
        </div>

        <div class="contact-card">
          <div class="contact-icon">
            <img src="img/contact_clock.png?v=1" alt="Operational Time" style="width:24px;height:24px;object-fit:contain;">
          </div>
          <div>
            <p class="contact-label">Operational Time</p>
            <p class="contact-detail">Monday - Sunday : 08am - 09pm</p>
          </div>
        </div>

        <div class="contact-card">
          <div class="contact-icon">
            <img src="img/contact_instagram.png?v=1" alt="Instagram" style="width:24px;height:24px;object-fit:contain;">
          </div>
          <div>
            <p class="contact-label">Follow Us</p>
            <p class="contact-detail">@lumoo_coffee</p>
          </div>
        </div>
      </div>

      <div class="contact-right">
        <div class="contact-form-card">
          <h3>SEND US A MESSAGE</h3>
          <form action="" method="POST">
            <div class="contact-row">
              <input type="text" name="nama" placeholder="Full Name" required />
              <input type="email" name="email" placeholder="Email" required />
            </div>
            <input type="text" name="telepon" class="contact-full" placeholder="Phone Number" />
            <textarea name="pesan" placeholder="Your Message" required></textarea>
            <button type="submit" name="submit">Send a Message</button>
          </form>

          <?php 
            if(isset($_POST['submit'])){
              // 1. Ambil data pesan yang diketik pelanggan dari form kontak
              $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
              $email   = mysqli_real_escape_string($conn, $_POST['email']);
              $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
              $pesan   = mysqli_real_escape_string($conn, $_POST['pesan']);

              // 2. Simpan pesan tersebut ke tabel tb_message di database
              $insert = mysqli_query($conn, "INSERT INTO tb_message (nama, email, telepon, pesan) VALUES (
                '$nama',
                '$email',
                '$telepon',
                '$pesan'
              )");

              // 3. Tampilkan notifikasi sukses atau gagal
              if($insert){
                echo '<script>alert("Message sent successfully! Thank you."); window.location="contact.php";</script>';
              } else {
                echo 'Failed to send message: ' . mysqli_error($conn);
              }
            }
          ?>
        </div>
      </div>
    </section>
  </main>

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
              $ft_kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY FIELD(category_name, 'Coffee', 'Non Coffee', 'Sweet', 'Light') ASC, category_id ASC");
              
              // 2. Jika datanya ada (> 0), tampilkan satu per satu sebagai link tujuan (href)
              if(mysqli_num_rows($ft_kategori) > 0){
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
