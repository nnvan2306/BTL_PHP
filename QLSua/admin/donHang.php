<?php
include '../connect.php';

$query_cart_items = "
    SELECT 
        cart.id as cart_id, 
        sua.title, 
        sua.price, 
        cart.quantity, 
        (sua.price * cart.quantity) as total_price,
        user.Email, 
        user.DiaChi,
        user.TenKH, 
        user.DienThoai, 
        user.GioiTinh
    FROM cart
    INNER JOIN sua ON cart.sua_id = sua.id
    INNER JOIN user ON cart.user_id = user.MaKH";
$result_cart_items = $conn->query($query_cart_items);

if ($result_cart_items->num_rows > 0) {
    $user_info = $result_cart_items->fetch_assoc(); 
} else {
    $user_info = null; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Danh sách đơn hàng</h1>

        <?php if ($user_info): ?>
            <div class="mb-4">
            </div>
        <?php else: ?>
            <p class="text-red-500">Không tìm thấy thông tin người dùng hoặc giỏ hàng.</p>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b">#</th>
                        <th class="py-2 px-4 border-b">Tên sản phẩm</th>
                        <th class="py-2 px-4 border-b">Giá</th>
                        <th class="py-2 px-4 border-b">Số lượng</th>
                        <th class="py-2 px-4 border-b">Tổng giá</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Địa chỉ</th>
                        <th class="py-2 px-4 border-b">Điện thoại</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result_cart_items->data_seek(0); 
                    while ($row = $result_cart_items->fetch_assoc()): ?>
                        <tr class="border-b">
                            <td class="py-2 px-4"><?php echo $row['cart_id']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['title']; ?></td>
                            <td class="py-2 px-4"><?php echo number_format($row['price'], 0, ',', '.'); ?> VND</td>
                            <td class="py-2 px-4"><?php echo $row['quantity']; ?></td>
                            <td class="py-2 px-4"><?php echo number_format($row['total_price'], 0, ',', '.'); ?> VND</td>
                            <td class="py-2 px-4"><?php echo $row['Email']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['DiaChi']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['DienThoai']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
