<?php
// Khởi động phiên
session_start();

// Hủy bỏ tất cả các biến phiên
$_SESSION = array();

// Xóa phiên cookie nếu có
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy bỏ phiên
session_destroy();

// Chuyển hướng người dùng đến trang đăng nhập
header("Location: login.php");
exit;
?>
