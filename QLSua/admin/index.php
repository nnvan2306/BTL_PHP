<?php
session_start();
include "../connect.php";

if (!empty($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $query = "SELECT * FROM user WHERE Email = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) < 1) {
        echo "<script>window.location.href = 'index.php?code=1';</script>";
    } else {
        $row = mysqli_fetch_assoc($result);
        
        if ($password === $row['Password']) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['MaKH'];  

            $isAdmin = $row['IsAdmin'] == 1 ? '1' : '0'; 
            echo "<script>
                    localStorage.setItem('isLogin', '1');
                    localStorage.setItem('userId', '{$row['MaKH']}');  // Lưu MaKH vào localStorage
                    localStorage.setItem('isAdmin', '$isAdmin');
                    window.location.href = 'index.php?code=0';  // Đăng nhập thành công
                  </script>";
        } else {
            echo "<script>window.location.href = 'index.php?code=2';</script>";
        }
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">
    <script>
        const isLoginLocal = localStorage.getItem("isLogin");
        const fullUrl = window.location.href.split("/admin/index.php")[0];
        if (isLoginLocal === '1') {
            window.location.href = fullUrl;
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="font-[sans-serif]">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
                <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">
                    <form class="space-y-4" method="POST">
                        <div class="mb-8">
                            <h3 class="text-gray-800 text-3xl font-extrabold text-center">Đăng Nhập</h3>
                            <p class="text-gray-500 text-sm mt-4 leading-relaxed text-center">Đăng nhập để quản lý sản phẩm</p>
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Email</label>
                            <div class="relative flex items-center">
                                <input name="username" type="text" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Enter user name" />
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Password</label>
                            <div class="relative flex items-center">
                                <input name="password" type="password" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Enter password" />
                            </div>
                        </div>
                        <div class="!mt-8">
                            <button class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none">
                                Đăng Nhập
                            </button>
                        </div>
                    </form>
                </div>
                <div class="lg:h-[650px] md:h-[300px] max-md:mt-8">
                    <img src="https://tomau.vn/wp-content/uploads/Tranh-To-Mau-Hop-Sua-Cute.jpg" class="w-full h-full max-md:w-4/5 mx-auto block object-cover" alt="Dining Experience" />
                </div>
            </div>
        </div>
    </div>
    <script>
        const code = window.location.search;
        if (code?.split("=") && code?.split("=").length > 0) {
            const codeSucc = code?.split("=")[1];
            if (codeSucc == "1") {
                Swal.fire({
                    title: "Thất Bại",
                    text: "Tài khoản của bạn không tồn tại trong hệ thống!",
                    icon: "info",
                    showConfirmButton: true,
                }).then(() => {
                    const url = new URL(window.location.href);
                    const param = 'code';
                    url.searchParams.delete(param);
                    window.history.pushState({}, document.title, url.toString());
                });
            }

            if (codeSucc == "2") {
                Swal.fire({
                    title: "Thất Bại",
                    text: "Xin lỗi mật khẩu của bạn nhập bị sai!",
                    icon: "info",
                    showConfirmButton: true,
                }).then(() => {
                    const url = new URL(window.location.href);
                    const param = 'code';
                    url.searchParams.delete(param);
                    window.history.pushState({}, document.title, url.toString());
                });
            }

            if (codeSucc == "0") {
                Swal.fire({
                    title: "Chúc Mừng",
                    text: "Bạn đã đăng nhập thành công!",
                    icon: "success",
                    showConfirmButton: true,
                }).then(() => {
                    window.location.href = window.location.href.split("admin/dashboard.php")[0];
                });
            }
        }
    </script>
</body>

</html>
