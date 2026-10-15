<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/common/dbConnect.php';

$loginUsername = '';
$errors = [];
$successMessage = $_SESSION['register_success'] ?? '';
unset($_SESSION['register_success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginUsername = is_string($_POST['username'] ?? null)
        ? trim($_POST['username']) : '';
    $loginPassword = is_string($_POST['password'] ?? null)
        ? $_POST['password'] : '';

    if ($loginUsername === '' || trim($loginPassword) === '') {
        $errors[] = 'Vui lòng nhập tên đăng nhập và mật khẩu.';
    } elseif (mb_strlen($loginUsername, 'UTF-8') > 50
        || strlen($loginPassword) > 72 || str_contains($loginPassword, "\0")) {
        $errors[] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    } else {
        try {
            $stmt = $con->prepare(
                'SELECT id, username, password FROM users WHERE username = :username'
            );
            $stmt->execute([':username' => $loginUsername]);
            $user = $stmt->fetch();

            if ($user && password_verify($loginPassword, $user['password'])) {
                // Đổi ID phiên sau khi xác thực; không lưu mật khẩu vào session.
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int) $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: product_list.php', true, 303);
                exit;
            }

            $errors[] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
        } catch (PDOException $e) {
            error_log('Lỗi đăng nhập: ' . $e->getMessage());
            $errors[] = 'Không thể đăng nhập lúc này. Vui lòng thử lại.';
        }
    }
}

$pageTitle = 'Đăng nhập';
require __DIR__ . '/view/header.php';
?>

<h2>Đăng nhập</h2>

<?php if ($successMessage !== ''): ?>
    <p role="status"><?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <ul role="alert">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="login.php">
    <p>
        <label for="username">Tên đăng nhập:</label><br>
        <input type="text" id="username" name="username" maxlength="50" autocomplete="username" required
               value="<?= htmlspecialchars($loginUsername, ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" autocomplete="current-password" required>
    </p>
    <button type="submit">Đăng nhập</button>
    <a href="register.php">Đăng ký tài khoản</a>
</form>

<?php require __DIR__ . '/view/footer.php'; ?>
