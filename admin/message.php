<?php 
include 'session.php'; 
$messages = get_admin_messages($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages | Lumoo Admin</title>
    <link rel="stylesheet" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Customer Messages</div>
            <div style="font-size: 14px; font-weight: 600; color: #8e6c4e;">
                <i class="fas fa-inbox"></i> Total: <strong><?php echo count($messages); ?></strong> Messages
            </div>
        </div>
        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include 'sidebar.php';?>
            </ul>
        </div>
        <div class="section">
            <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h2>Customer Inquiries & Feedback</h2>
                    <p>Read questions, feedback, and catering requests sent via website contact form.</p>
                </div>
                <?php if (!$conn): ?>
                <div style="background: #fff8e6; border: 1px solid #ffeeba; color: #856404; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-info-circle"></i> Preview Mode (Cloud Database Disconnected)
                </div>
                <?php endif; ?>
            </div>
            
            <div class="message-cards-container">
                <?php
                if (!empty($messages)) {
                    foreach ($messages as $row) {
                        $dateFormatted = !empty($row['created_at']) ? date('d M Y, H:i', strtotime($row['created_at'])) : 'Recent';
                ?>
                <div class="message-card">
                    <div class="msg-header">
                        <div>
                            <h4 class="msg-sender"><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($row['nama']); ?></h4>
                        </div>
                        <span class="msg-date"><i class="far fa-clock"></i> <?php echo $dateFormatted; ?></span>
                    </div>
                    
                    <div class="msg-contact">
                        <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></span>
                        <span><i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($row['telepon']); ?></span>
                    </div>
                    
                    <div class="msg-body">
                        <?php echo nl2br(htmlspecialchars($row['pesan'])); ?>
                    </div>
                    
                    <div class="msg-actions">
                        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="reply-btn" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; background:#f5ede0; color:#382814; padding:8px 14px; border-radius:8px; font-size:13px; font-weight:700;">
                            <i class="fas fa-reply"></i> Reply via Email
                        </a>
                        <a href="hapus_proses.php?idc=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this message?')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </div>
                </div>
                <?php 
                    }
                } else {
                ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #fff; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <i class="fas fa-inbox" style="font-size: 48px; color: #d4c2b2; margin-bottom: 15px; display: block;"></i>
                    <h3 style="margin: 0 0 8px; color: #382814;">No Messages Yet</h3>
                    <p style="color: #7f8c8d; margin: 0; font-size: 14px;">Messages sent through the Contact Us page will appear here.</p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
