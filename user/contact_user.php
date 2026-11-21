<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact - Lumoo Coffee</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Permanent+Marker&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>" />
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

    <?php $current = basename($_SERVER['PHP_SELF']); ?>
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
          <span></span>
        </div>

        <?php
          $admin = mysqli_query($conn, "SELECT * FROM tb_admin WHERE level = 'admin' ORDER BY admin_id ASC LIMIT 1");
          $a = mysqli_fetch_object($admin);
        ?>

        <div class="contact-card">
          <div class="contact-icon">
            <img src="../img/contact_email.png?v=1" alt="Email" style="width:24px;height:24px;object-fit:contain;">
          </div>
          <div>
            <p class="contact-label">Email</p>
            <p class="contact-detail"><?php echo $a->email ?></p>
          </div>
        </div>

        <div class="contact-card">
          <div class="contact-icon">
            <img src="../img/contact_phone.png?v=1" alt="Phone" style="width:24px;height:24px;object-fit:contain;">
          </div>
          <div>
            <p class="contact-label">Telephone/WhatsApp</p>
            <p class="contact-detail"><?php echo $a->telpon ?></p>
          </div>
        </div>

        <div class="contact-card">
          <div class="contact-icon">
            <img src="../img/contact_clock.png?v=1" alt="Operational Time" style="width:24px;height:24px;object-fit:contain;">
          </div>
          <div>
            <p class="contact-label">Operational Time</p>
            <p class="contact-detail">Monday - Sunday : 08am - 09pm</p>
          </div>
        </div>

        <div class="contact-card">
          <div class="contact-icon">
            <img src="../img/contact_instagram.png?v=1" alt="Instagram" style="width:24px;height:24px;object-fit:contain;">
          </div>
          <div>
            <p class="contact-label">Follow Us</p>
            <p class="contact-detail">@lumoo_coffee</p>
          </div>
        </div>
      </div>

      <div class="contact-right">
        <div class="contact-form-card">
          <h3>SEND US A MESSAGES</h3>
          <form action="" method="POST">
            <div class="contact-row">
              <input type="text" name="nama" placeholder="Full Name" value="<?php echo $user_row['nama'] ?>" required />
              <input type="email" name="email" placeholder="Email" value="<?php echo $user_row['email'] ?>" required />
            </div>
            <input type="text" name="telepon" class="contact-full" placeholder="Phone Number" value="<?php echo $user_row['telpon'] ?>" />
            <textarea name="pesan" placeholder="Your Messages" required></textarea>
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
                echo '<script>alert("Message sent successfully! Thank you."); window.location="contact_user.php";</script>';
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
