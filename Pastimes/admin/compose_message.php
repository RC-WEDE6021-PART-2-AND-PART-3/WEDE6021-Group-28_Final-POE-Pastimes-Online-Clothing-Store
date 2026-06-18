<?php
session_start();
require_once __DIR__ . '/../includes/DBConn.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isAdmin()) { header('Location: login.php'); exit; }

$receiverID = isset($_GET['receiver']) ? (int)$_GET['receiver'] : 0;
$clothingID = isset($_GET['clothingID']) ? (int)$_GET['clothingID'] : null;
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiverID = (int)($_POST['receiver_id'] ?? 0);
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $messageBody = sanitizeInput($_POST['message'] ?? '');
    $clothingID = isset($_POST['clothing_id']) ? (int)$_POST['clothing_id'] : null;

    if ($receiverID && $messageBody) {
        try {
            // Ensure we have a valid sender user for admin messages. Use or create a system user.
            $sysUsername = 'system_user';
            $sysEmail = 'system@pastimes.local';
            $senderID = null;
            $sstmt = $conn->prepare('SELECT userID FROM tblUser WHERE username = ? LIMIT 1');
            if ($sstmt) {
                $sstmt->bind_param('s', $sysUsername);
                $sstmt->execute();
                $res = $sstmt->get_result();
                $row = $res->fetch_assoc();
                if ($row) {
                    $senderID = (int)$row['userID'];
                }
                $sstmt->close();
            }

            if (!$senderID) {
                // create the system user
                $passHash = md5(uniqid('sys', true));
                $istmt = $conn->prepare('INSERT INTO tblUser (fullName, email, username, passwordHash, role, status) VALUES (?, ?, ?, ?, ?, ?)');
                if ($istmt) {
                    $full = 'System';
                    $role = 'buyer';
                    $status = 'active';
                    $istmt->bind_param('ssssss', $full, $sysEmail, $sysUsername, $passHash, $role, $status);
                    $istmt->execute();
                    $senderID = $conn->insert_id;
                    $istmt->close();
                }
            }

            if (!$senderID) {
                throw new Exception('Unable to determine sender user for admin message.');
            }

            $stmt = $conn->prepare("INSERT INTO tblMessages (senderID, receiverID, clothingID, subject, messageBody, isRead, sentAt) VALUES (?, ?, ?, ?, ?, 0, NOW())");
            $stmt->bind_param('iiiss', $senderID, $receiverID, $clothingID, $subject, $messageBody);
            $stmt->execute();
            $inserted = $conn->insert_id;
            $stmt->close();

            if (function_exists('appendDataFile')) {
                appendDataFile('messagesData.txt', [
                    'action' => 'create',
                    'messageID' => (int)$inserted,
                    'senderID' => (int)$senderID,
                    'receiverID' => (int)$receiverID,
                    'clothingID' => $clothingID ? (int)$clothingID : null,
                    'subject' => $subject,
                    'messageBody' => $messageBody,
                    'isRead' => 0,
                    'sentAt' => date('c')
                ]);
            }

            header('Location: orders.php'); exit;
        } catch (Exception $e) {
            $msg = 'Failed to send message.';
        }
    } else {
        $msg = 'Receiver and message body are required.';
    }
}

// Fetch receiver details
$receiver = null;
if ($receiverID) {
    $stmt = $conn->prepare('SELECT userID, fullName, email FROM tblUser WHERE userID = ?');
    $stmt->bind_param('i', $receiverID);
    $stmt->execute();
    $receiver = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

include 'includes/admin-header.php';
?>
<div style="padding:1.5rem; max-width:800px;">
    <h1>Compose Message</h1>
    <?php if ($msg): ?><div class="alert alert-danger"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
    <form method="post">
        <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($receiverID); ?>">
        <input type="hidden" name="clothing_id" value="<?php echo htmlspecialchars($clothingID); ?>">
        <div style="margin-bottom:10px;"><label>To<br><input class="form-input" value="<?php echo $receiver ? htmlspecialchars($receiver['fullName']) : ''; ?>" disabled></label></div>
        <div style="margin-bottom:10px;"><label>Subject<br><input name="subject" class="form-input" value="Regarding your order" required></label></div>
        <div style="margin-bottom:10px;"><label>Message<br><textarea name="message" class="form-input" required rows="6">Hello, please confirm the item condition and delivery details. Admin will follow up to ensure correct delivery.</textarea></label></div>
        <div><button class="btn btn-primary" type="submit">Send Message</button> <a href="orders.php">Cancel</a></div>
    </form>
</div>

<?php include 'includes/admin-footer.php'; ?>
