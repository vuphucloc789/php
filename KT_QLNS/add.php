<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QL_NhanSu";

// Xử lý khi người dùng gửi biểu mẫu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }
    
    $ma_nv = $_POST['ma_nv'];
    $ten_nv = $_POST['ten_nv'];
    $phai = $_POST['phai'];
    $noi_sinh = $_POST['noi_sinh'];
    $ma_phong = $_POST['ma_phong'];
    $luong = $_POST['luong'];

    $sql = "INSERT INTO NhanVien (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong)
            VALUES ('$ma_nv', '$ten_nv', '$phai', '$noi_sinh', '$ma_phong', '$luong')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm nhân viên thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<h2>Thêm nhân viên mới</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Mã nhân viên: <input type="text" name="ma_nv"><br><br>
    <!-- Các trường thông tin khác -->
    
   
    Tên nhân viên: <input type="text" name="ten_nv"><br><br>
    Giới tính: 
    <select name="phai">
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
    </select><br><br>
    Nơi sinh: <input type="text" name="noi_sinh"><br><br>
    Mã phòng: <input type="text" name="ma_phong"><br><br>
    Lương: <input type="text" name="luong"><br><br>
    <input type="submit" value="Thêm nhân viên">
</form>