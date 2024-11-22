<?php
// Kết nối cơ sở dữ liệu
include '../connect.php';

$userId = isset($_GET['userId']) ? $_GET['userId'] : null;

// Nếu userId không tồn tại, chuyển hướng đến trang đăng nhập
if (!$userId) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit;
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$query = "SELECT * FROM user WHERE MaKH = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Cập nhật thông tin người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenKH = $_POST['TenKH'];
    $email = $_POST['Email'];
    $diaChi = $_POST['DiaChi'];
    $dienThoai = $_POST['DienThoai'];
    $gioiTinh = $_POST['GioiTinh'];

    $updateQuery = "UPDATE user SET TenKH = ?, Email = ?, DiaChi = ?, DienThoai = ?, GioiTinh = ? WHERE MaKH = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssssi", $tenKH, $email, $diaChi, $dienThoai, $gioiTinh, $userId);

    if ($updateStmt->execute()) {
        echo "<script>alert('Cập nhật thông tin thành công!');</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại. Vui lòng thử lại!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin tài khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-6 max-w-4xl">
        <div class="mb-6">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"><a href="../index.php" class="no-underline">Trang chủ</a></button>
        </div>
        <h1 class="text-2xl font-bold mb-4">Cập nhật thông tin tài khoản</h1>

        <?php if ($user): ?>
            <form action="account.php?userId=<?php echo $user['MaKH']; ?>" method="POST">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="TenKH" class="block text-sm font-medium text-gray-700">Tên khách hàng</label>
                        <input type="text" id="TenKH" name="TenKH" value="<?php echo htmlspecialchars($user['TenKH']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
                    </div>

                    <div>
                        <label for="Email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($user['Email']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
                    </div>

                    <div>
                        <label for="DiaChi" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                        <input type="text" id="DiaChi" name="DiaChi" value="<?php echo htmlspecialchars($user['DiaChi']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
                    </div>

                    <div>
                        <label for="DienThoai" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                        <input type="text" id="DienThoai" name="DienThoai" value="<?php echo htmlspecialchars($user['DienThoai']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
                    </div>

                    <div>
                        <label for="GioiTinh" class="block text-sm font-medium text-gray-700">Giới tính</label>
                        <select id="GioiTinh" name="GioiTinh" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                            <option value="Nam" <?php echo ($user['GioiTinh'] === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo ($user['GioiTinh'] === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Cập nhật thông tin</button>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <p class="text-red-500">Không tìm thấy thông tin người dùng.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
