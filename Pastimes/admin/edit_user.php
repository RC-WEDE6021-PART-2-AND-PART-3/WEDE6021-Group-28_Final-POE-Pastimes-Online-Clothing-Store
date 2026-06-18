<?php
session_start();
require_once __DIR__ . '/../includes/DBConn.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/classes/User.php';

if (!isAdmin()) { header('Location: login.php'); exit; }

$u = new User($conn);
$id = isset($_GET['userID']) ? intval($_GET['userID']) : 0;
if ($id <= 0) { header('Location: users.php'); exit; }

$user = $u->getByID($id);
if (!$user) { header('Location: users.php'); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'fullName' => sanitizeInput($_POST['fullName'] ?? ''),
        'email' => sanitizeInput($_POST['email'] ?? ''),
        'username' => sanitizeInput($_POST['username'] ?? ''),
        'role' => sanitizeInput($_POST['role'] ?? 'customer'),
        'status' => sanitizeInput($_POST['status'] ?? 'active'),
        'phone' => sanitizeInput($_POST['phone'] ?? ''),
        'address' => sanitizeInput($_POST['address'] ?? ''),
        'city' => sanitizeInput($_POST['city'] ?? ''),
        'postalCode' => sanitizeInput($_POST['postalCode'] ?? '')
    ];

    if ($u->adminUpdate($id, $data)) {
        header('Location: users.php'); exit;
    } else {
        $msg = 'Failed to update user.';
    }
}

include 'includes/admin-header.php';
?>
<div style="padding:1.5rem;">
    <h1>Edit User #<?php echo $user['userID']; ?></h1>
    <?php if ($msg): ?><div class="alert alert-danger"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
    <form method="post" style="max-width:700px;">
        <div><label>Full name<br><input name="fullName" required class="form-input" value="<?php echo htmlspecialchars($user['fullName']); ?>"></label></div>
        <div><label>Email<br><input name="email" type="email" required class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>"></label></div>
        <div><label>Username<br><input name="username" required class="form-input" value="<?php echo htmlspecialchars($user['username']); ?>"></label></div>
        <div><label>Role<br><select name="role"><option value="customer" <?php echo $user['role']=='customer'?'selected':''; ?>>Customer</option><option value="seller" <?php echo $user['role']=='seller'?'selected':''; ?>>Seller</option><option value="admin" <?php echo $user['role']=='admin'?'selected':''; ?>>Admin</option></select></label></div>
        <div><label>Status<br><select name="status"><option value="active" <?php echo $user['status']=='active'?'selected':''; ?>>Active</option><option value="pending" <?php echo $user['status']=='pending'?'selected':''; ?>>Pending</option><option value="suspended" <?php echo $user['status']=='suspended'?'selected':''; ?>>Suspended</option></select></label></div>
        <div><label>Phone<br><input name="phone" class="form-input" value="<?php echo htmlspecialchars($user['phone']); ?>"></label></div>
        <div><label>Address<br><input name="address" class="form-input" value="<?php echo htmlspecialchars($user['address']); ?>"></label></div>
        <div><label>City<br><input name="city" class="form-input" value="<?php echo htmlspecialchars($user['city']); ?>"></label></div>
        <div><label>Postal Code<br><input name="postalCode" class="form-input" value="<?php echo htmlspecialchars($user['postalCode']); ?>"></label></div>
        <div style="margin-top:12px;"><button class="btn btn-primary" type="submit">Save Changes</button> <a href="users.php">Cancel</a></div>
    </form>
</div>

<?php include 'includes/admin-footer.php'; ?>
