<?php
  // 1. Sertakan file session.php untuk memastikan hanya user yang sudah login yang bisa membuka halaman ini
  include 'session.php';
  
  // 2. Ambil maksimal 4 produk terlaris dari database untuk ditampilkan di halaman utama
  $produk_bestseller = mysqli_query($conn, "SELECT * FROM tb_product
    WHERE product_status = 1 AND is_bestseller > 0
    ORDER BY is_bestseller DESC
    LIMIT 4");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home - Lumoo Coffee</title>
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

    <?php 
    // 3. Ambil nama file halaman saat ini untuk menandai menu navbar mana yang sedang aktif (menyala)
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

  <!-- hero slider -->
  <section class="hero">
    <div class="hero-slider">
      <div class="slide active">
        <img src="../img/Banner1.jpeg" alt="Lumoo Coffee Cup Banner">
      </div>
      <div class="slide">
        <img src="../img/Banner2.png" alt="Lumoo Coffee Menu Banner">
      </div>
    </div>
    <button class="slide-btn prev" aria-label="Previous slide">‹</button>
    <button class="slide-btn next" aria-label="Next slide">›</button>
    <div class="dots">
      <span class="dot active" data-slide="0"></span>
      <span class="dot" data-slide="1"></span>
    </div>
  </section>

  <!-- about -->
  <section class="about" id="about">
    <div class="about-left">
      <div class="about-illus">
        <img src="../img/about1.png" alt="Lumoo Coffee Photo">
      </div>
    </div>
    <div class="about-right">
      <h2>Helloo, We are Lumoo</h2>
      <p>a warm space crafted to light up your everyday through coffee, conversations, and little moments that turn into something meaningful.</p>
    </div>
  </section>

  <!-- best seller -->
  <section class="bestseller" id="menu">
    <h2 class="bs-title">BEST SELLER</h2>
    <div class="product-grid">
      <?php if(mysqli_num_rows($produk_bestseller) > 0){
          while($p = mysqli_fetch_array($produk_bestseller)){
            $description = str_ireplace("Chiken wings", "Chicken wings", $p['product_description']);
      ?>
          <div class="product-card">
            <div class="p-img">
              <img src="../produk/<?php echo $p['product_image'] ?>" alt="<?php echo $p['product_name'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="p-info">
              <h3 class="p-name"><?php echo $p['product_name'] ?></h3>
              <p class="p-desc"><?php echo $description; ?></p>
              <div class="p-price-row">
                <span class="p-price"><?php echo number_format($p['product_price'], 0, ',', '.') ?></span>
              </div>
            </div>
          </div>
      <?php } } else { ?>
          <p style="text-align: center; width: 100%; color: white;">No products available.</p>
      <?php } ?>
    </div>
    <a href="ourmenu_user.php" class="load-btn">View All Menu</a>
  </section>

  <!-- mading -->
  <section class="mading" id="location">
    <div class="mading-inner">
      <img src="../img/mading.jpg" alt="mading">
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
              // 4. Ambil seluruh data kategori dari database untuk dijadikan menu link otomatis di footer
              $ft_kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY FIELD(category_name, 'Coffee', 'Non Coffee', 'Sweet', 'Light') ASC, category_id ASC");
              
              // 5. Keluarkan satu per satu sebagai link
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

  <script>
    const slider = document.querySelector('.hero-slider');
    const slides = Array.from(document.querySelectorAll('.slide'));
    const dots = Array.from(document.querySelectorAll('.dot'));
    const prevBtn = document.querySelector('.slide-btn.prev');
    const nextBtn = document.querySelector('.slide-btn.next');
    let currentIndex = 0;
    let startX = 0;
    let isDragging = false;

    function updateSlider(index) {
      currentIndex = (index + slides.length) % slides.length;
      slider.style.transform = `translateX(-${currentIndex * 100}%)`;
      dots.forEach((dot, i) => dot.classList.toggle('active', i === currentIndex));
    }

    nextBtn.addEventListener('click', () => updateSlider(currentIndex + 1));
    prevBtn.addEventListener('click', () => updateSlider(currentIndex - 1));
    dots.forEach(dot => dot.addEventListener('click', () => updateSlider(Number(dot.dataset.slide))));

    slider.addEventListener('touchstart', e => { startX = e.touches[0].clientX; isDragging = true; });
    slider.addEventListener('touchmove', e => {
      if (!isDragging) return;
      const touchX = e.touches[0].clientX;
      if (Math.abs(touchX - startX) > 40) {
        touchX < startX ? updateSlider(currentIndex + 1) : updateSlider(currentIndex - 1);
        isDragging = false;
      }
    });
    slider.addEventListener('touchend', () => { isDragging = false; });

    setInterval(() => updateSlider(currentIndex + 1), 7000);
  </script>

  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>