<?php
  include 'db.php';

  $bestseller_list = get_app_bestsellers($conn, 4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home - Lumoo Coffee</title>
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

  <!-- hero slider -->
  <section class="hero">
    <div class="hero-slider">
      <div class="slide active">
        <img src="img/Banner1.jpeg" alt="Lumoo Coffee Cup Banner">
      </div>
      <div class="slide">
        <img src="img/Banner2.png" alt="Lumoo Coffee Menu Banner">
      </div>
    </div>

    <button class="slide-btn prev" aria-label="Previous slide">‹</button>
    <button class="slide-btn next" aria-label="Next slide">›</button>

    <div class="dots">
      <span class="dot active" data-slide="0"></span>
      <span class="dot" data-slide="1"></span>
    </div>
  </section>

  <!-- about section -->
  <section class="about" id="about">
    <div class="about-left">
      <div class="about-illus">
        <img src="img/about2.png" alt="Lumoo Coffee Photo">
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
      <?php if (!empty($bestseller_list)): ?>
        <?php foreach ($bestseller_list as $p): ?>
          <?php
            // Memperbaiki typo "Chiken" menjadi "Chicken" secara otomatis
            $description = str_ireplace("Chiken wings", "Chicken wings", $p['product_description']);
          ?>
          <div class="product-card">
            <div class="p-img">
              <img src="produk/<?php echo htmlspecialchars($p['product_image']); ?>" alt="<?php echo htmlspecialchars($p['product_name']); ?>" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div class="p-info">
              <h3 class="p-name"><?php echo htmlspecialchars($p['product_name']); ?></h3>
              <p class="p-desc"><?php echo htmlspecialchars($description); ?></p>
              <div class="p-price-row">
                <span class="p-price"><?php echo number_format($p['product_price'], 0, ',', '.'); ?></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;width:100%;color:white;grid-column:1/-1;">No products available at the moment.</p>
      <?php endif; ?>
    </div>
    <a href="ourmenu.php" class="load-btn">View All Menu</a>
  </section>

  <!-- mading / promo -->
  <section class="mading" id="location">
    <div class="mading-inner">
      <img src="img/mading.jpg" alt="mading">
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
              $ft_kategori = get_app_categories($conn);
              if(!empty($ft_kategori)){
                foreach($ft_kategori as $fk){
            ?>
              <li><a href="ourmenu.php?kat=<?php echo $fk['category_id'] ?>"><?php echo htmlspecialchars($fk['category_name']) ?></a></li>
            <?php } } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="ft-copy">
      <p>&copy; 2026 Lumoo Coffee &nbsp; All Rights Reserved.</p>
    </div>
  </footer>

  <script>
    const slider    = document.querySelector('.hero-slider');
    const slides    = Array.from(document.querySelectorAll('.slide'));
    const dots      = Array.from(document.querySelectorAll('.dot'));
    const prevBtn   = document.querySelector('.slide-btn.prev');
    const nextBtn   = document.querySelector('.slide-btn.next');
    let currentIndex = 0;
    let startX       = 0;
    let isDragging   = false;

    function updateSlider(index) {
      currentIndex = (index + slides.length) % slides.length;
      slider.style.transform = `translateX(-${currentIndex * 100}%)`;
      dots.forEach((dot, dotIndex) => {
        dot.classList.toggle('active', dotIndex === currentIndex);
      });
    }

    function nextSlide() { updateSlider(currentIndex + 1); }
    function prevSlide() { updateSlider(currentIndex - 1); }

    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    dots.forEach((dot) => {
      dot.addEventListener('click', () => updateSlider(Number(dot.dataset.slide)));
    });

    slider.addEventListener('touchstart', (e) => {
      startX     = e.touches[0].clientX;
      isDragging = true;
    });

    slider.addEventListener('touchmove', (e) => {
      if (!isDragging) return;
      const touchX = e.touches[0].clientX;
      if (Math.abs(touchX - startX) > 40) {
        touchX < startX ? nextSlide() : prevSlide();
        isDragging = false;
      }
    });

    slider.addEventListener('touchend', () => { isDragging = false; });

    // auto-play setiap 7 detik
    setInterval(nextSlide, 7000);
  </script>
  <script src="app.js?v=<?php echo time(); ?>" defer></script>

</body>
</html>