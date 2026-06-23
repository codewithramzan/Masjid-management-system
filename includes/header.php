<?php 
include(__DIR__ . '/../config/constants.php'); 
$username = $_SESSION['username'] ?? 'Admin';
$role     = $_SESSION['role']     ?? 'Administrator';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masjid Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">

    <style>
        body {
            margin: 0;
            padding-top: 70px;
        }

        .top-header {
            background: linear-gradient(90deg, #0b6b3a, #0f8f55);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
        }

        .brand {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-subtitle {
            font-size: 12px;
            opacity: 0.9;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .nav-menu a:hover {
            opacity: 0.8;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 15px;
        }

        /* ✅ FIX: Added missing CSS for profile image */
        .avatar-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
						object-fit:cover;
            /* border: 2px solid white; */
            flex-shrink: 0;
        }

        .profile-avatar {
            width: 100%;
            height: 100%;
            /* object-fit: cover; */
            display: block;
        }

        .user-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-text small {
            font-size: 11px;
            opacity: 0.8;
        }

        .logout {
            color: #ffd166 !important;
        }
    </style>
</head>
<body>

<div class="top-header">

    <!-- LEFT SIDE -->
    <div class="brand">
        <div class="brand-title">
            🕌 Masjid Management System
        </div>
        <div class="brand-subtitle">
            Financial & Donation Management Dashboard
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="nav-menu">

        <a href="<?php echo BASE_URL; ?>dashboard.php">
            📊 Dashboard
        </a>

        <a href="<?php echo BASE_URL; ?>modules/reports/index.php">
            <i class="fa fa-chart-line"></i> Reports
        </a>

        <a class="logout" href="<?php echo BASE_URL; ?>auth/logout.php">
            <i class="fa fa-right-from-bracket"></i> Logout
        </a>

        <!-- Profile -->
        <a href="<?php echo BASE_URL; ?>modules/users/my-profile.php" style="text-decoration:none;">

            <div class="user-box">

                <?php
                // ✅ FIX: Default image
                $profileImage = BASE_URL . 'assets/images/default-user.jpg';

                // ✅ FIX: Check session has profile_image AND file exists
                if (
                    !empty($_SESSION['profile_image']) &&
                    file_exists(__DIR__ . '/../uploads/users/' . $_SESSION['profile_image'])
                ) {
                    $profileImage = BASE_URL . 'uploads/users/' . $_SESSION['profile_image'];
                }
                ?>

                <div class="avatar-image">
                    <img
                        id="header-profile-image"
                        src="<?php echo $profileImage; ?>"
                        alt="Profile"
                        class="profile-avatar"
                        onerror="this.src='<?php echo BASE_URL; ?>assets/images/default-user.jpg'">
                </div>

                <div class="user-text">
                    <div><?php echo htmlspecialchars($username); ?></div>
                    <small><?php echo htmlspecialchars($role); ?></small>
                </div>

            </div>

        </a>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>