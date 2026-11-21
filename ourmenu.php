<?php 
  // 1. Sisipkan file db.php agar kita bisa mengobrol/mengakses database
  include 'db.php';
  // (Load semua produk — proses pemilahan/filter per kategori diurus oleh JavaScript di bawah nanti)
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Our Menus - Lumoo Coffee</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Permanent+Marker&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
  <style>
    /* ============================
       OUR MENU PAGE — THEME
    ============================ */

    /* HERO: Image Banner */
    .menu-hero {
      width: 100%;
      line-height: 0;
    }
    .menu-hero img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* POSTER SECTION */
    .poster-section {
      background: #f5ede0;
      padding: 48px 48px 36px;
    }

    .poster-row {
      display: flex;
      gap: 32px;
      justify-content: center;
      align-items: flex-start;
      flex-wrap: wrap;
    }

    .poster {
      width: 300px;
      border-radius: 4px;
      overflow: hidden;
      box-shadow: 0 20px 50px rgba(0,0,0,0.18);
      transition: transform 0.3s ease;
    }

    .poster:hover {
      transform: translateY(-6px) rotate(-1deg);
    }

    .poster.dark {
      filter: invert(1) hue-rotate(180deg);
    }

    .poster img {
      width: 100%;
      display: block;
    }

    /* FILTERS */
    .filters-wrap {
      background: #f5ede0;
      padding: 0 48px 42px;
      display: flex;
      justify-content: center;
    }

    .filters {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      justify-content: center;
      background: #fff;
      border-radius: 12px;
      padding: 8px;
      box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    }

    .filter-btn {
      display: inline-block;
      text-decoration: none;
      padding: 10px 26px;
      background: transparent;
      border: none;
      font-family: 'Nunito', sans-serif;
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
      border-radius: 8px;
      color: #5c3a22;
      transition: all 0.22s ease;
      letter-spacing: 0.3px;
    }

    .filter-btn:hover {
      background: #f4e8d3;
      color: #3d2514;
    }

    .filter-btn.active {
      background: #3d2514;
      color: #fff;
    }

    /* MENUS GRID SECTION */
    .menus-section {
      background: #c9b49a;
      padding: 56px 48px 72px;
    }

    .menus-section .section-inner {
      max-width: 1000px;
      margin: 0 auto;
    }

    .menus-section .section-title {
      font-family: 'Anton', sans-serif;
      font-size: 52px;
      letter-spacing: 3px;
      color: #fff;
      margin-bottom: 36px;
    }

    .menu-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
    }

    .menu-card {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 28px rgba(0,0,0,0.10);
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      display: flex;
      flex-direction: column;
    }

    .menu-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 40px rgba(0,0,0,0.15);
    }

    .menu-card-img {
      width: 100%;
      aspect-ratio: 4 / 3;
      overflow: hidden;
      background: #f0e6d8;
    }

    .menu-card-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform 0.4s ease;
    }

    .menu-card:hover .menu-card-img img {
      transform: scale(1.06);
    }

    .menu-card-body {
      padding: 18px 20px 22px;
      display: flex;
      flex-direction: column;
      flex: 1;
      gap: 6px;
    }

    .menu-card-body h3 {
      margin: 0;
      font-size: 18px;
      font-weight: 800;
      color: #2b1a0e;
      line-height: 1.2;
    }

    .menu-card-body .card-desc {
      font-size: 13px;
      color: #7a6555;
      line-height: 1.55;
      margin: 0;
      flex: 1;
    }

    .menu-card-bottom {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 12px;
    }

    .menu-card-price {
      font-size: 20px;
      font-weight: 800;
      color: #3d2514;
    }

    .menu-card-tag {
      display: inline-block;
      padding: 5px 12px;
      background: #f0e6d8;
      color: #7a5030;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Empty state */
    .menu-empty {
      grid-column: 1 / -1;
      text-align: center;
      color: rgba(255,255,255,0.8);
      font-size: 18px;
      font-weight: 600;
      padding: 40px 0;
    }

    /* === FILTER TRANSITION ANIMATIONS === */
    .menu-card {
      transition: opacity 0.35s ease, transform 0.35s ease;
    }

    /* State: card is hiding */
    .menu-card.is-hiding {
      opacity: 0;
      transform: scale(0.92);
      pointer-events: none;
    }

    /* State: card is hidden (display:none after animation) */
    .menu-card.is-hidden {
      display: none;
    }

    /* State: card is appearing */
    .menu-card.is-showing {
      opacity: 0;
      transform: scale(0.92);
    }

    /* Filter button pulse on click */
    .filter-btn.btn-pulse {
      animation: btnPulse 0.3s ease;
    }

    @keyframes btnPulse {
      0%   { transform: scale(1); }
      40%  { transform: scale(0.93); }
      100% { transform: scale(1); }
    }

    /* Page-load fade-in for cards */
    @keyframes cardFadeIn {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .menu-card {
      animation: cardFadeIn 0.5s ease both;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .menu-grid { grid-template-columns: repeat(2, 1fr); gap: 18px; }
      .poster-section, .filters-wrap, .menus-section { padding-left: 20px; padding-right: 20px; }
      .menus-section .section-title { font-size: clamp(32px, 6vw, 46px); margin-bottom: 24px; }
    }

    @media (max-width: 600px) {
      .poster-section { padding: 28px 16px 20px; }
      .poster { width: 88vw; max-width: 340px; }
      .filters-wrap { padding: 0 16px 28px; }
      .filters { width: 100%; gap: 6px; padding: 6px; }
      .filter-btn { flex: 1 1 auto; min-height: 44px; padding: 10px 14px; font-size: 13px; text-align: center; }
      .menus-section { padding: 36px 16px 52px; }
    }

    @media (max-width: 480px) {
      .menu-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
      .menu-card-body { padding: 12px 12px 14px; }
      .menu-card-body h3 { font-size: 15px; }
      .menu-card-body .card-desc { font-size: 12px; }
      .menu-card-bottom { flex-direction: column; align-items: flex-start; gap: 6px; }
      .menu-card-price { font-size: 16px; }
    }

    @media (max-width: 360px) {
      .menu-grid { grid-template-columns: 1fr; }
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
  <section class="menu-hero">
    <img src="img/Bannerourmenu.jpeg" alt="A Cup For Every Mood">
  </section>

  <!-- posters -->
  <section class="poster-section">
    <div class="poster-row">
      <!-- light version -->
      <div class="poster">
        <img src="img/menu.jpeg" alt="Lumoo Coffee Menu - Light">
      </div>
      <!-- Dark version -->
      <div class="poster dark">
        <img src="img/menu.jpeg" alt="Lumoo Coffee Menu - Dark">
      </div>
    </div>
  </section>

  <!-- filters -->
  <div class="filters-wrap">
    <div class="filters" id="filter-bar">
      <button class="filter-btn active" data-cat="all">All</button>
      <?php 
        $categories = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY FIELD(category_name, 'Coffee', 'Non Coffee', 'Sweet', 'Light') ASC, category_id ASC");
        while($c = mysqli_fetch_array($categories)){
      ?>
        <button class="filter-btn" data-cat="<?php echo $c['category_id'] ?>">
          <?php echo $c['category_name'] ?>
        </button>
      <?php } ?>
    </div>
  </div>

  <!-- our menus grid -->
  <section class="menus-section">
    <div class="section-inner">
      <h2 class="section-title">Our Menus</h2>
      <div class="menu-grid">
        <?php 
          // 2. Ambil semua data produk yang statusnya aktif (1), gabungkan sekalian dengan nama kategorinya
          $products = mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id) WHERE product_status = 1 ORDER BY product_id DESC");
          
          // 3. Cek apakah ada produk yang tersedia?
          if(mysqli_num_rows($products) > 0){
            $delay = 0;
            // 4. Keluarkan datanya satu per satu untuk dijadikan kartu-kartu menu
            while($p = mysqli_fetch_array($products)){
        ?>
            <article class="menu-card" 
              data-category="<?php echo $p['category_id'] ?>"
              style="animation-delay: <?php echo $delay * 0.07 ?>s">
              <div class="menu-card-img">
                <?php if(!empty($p['product_image'])): ?>
                  <img src="produk/<?php echo $p['product_image'] ?>" alt="<?php echo $p['product_name'] ?>">
                <?php else: ?>
                  <img src="img/menu.jpeg" alt="<?php echo $p['product_name'] ?>">
                <?php endif; ?>
              </div>
              <div class="menu-card-body">
                <h3><?php echo $p['product_name'] ?></h3>
                <p class="card-desc"><?php echo $p['product_description'] ?></p>
                <div class="menu-card-bottom">
                  <span class="menu-card-price"><?php echo number_format($p['product_price'], 0, ',', '.') ?></span>
                  <span class="menu-card-tag"><?php echo $p['category_name'] ?></span>
                </div>
              </div>
            </article>
        <?php 
              $delay++; 
            } 
          } else { 
        ?>
            <p class="menu-empty">No products found.</p>
        <?php } ?>
      </div>
    </div>
  </section>

  <script>
    const filterBar  = document.getElementById('filter-bar');
    const cards      = Array.from(document.querySelectorAll('.menu-card'));
    const ANIM_DURATION = 320; // ms — harus sesuai transition CSS

    filterBar.addEventListener('click', function(e) {
      const btn = e.target.closest('.filter-btn');
      if (!btn) return;

      // Aktifkan tombol
      filterBar.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      // Efek pulse pada tombol
      btn.classList.remove('btn-pulse');
      void btn.offsetWidth; // reflow untuk restart animasi
      btn.classList.add('btn-pulse');

      const cat = btn.dataset.cat;

      cards.forEach(card => {
        const match = cat === 'all' || card.dataset.category === cat;

        if (!match) {
          // Sembunyikan card yang tidak cocok
          if (!card.classList.contains('is-hidden')) {
            card.classList.add('is-hiding');
            setTimeout(() => {
              card.classList.add('is-hidden');
              card.classList.remove('is-hiding');
            }, ANIM_DURATION);
          }
        } else {
          // Tampilkan card yang cocok
          card.classList.remove('is-hidden', 'is-showing');
          // Paksa reflow biar animasi mulai dari 0
          void card.offsetWidth;
          card.classList.add('is-showing');
          requestAnimationFrame(() => {
            card.classList.remove('is-showing');
          });
        }
      });
    });
  </script>

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
