Can<?php
include('../../config/session.php');
include('../../config/database.php');
include('../../includes/header.php');
include('../../includes/sidebar.php');

$user_id = $_SESSION['user_id'];
$message = "";

/* ==========================
   GET USER DATA
========================== */
$query = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

/* ==========================
   UPDATE PROFILE
========================== */
if (isset($_POST['update_profile'])) {

    $newImage  = $user['profile_image']; // default: keep old image
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $username  = mysqli_real_escape_string($conn, trim($_POST['username']));

    /* ✅ FIX: Handle image upload INSIDE post check */
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {

        $allowed  = ['jpg', 'jpeg', 'png', 'webp'];
        $fileName = $_FILES['profile_image']['name'];
        $tmpName  = $_FILES['profile_image']['tmp_name'];
        $fileSize = $_FILES['profile_image']['size'];
        $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $message = "<div class='alert alert-danger'>Invalid Image Format</div>";

        } elseif ($fileSize > 2097152) {
            $message = "<div class='alert alert-danger'>Image size must be less than 2MB</div>";

        } else {
            $uploadDir = '../../uploads/users/';

            // ✅ FIX: Check folder exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // ✅ FIX: Delete old image if exists
            if (!empty($user['profile_image']) && file_exists($uploadDir . $user['profile_image'])) {
                unlink($uploadDir . $user['profile_image']);
            }

            // ✅ FIX: Generate unique filename
            $newImage    = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
            $uploadPath  = $uploadDir . $newImage;

            if (!move_uploaded_file($tmpName, $uploadPath)) {
                $message  = "<div class='alert alert-danger'>Failed to upload image.</div>";
                $newImage = $user['profile_image']; // revert to old image
            }
        }
    }

    /* Check Duplicate Username */
    if (empty($message)) {
        $checkUser = mysqli_query($conn,
            "SELECT user_id FROM users WHERE username='$username' AND user_id != '$user_id'"
        );

        if (mysqli_num_rows($checkUser) > 0) {
            $message = "<div class='alert alert-danger'>Username already exists.</div>";

        } else {
            $updateQuery = "
                UPDATE users
                SET
                    full_name      = '$full_name',
                    username       = '$username',
                    profile_image  = '$newImage'
                WHERE user_id = '$user_id'
            ";
            if (mysqli_query($conn, $updateQuery)) {

                $_SESSION['full_name']     = $full_name;
                $_SESSION['username']      = $username;
                $_SESSION['profile_image'] = $newImage; // ✅ ADD THIS

                $message = "<div class='alert alert-success'>Profile Updated Successfully.</div>";
                 // ✅ Refresh user data
                $result = mysqli_query($conn, $query);
                $user   = mysqli_fetch_assoc($result);
            }
             else {
                $message = "<div class='alert alert-danger'>Failed to Update Profile. " . mysqli_error($conn) . "</div>";
            }
        }
    }
}

/* ✅ FIX: Build image path here, once */
$uploadDir  = '../../uploads/users/';
$imagePath  = (!empty($user['profile_image']) && file_exists($uploadDir . $user['profile_image']))
              ? $uploadDir . $user['profile_image']
              : '../../assets/images/default-avatar.png'; // fallback image
?>

<div class="main-content">
<div class="container-fluid">
<div class="row">
<div class="col-lg-8 mx-auto">
<div class="card shadow border-0">

    <div class="card-header bg-warning">
        <h4 class="mb-0">✏️ Edit Profile</h4>
    </div>

    <div class="card-body">

        <?php echo $message; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control"
                    value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                    value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Photo</label><br>
                <!-- ✅ FIX: $imagePath now properly defined -->
                <img src="<?php echo $imagePath; ?>"
                    class="rounded-circle border shadow"
                    width="120" height="120"
                    style="object-fit:cover;">
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <input type="file" name="profile_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                <small class="text-muted">Allowed: JPG, PNG, WEBP (Max 2MB)</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <input type="text" class="form-control" value="<?php echo $_SESSION['role']; ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Account Status</label>
                <input type="text" class="form-control" value="<?php echo $user['status']; ?>" readonly>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" name="update_profile" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Profile
                </button>
                <a href="my-profile.php" class="btn btn-secondary">Back</a>
            </div>

        </form>
    </div>
</div>
</div>
</div>
</div>
</div>

<?php include('../../includes/footer.php'); ?>