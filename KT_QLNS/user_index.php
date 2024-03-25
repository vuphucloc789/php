<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <h1>THÔNG TIN NHÂN VIÊN</h1>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php

// Kiểm tra xem người dùng đã đăng nhập hay chưa (có thể kiểm tra thông qua session hoặc cookie)
// Nếu chưa đăng nhập, bạn có thể chuyển hướng người dùng đến trang đăng nhập

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "QL_NhanSu"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}


$page_number = isset($_GET['page']) ? $_GET['page'] : 1;
$items_per_page = 5; 
$start_index = ($page_number - 1) * $items_per_page;

$query = "SELECT nv.Ma_NV, nv.Ten_NV, nv.Phai, nv.Noi_Sinh, pb.Ten_Phong, nv.Luong 
          FROM NhanVien nv
          LEFT JOIN PhongBan pb ON nv.Ma_Phong = pb.Ma_Phong 
          LIMIT $start_index, $items_per_page";
$result = $conn->query($query);

echo "<table>";
echo "<tr><th>Mã NV</th><th>Tên NV</th><th>Giới tính</th><th>Nơi Sinh</th><th>Tên Phòng</th><th>Lương</th></tr>";
while ($row = $result->fetch_assoc()) {
    $ma_nv = $row['Ma_NV'];
    $ten_nv = $row['Ten_NV'];
    $phai = $row['Phai'];
    $noi_sinh = $row['Noi_Sinh'];
    $ten_phong = $row['Ten_Phong'];
    $luong = $row['Luong'];
    if ($phai == 'NAM') {
        $gender = 'Nam';
        $gender_image = 'image/man.png';
    } else {
        $gender = 'Nữ';
        $gender_image = 'image/woman.png';
    }

    echo "<tr>";
    echo "<td>$ma_nv</td>";
    echo "<td>$ten_nv</td>";
    echo "<td><img src='$gender_image' alt='$phai'> $gender</td>";

    echo "<td>$noi_sinh</td>";
    echo "<td>$ten_phong</td>";
    echo "<td>$luong</td>";
    echo "</tr>";
}
echo "</table>";

// Hiển thị link phân trang
$total_rows_query = "SELECT COUNT(*) as total FROM NhanVien";
$total_rows_result = $conn->query($total_rows_query);
$total_rows = $total_rows_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $items_per_page);
echo "<br>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='?page=$i'>$i</a> ";
}

// Nút đăng xuất
echo "<br><br>";
echo "<a href='logout.php'><button>Đăng xuất</button></a>";



// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>
</body>
</html>
