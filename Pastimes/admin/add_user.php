<?php
session_start();
require_once __DIR__ . '/../includes/DBConn.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isAdmin()) { header('Location: login.php'); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = sanitizeInput($_POST['fullName'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = sanitizeInput($_POST['role'] ?? 'customer');

    if (empty($password) || strlen($password) < 6) {
        $msg = 'Password is required (min 6 chars).';
    } else {
        $hash = hashPassword($password);
        $stmt = $conn->prepare("INSERT INTO tblUser (fullName, email, username, passwordHash, role, status) VALUES (?, ?, ?, ?, ?, 'active')");
        $stmt->bind_param('sssss', $fullName, $email, $username, $hash, $role);
        if ($stmt->execute()) {
            header('Location: users.php'); exit;
        } else {
            $msg = 'Failed to create user. Username or email may already exist.';
        }
    }
}

include 'includes/admin-header.php';
?>
<div style="padding:1.5rem;">
    <h1>Add User</h1>
    <?php if ($msg): ?><div class="alert alert-danger"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
    <form method="post" style="max-width:600px;">
        <div><label>Full name<br><input name="fullName" required class="form-input"></label></div>
        <div><label>Email<br><input name="email" type="email" required class="form-input"></label></div>
        <div><label>Username<br><input name="username" required class="form-input"></label></div>
        <div><label>Password<br><input name="password" type="password" required class="form-input"></label></div>
        <div><label>Role<br><select name="role"><option value="customer">Customer</option><option value="seller">Seller</option><option value="admin">Admin</option></select></label></div>
        <div style="margin-top:12px;"><button class="btn btn-primary" type="submit">Create User</button> <a href="users.php">Cancel</a></div>
    </form>
</div>

<?php include 'includes/admin-footer.php'; ?>
