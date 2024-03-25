<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        .login-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .login-container h2 {
            text-align: center;
        }
        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .login-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Đăng nhập</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="Đăng nhập">
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "QL_NhanSu";
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }
    
    // Lấy dữ liệu từ form đăng nhập
    $username_input = $_POST['username'];
    $password_input = $_POST['password'];
    
    // Xây dựng truy vấn SQL để kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM user WHERE username='$username_input' AND password='$password_input'";
    $result = $conn->query($sql);
    
    // Kiểm tra số lượng bản ghi trả về từ truy vấn
    if ($result->num_rows > 0) {
        // Đăng nhập thành công
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        // Chuyển hướng đến trang tùy thuộc vào vai trò của người dùng
        if ($_SESSION['role'] === 'admin') {
            header("Location: index.php");
        } else {
            header("Location: user_index.php"); // Đây là trang tùy chỉnh cho người dùng có vai trò là user
        }
        exit(); // Kết thúc script sau khi chuyển hướng
    } else {
        // Đăng nhập không thành công
        echo "Đăng nhập không thành công. Vui lòng kiểm tra lại thông tin đăng nhập.";
    }
}
?>


</body>
</html>
