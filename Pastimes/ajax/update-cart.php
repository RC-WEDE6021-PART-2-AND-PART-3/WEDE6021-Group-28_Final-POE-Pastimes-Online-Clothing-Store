<?php
// ajax/update-cart.php — AJAX handler for updating/removing cart items

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$action = isset($_POST['action']) ? $_POST['action'] : '';
$clothingID = isset($_POST['clothing_id']) ? intval($_POST['clothing_id']) : 0;

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if ($action === 'remove') {
    if ($clothingID > 0 && array_key_exists($clothingID, $_SESSION['cart'])) {
        unset($_SESSION['cart'][$clothingID]);
        // Recalculate totals
        $subtotal = 0.0;
        $serviceFeesTotal = 0.0;
        foreach ($_SESSION['cart'] as $it) {
            $subtotal += ($it['price'] * $it['qty']);
            $serviceFeesTotal += 15 * $it['qty'];
        }
        $grandTotal = $subtotal + $serviceFeesTotal;

        echo json_encode([
            'success' => true,
            'message' => 'Item removed.',
            'cartCount' => getCartCount(),
            'subtotal' => $subtotal,
            'serviceFeesTotal' => $serviceFeesTotal,
            'grandTotal' => $grandTotal,
            'itemRemoved' => $clothingID
        ]);
        exit;
    }
    echo json_encode(['success' => false, 'message' => 'Item not found in cart.']);
    exit;
} elseif ($action === 'update') {
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    if ($clothingID > 0 && $quantity > 0 && array_key_exists($clothingID, $_SESSION['cart'])) {
        $_SESSION['cart'][$clothingID]['qty'] = $quantity;

        // Calculate item total and cart totals
        $itemTotal = $_SESSION['cart'][$clothingID]['price'] * $quantity;
        $subtotal = 0.0;
        $serviceFeesTotal = 0.0;
        foreach ($_SESSION['cart'] as $it) {
            $subtotal += ($it['price'] * $it['qty']);
            $serviceFeesTotal += 15 * $it['qty'];
        }
        $grandTotal = $subtotal + $serviceFeesTotal;

        echo json_encode([
            'success' => true,
            'message' => 'Quantity updated.',
            'cartCount' => getCartCount(),
            'itemTotal' => $itemTotal,
            'subtotal' => $subtotal,
            'serviceFeesTotal' => $serviceFeesTotal,
            'grandTotal' => $grandTotal,
            'itemUpdated' => $clothingID
        ]);
        exit;
    }
    echo json_encode(['success' => false, 'message' => 'Invalid update parameters.']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Unknown action.']);
exit;
