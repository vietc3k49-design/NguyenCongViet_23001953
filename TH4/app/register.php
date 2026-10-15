<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/common/dbConnect.php';

$registerUsername = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registerUsername = is_string($_POST['username'] ?? null)
        ? trim($_POST['username']) : '';
    $registerPassword = is_string($_POST['password'] ?? null)
        ? $_POST['password'] : '';

    if ($registerUsername === '') {
        $errors[] = 'Tên đăng nhập không được để trống.';
    } elseif (mb_strlen($registerUsername, 'UTF-8') > 50) {
        $errors[] = 'Tên đăng nhập không được vượt quá 50 ký tự.';
    }

    if (trim($registerPassword) === '') {
        $errors[] = 'Mật khẩu không được để trống.';
    } elseif (str_contains($registerPassword, "\0") || strlen($registerPassword) > 72) {
        // Bcrypt giới hạn 72 byte; không để mật khẩu bị cắt ngầm.
        $errors[] = 'Mật khẩu không được chứa ký tự null hoặc vượt quá 72 byte.';
    }

    if (empty($errors)) {
        try {
            $stmt = $con->prepare('SELECT id FROM users WHERE username = :username');
            $stmt->execute([':username' => $registerUsername]);

            if ($stmt->fetch()) {
                $errors[] = 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.';
            } else {
                $passwordHash = password_hash($registerPassword, PASSWORD_DEFAULT);
                $stmt = $con->prepare(
                    'INSERT INTO users (username, password) VALUES (:username, :password)'
                );
                $stmt->execute([
                    ':username' => $registerUsername,
                    ':password' => $passwordHash,
                ]);

                // Trang login.php sẽ đọc, hiển thị và xóa thông báo này.
                $_SESSION['register_success'] = 'Đăng ký thành công. Bạn có thể đăng nhập.';
                header('Location: login.php', true, 303);
                exit;
            }
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                $errors[] = 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.';
            } else {
                error_log('Lỗi đăng ký: ' . $e->getMessage());
                $errors[] = 'Không thể đăng ký tài khoản. Vui lòng thử lại.';
            }
        }
    }
}

$pageTitle = 'Đăng ký tài khoản';
require __DIR__ . '/view/header.php';
?>

<h2>Đăng ký tài khoản</h2>

<?php if (!empty($errors)): ?>
    <ul role="alert">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="register.php">
    <p>
        <label for="username">Tên đăng nhập:</label><br>
        <input type="text" id="username" name="username" maxlength="50" autocomplete="username" required
               value="<?= htmlspecialchars($registerUsername, ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" autocomplete="new-password" required>
    </p>
    <button type="submit">Đăng ký</button>
    <a href="login.php">Đăng nhập</a>
</form>

<?php require __DIR__ . '/view/footer.php'; ?>
