<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Permanent+Marker&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styleadmin.css">
    <title>Categories - Lumoo Admin</title>
    <style>
      .card-title { font-family: 'Anton', sans-serif; font-size: 26px; color: #251a0d; margin-bottom: 8px; }
      .top-actions { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:12px; }
      .top-actions a.add {
        background: #382814;
        color: #fff !important;
        padding: 10px 20px;
        text-decoration: none !important;
        border: 2px solid #251a0d;
        font-weight: 800;
        border-radius: 8px;
        font-family: 'Nunito', sans-serif;
        font-size: 15px;
        display: inline-block;
        transition: background 0.3s;
      }
      .top-actions a.add:hover {
        background: #251a0d;
      }
      .action-links a { text-decoration:none; margin-right:8px; border-radius:6px; }
      .action-links a.edit { background:#f0e6db; padding:6px 10px; border:2px solid #e0d1bf; color:#251a0d; font-weight:700; border-radius:6px; }
      .action-links a.delete { background:#ffecec; padding:6px 10px; border:2px solid #f5c6c6; color:#c0392b; font-weight:700; border-radius:6px; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Categories - Lumoo Admin</div>
        </div>

        <div class="sidebar">
            <div class="sidebar-title">LumooCoffee</div>
            <ul>
                <?php include 'sidebar.php'; ?>
            </ul>
        </div>

        <div class="section">
            <div class="top-actions">
              <div>
                <h2 class="card-title">Category Data</h2>
                <p class="muted">Manage product categories in your store</p>
              </div>
              <div><a href="kategori_tambah.php" class="add">Add Category</a></div>
            </div>

            <div class="admin-card">
            <table class="table1" width="100%">
                <tr>
                    <th style="width:6%;">No.</th>
                    <th>Category</th>
                    <th style="width:25%;">Action</th>
                </tr>

                <?php
                    $no = 1;
                    $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                    if(mysqli_num_rows($kategori) > 0){
                        while($row = mysqli_fetch_array($kategori)){
                ?>

                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td class="action-links">
                        <a class="edit" href="kategori_edit.php?id=<?php echo $row['category_id']; ?>">Edit</a>
                        <a class="delete" href="hapus_proses.php?idk=<?php echo $row['category_id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
                <?php } } else { ?>
                    <tr>
                         <td colspan="3">No Data Available</td>
                    </tr>
                <?php } ?>
            </table>
            </div>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>