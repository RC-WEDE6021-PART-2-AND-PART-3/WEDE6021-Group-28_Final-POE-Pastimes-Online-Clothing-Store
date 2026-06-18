<?php
session_start();
require_once __DIR__ . '/../includes/DBConn.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/classes/Clothing.php';

if (!isAdmin()) {
    header('Location: login.php'); exit;
}

$msg = '';
// fetch users for seller selection
$users = [];
$uRes = $conn->query("SELECT userID, fullName, username FROM tblUser ORDER BY fullName");
if ($uRes) {
    while ($r = $uRes->fetch_assoc()) $users[] = $r;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title'] ?? '');
    $brand = sanitizeInput($_POST['brand'] ?? '');
    $category = sanitizeInput($_POST['category'] ?? '');
    $size = sanitizeInput($_POST['size'] ?? '');
    $condition = sanitizeInput($_POST['condition'] ?? 'good');
    $price = floatval($_POST['price'] ?? 0);
    $description = sanitizeInput($_POST['description'] ?? '');

    // handle optional image upload
    $imagePath = '';
    if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $orig = basename($_FILES['image']['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        $safe = preg_replace('/[^a-z0-9_.-]/i', '_', pathinfo($orig, PATHINFO_FILENAME));
        $destName = $safe . '_' . time() . '.' . $ext;
        $destPath = __DIR__ . '/../images/' . $destName;
        if (!is_dir(__DIR__ . '/../images')) mkdir(__DIR__ . '/../images', 0755, true);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $destPath)) {
            $imagePath = 'images/' . $destName;
        }
    }

    $cl = new Clothing($conn);
    $selectedSeller = isset($_POST['sellerID']) ? (int)$_POST['sellerID'] : (isset($_SESSION['adminID']) ? (int)$_SESSION['adminID'] : 0);

    if ($selectedSeller <= 0) {
        $msg = 'Please select a valid seller for this listing.';
    } else {
        $data = [
            'sellerID' => $selectedSeller,
        'title' => $title,
        'brand' => $brand,
        'category' => $category,
        'size' => $size,
        'condition' => $condition,
        'price' => $price,
        'description' => $description,
        'imagePath' => $imagePath,
        'suggestedPrice' => $price
        ];

        $res = $cl->save($data);
        if ($res['success']) {
            header('Location: listings.php'); exit;
        } else {
            $msg = $res['message'];
        }
    }
}

include 'includes/admin-header.php';
?>
<?php
// Dropdown options for the form
$categoryOptions = ['tops','bottoms','dresses','outerwear','footwear','accessories','activewear'];
$sizeOptions = ['ONE SIZE','XS','S','M','L','XL','XXL','28','30','32','34','36','38','6','7','8','9','10'];
$conditionOptions = ['like new','good','fair'];
?>
<div style="padding:1.5rem;">
    <h1>Add Listing</h1>
    <?php if ($msg): ?><div class="alert alert-danger"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" style="max-width:700px;">
        <div>
            <label>Seller<br>
                <select name="sellerID" class="form-input" required>
                    <option value="">-- Select seller --</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?php echo $u['userID']; ?>" <?php echo (isset($selectedSeller) && $selectedSeller == $u['userID']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($u['fullName'] . ' (' . $u['username'] . ')'); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div><label>Title<br><input name="title" required class="form-input" value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>"></label></div>
        <div><label>Brand<br><input name="brand" class="form-input" value="<?php echo isset($brand) ? htmlspecialchars($brand) : ''; ?>"></label></div>
        <div>
            <label>Category<br>
                <select name="category" class="form-input" required>
                    <option value="">-- Select category --</option>
                    <?php foreach ($categoryOptions as $opt): ?>
                        <option value="<?php echo $opt; ?>" <?php echo (isset($category) && $category === $opt) ? 'selected' : ''; ?>><?php echo ucfirst($opt); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div>
            <label>Size<br>
                <select name="size" class="form-input" required>
                    <option value="">-- Select size --</option>
                    <?php foreach ($sizeOptions as $s): ?>
                        <option value="<?php echo $s; ?>" <?php echo (isset($size) && $size === $s) ? 'selected' : ''; ?>><?php echo $s; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div>
            <label>Condition<br>
                <select name="condition" class="form-input" required>
                    <option value="">-- Select condition --</option>
                    <?php foreach ($conditionOptions as $c): ?>
                        <option value="<?php echo $c; ?>" <?php echo (isset($condition) && $condition === $c) ? 'selected' : ''; ?>><?php echo ucfirst($c); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div><label>Price<br><input name="price" type="number" step="0.01" required class="form-input"></label></div>
        <div><label>Description<br><textarea name="description" class="form-input"></textarea></label></div>
        <div><label>Image<br><input type="file" name="image" accept="image/*"></label></div>
        <div style="margin-top:12px;"><button class="btn btn-primary" type="submit">Create Listing</button> <a href="listings.php">Cancel</a></div>
    </form>
</div>

<?php include 'includes/admin-footer.php'; ?>
