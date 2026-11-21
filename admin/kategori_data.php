<?php 
include 'session.php'; 
$kategori = get_admin_categories($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Categories | Lumoo Admin</title>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Menu Categories</div>
            <div style="font-size: 14px; font-weight: 600; color: #8e6c4e;">
                <i class="fas fa-tags"></i> Total: <strong><?php echo count($kategori); ?></strong> Categories
            </div>
        </div>

        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include 'sidebar.php'; ?>
            </ul>
        </div>

        <div class="section">
            <div class="top-actions">
              <div>
                <h2 class="card-title">Category Management</h2>
                <p class="muted">Manage and organize coffee and beverage menu categories.</p>
              </div>
              <div style="display:flex; gap:10px; align-items:center;">
                <?php if (!$conn): ?>
                <span class="preview-badge"><i class="fas fa-database"></i> Demo Mode</span>
                <?php endif; ?>
                <a href="kategori_tambah.php" class="add"><i class="fas fa-plus-circle"></i> Add Category</a>
              </div>
            </div>

            <div class="admin-card">
              <table class="table1" width="100%">
                <thead>
                  <tr>
                    <th style="width: 8%;">No.</th>
                    <th style="width: 15%;">Icon</th>
                    <th>Category Name</th>
                    <th>Category ID</th>
                    <th style="width: 20%; text-align: right;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if (!empty($kategori)) {
                      foreach ($kategori as $row) {
                          $catName = htmlspecialchars($row['category_name']);
                          $icon = 'fa-tag';
                          $pillClass = 'cat-pill-coffee';
                          if (stripos($catName, 'Coffee') !== false && stripos($catName, 'Non') === false) {
                              $icon = 'fa-coffee';
                              $pillClass = 'cat-pill-coffee';
                          } elseif (stripos($catName, 'Non') !== false) {
                              $icon = 'fa-leaf';
                              $pillClass = 'cat-pill-noncoffee';
                          } elseif (stripos($catName, 'Sweet') !== false) {
                              $icon = 'fa-cookie-bite';
                              $pillClass = 'cat-pill-sweet';
                          } elseif (stripos($catName, 'Light') !== false) {
                              $icon = 'fa-utensils';
                              $pillClass = 'cat-pill-light';
                          }
                  ?>
                  <tr>
                    <td><strong><?php echo $no++; ?></strong></td>
                    <td>
                      <div class="cat-icon-circle <?php echo $pillClass; ?>">
                        <i class="fas <?php echo $icon; ?>"></i>
                      </div>
                    </td>
                    <td>
                      <span class="cat-name-highlight"><?php echo $catName; ?></span>
                    </td>
                    <td>
                      <code style="background:#f1ede8; padding:3px 8px; border-radius:6px; color:#5c3a22; font-weight:700;">#<?php echo htmlspecialchars($row['category_id']); ?></code>
                    </td>
                    <td style="text-align: right;">
                      <div class="action-links" style="justify-content: flex-end;">
                        <a class="edit" href="kategori_edit.php?id=<?php echo $row['category_id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                        <a class="delete" href="hapus_proses.php?idk=<?php echo $row['category_id']; ?>" onclick="return confirm('Are you sure you want to delete category <?php echo addslashes($catName); ?>?')"><i class="fas fa-trash-alt"></i> Delete</a>
                      </div>
                    </td>
                  </tr>
                  <?php 
                      }
                  } else { 
                  ?>
                  <tr>
                    <td colspan="5" style="text-align:center; padding:40px; color:#7f8c8d;">
                      <i class="fas fa-tags" style="font-size:36px; color:#d0c1b4; display:block; margin-bottom:10px;"></i>
                      No categories found.
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
