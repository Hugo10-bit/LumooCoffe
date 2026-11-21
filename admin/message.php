<?php include 'session.php'; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Admin</title>
    <link rel="stylesheet" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Messages</div>
        </div>
        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include 'sidebar.php';?>
            </ul>
        </div>
        <div class="section">
            <div class="dashboard-header">
                <h2>Incoming Messages</h2>
                <p>Read and manage messages from your customers.</p>
            </div>
            
            <div class="message-cards-container">
                <?php
                $messages = mysqli_query($conn, "SELECT * FROM tb_message ORDER BY id DESC");
                if (mysqli_num_rows($messages) > 0) {
                    while ($row = mysqli_fetch_array($messages)) {
                ?>
                <div class="message-card">
                    <div class="msg-header">
                        <div>
                            <h4 class="msg-sender"><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($row['nama']); ?></h4>
                        </div>
                        <span class="msg-date"><?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></span>
                    </div>
                    
                    <div class="msg-contact">
                        <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></span>
                        <span><i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($row['telepon']); ?></span>
                    </div>
                    
                    <div class="msg-body">
                        <?php echo nl2br(htmlspecialchars($row['pesan'])); ?>
                    </div>
                    
                    <div class="msg-actions">
                        <a href="hapus_proses.php?idc=<?php echo $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this message?')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </div>
                </div>
                <?php 
                    }
                } else {
                ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b; font-size: 16px; font-weight: 500;">
                    <i class="fas fa-inbox" style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px; display: block;"></i>
                    No incoming messages at the moment.
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>

