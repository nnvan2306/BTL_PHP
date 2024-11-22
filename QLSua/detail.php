<?php
include './connect.php';

$product_id = isset($_GET['sp']) ? (int) $_GET['sp'] : 0;

// Lấy thông tin sản phẩm
$query = "SELECT * FROM sua WHERE id = $product_id";
$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found";
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .min-h-screen {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .flex-grow {
            flex: 1;
        }

        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 1rem;
            background-color: #f3f4f6;
            /* Màu nền nhạt */
        }

        .flex {
            display: flex;
            align-items: center;
        }

        .border {
            border: 1px solid #d1d5db;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .btnT,
        .btnG {
            cursor: pointer;
            font-size: 1.2rem;
            /* Kích thước chữ lớn hơn */
            padding: 0.5rem 1rem;
            /* Kích thước nút */
            transition: background-color 0.2s ease;
        }

        .inputQuantity {
            height: 2.5rem;
            /* Chiều cao khớp với các nút */
            font-size: 1rem;
            /* Kích thước chữ */
            max-width: 3rem;
            /* Giới hạn độ rộng */
            text-align: center;
            border-left: 1px solid #d1d5db;
            border-right: 1px solid #d1d5db;
        }

        .btnT:hover,
        .btnG:hover {
            background-color: #f3f4f6;
            /* Màu nền hover */
        }

        footer {
            text-align: center;
            background-color: #2563eb;
            color: white;
            padding: 1rem;
        }
    </style>

</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-blue-600 text-white p-4 w-full">
            <div class="container mx-auto">
                <h1 class="text-lg font-bold">
                    <a href="index.php" class="hover:text-blue-200">Shop Sữa Chất Lượng Cao</a>
                </h1>
            </div>
        </header>

        <!-- Nội dung chính -->
        <main class="flex-grow container mx-auto">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex flex-wrap md:flex-nowrap gap-6">
                    <!-- Hình ảnh sản phẩm -->
                    <div class="w-full md:w-1/2">
                        <img src="<?php echo htmlspecialchars($product['thumbnail']); ?>"
                            alt="<?php echo htmlspecialchars($product['title']); ?>"
                            class="object-cover w-full h-96 rounded-lg border">
                    </div>

                    <!-- Thông tin sản phẩm -->
                    <div class="w-full md:w-1/2">
                        <h1 class="text-3xl font-semibold text-gray-900 mb-4">
                            <?php echo htmlspecialchars($product['title']); ?>
                        </h1>
                        <p class="text-2xl font-bold text-red-500 mb-4">$<?php echo number_format($product['price'], 2); ?></p>

                        <!-- Cân nặng và trạng thái -->
                        <div class="flex items-center mb-4">
                            <p class="text-gray-600">Weight: <?php echo number_format($product['weight'], 2); ?> kg</p>
                            <?php if ($product['is_active']): ?>
                                <span class="ml-4 px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">In Stock</span>
                            <?php else: ?>
                                <span class="ml-4 px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded">Out of Stock</span>
                            <?php endif; ?>
                        </div>

                        <form action="admin/addToCart.php" method="POST">
                            <div class="flex items-center gap-4 mb-6">
                                <p class="text-lg font-medium">Số lượng:</p>

                                <div class="flex items-center border rounded-lg">
                                    <button type="button" class="btnT bg-white text-gray-700">-</button>
                                    <input type="number" name="quantity" value="1" min="1"
                                        class="inputQuantity focus:ring-2 focus:ring-blue-300">
                                    <button type="button" class="btnG bg-white text-gray-700">+</button>
                                </div>
                            </div>

                            <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-all">
                                Đặt hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        const userId = localStorage.getItem("userId")
        const input = document.querySelector(".inputUserId");
        if (input) {
            input.value = userId
        }
        const btnT = document.querySelector(".btnT");
        const btnG = document.querySelector(".btnG");
        const inputQuantity = document.querySelector(".inputQuantity");

        btnT.addEventListener("click", () => {
            if (+inputQuantity.value > 1) {
                inputQuantity.value = +inputQuantity.value - 1;
            }
        });

        btnG.addEventListener("click", () => {
            inputQuantity.value = +inputQuantity.value + 1;
        });
    </script>
</body>

</html>