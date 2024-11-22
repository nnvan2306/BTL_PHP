<?php
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

    if ($product_id <= 0 || $quantity <= 0) {
        echo "<script>
            alert('Dữ liệu không hợp lệ!');
            window.history.back();
        </script>";
        exit;
    }

    $query = "INSERT INTO cart (sua_id, quantity) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $product_id, $quantity);

    if ($stmt->execute()) {
        echo "<script>
            alert('Sản phẩm đã được thêm vào giỏ hàng!');
            const url = window.location.href.split('admin/addToCart.php')[0] + 'detail.php?sp=$product_id';
            window.location.href = url;
        </script>";
    } else {
        echo "<script>
            alert('Lỗi khi thêm sản phẩm vào giỏ hàng: " . $stmt->error . "');
            const url = window.location.href.split('admin/addToCart.php')[0] + 'detail.php?sp=$product_id';
            window.location.href = url;
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
        alert('Phương thức không được hỗ trợ!');
        window.history.back();
    </script>";
    exit;
}
?>
