<?php
session_start();
require_once __DIR__ . '/../includes/DBConn.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/classes/Clothing.php';

if (!isAdmin()) { header('Location: login.php'); exit; }

$cl = new Clothing($conn);
$id = isset($_GET['clothingID']) ? intval($_GET['clothingID']) : 0;
if ($id <= 0) { header('Location: listings.php'); exit; }

$item = $cl->getByID($id);
if (!$item) { header('Location: listings.php'); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title'] ?? '');
    $brand = sanitizeInput($_POST['brand'] ?? '');
    $category = sanitizeInput($_POST['category'] ?? '');
    $size = sanitizeInput($_POST['size'] ?? '');
    $condition = sanitizeInput($_POST['condition'] ?? 'good');
    $price = floatval($_POST['price'] ?? 0);
    $description = sanitizeInput($_POST['description'] ?? '');
    $status = sanitizeInput($_POST['status'] ?? $item['status']);

    $imagePath = $item['imagePath'];
    if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $orig = basename($_FILES['image']['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        $safe = preg_replace('/[^a-z0-9_.-]/i', '_', pathinfo($orig, PATHINFO_FILENAME));
        $destName = $safe . '_' . $id . '.' . $ext;
        $destPath = __DIR__ . '/../images/' . $destName;
        if (!is_dir(__DIR__ . '/../images')) mkdir(__DIR__ . '/../images', 0755, true);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $destPath)) {
            $imagePath = 'images/' . $destName;
        }
    }

    $data = [
        'title' => $title,
        'brand' => $brand,
        'category' => $category,
        'size' => $size,
        'condition' => $condition,
        'price' => $price,
        'description' => $description,
        'imagePath' => $imagePath,
        'suggestedPrice' => $price,
        'co2Saved' => $item['co2Saved'] ?? 3.00,
        'waterSaved' => $item['waterSaved'] ?? 2700,
        'status' => $status
    ];

    if ($cl->update($id, $data)) {
        header('Location: listings.php'); exit;
    } else {
        $msg = 'Failed to update item.';
    }
}

include 'includes/admin-header.php';
?>
<div style="padding:1.5rem;">
    <h1>Edit Listing #<?php echo $item['clothingID']; ?></h1>
    <?php if ($msg): ?><div class="alert alert-danger"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" style="max-width:700px;">
        <div><label>Title<br><input name="title" required class="form-input" value="<?php echo htmlspecialchars($item['title']); ?>"></label></div>
        <div><label>Brand<br><input name="brand" class="form-input" value="<?php echo htmlspecialchars($item['brand']); ?>"></label></div>
        <div><label>Category<br><input name="category" class="form-input" value="<?php echo htmlspecialchars($item['category']); ?>"></label></div>
        <div><label>Size<br><input name="size" class="form-input" value="<?php echo htmlspecialchars($item['size']); ?>"></label></div>
        <div><label>Condition<br><input name="condition" class="form-input" value="<?php echo htmlspecialchars($item['condition']); ?>"></label></div>
        <div><label>Price<br><input name="price" type="number" step="0.01" required class="form-input" value="<?php echo htmlspecialchars($item['price']); ?>"></label></div>
        <div><label>Description<br><textarea name="description" class="form-input"><?php echo htmlspecialchars($item['description']); ?></textarea></label></div>
        <div><label>Status<br><select name="status"><option value="pending" <?php echo $item['status']=='pending'?'selected':''; ?>>Pending</option><option value="approved" <?php echo $item['status']=='approved'?'selected':''; ?>>Approved</option><option value="rejected" <?php echo $item['status']=='rejected'?'selected':''; ?>>Rejected</option><option value="sold" <?php echo $item['status']=='sold'?'selected':''; ?>>Sold</option></select></label></div>
        <div><label>Image<br><?php if (!empty($item['imagePath'])): ?><img src="<?php echo image_url($item['imagePath']); ?>" alt="" style="height:80px; object-fit:cover; border:1px solid #ddd; padding:2px; display:block; margin-bottom:6px;" /><?php endif; ?><input type="file" name="image" accept="image/*"></label></div>
        <div style="margin-top:12px;"><button class="btn btn-primary" type="submit">Save Changes</button> <a href="listings.php">Cancel</a></div>
    </form>
</div>

<?php include 'includes/admin-footer.php'; ?>
