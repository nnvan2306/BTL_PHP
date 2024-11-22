<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Sữa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script>
</script>

</head>

<body class="bg-gray-100">
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-lg font-bold">
                <a href="index.php">Shop Sữa</a>
            </div>

            <div class="flex">

                <div class="flex space-x-4">
                    <button class="bg-blue-800 p-2 rounded-lg btnAuth mx-3">
                        <a class="textAuth"></a>
                    </button>
                </div>
                <div class="auth">
                </div>
            </div>
        </div>
    </header>
    <main class="container mx-auto p-4">
        <section>
            <h2 class="text-2xl font-semibold mb-4">Khám phá sản phẩm của chúng tôi</h2>
            <div class="">
                <?php
                include './connect.php';
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                $records_per_page = 6; 
                
                $offset = ($page - 1) * $records_per_page;
                
                $query = "SELECT * FROM Sua LIMIT $records_per_page OFFSET $offset";
                $result = mysqli_query($conn, $query);
                ?>
                <div class="grid grid-cols-3 gap-4">

             <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg">
                            <img src="<?php echo $row["thumbnail"] ?>" alt="Product"
                                class="w-full h-48 object-cover mb-4 rounded-lg">
                            <h3 class="font-semibold line-clamp-1"><?php echo $row["title"] ?></h3>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-600"><?php echo $row["price"] ?></p>
                                <p class="text-gray-600"><?php echo $row["weight"] ?></p>
                            </div>
                            <a href="detail.php?sp=<?php echo $row["id"] ?>"
                                class="bg-blue-600 text-white p-2 rounded-lg mt-4 w-full block text-center">Xem Chi Tiết</a>
                        </div>

                <?php
                    }
                }?>
            </div>  
            
            <!-- pagination -->

            <div class="d-flex justify-center gap-1 mt-4">

                <?php

                $sql_count = "SELECT COUNT(*) AS total FROM Sua";
                $count_result = mysqli_query($conn, $sql_count);

                if ($count_result) {
                   $row_count = mysqli_fetch_assoc($count_result);
                    $total_records = $row_count['total'];

                   $records_per_page = 6;
                   $total_pages = ceil($total_records / $records_per_page);

        for ($page = 1; $page <= $total_pages; $page++) {
            echo '<div class="btnPage page-'.$page.' p-1 border-[1px] border-solid border-[#ccc] rounded-[10px] cursor-pointer hover:opacity-50 '.(isset($_GET['page']) && $_GET['page'] == $page ? "bg-[blue] text-[#fff]" : '').'">Trang ' . $page . '</div>';
        }
}
                ?>
</div>
            </div>     
</section>
    </main>
    <script>
    const isLogin = localStorage.getItem("isLogin");
    const isAdmin = localStorage.getItem("isAdmin");
    const textAuth = document.querySelector(".textAuth");
    const btnAuth = document.querySelector(".btnAuth");
    const authDiv = document.querySelector(".auth");

    if (textAuth) {
        if (isLogin === '1') {
            textAuth.textContent = "Đăng xuất";
            textAuth.href = "admin/index.php";  
        } else {
            textAuth.textContent = "Đăng nhập";
            textAuth.href = "admin/index.php"; 
        }
    }

    if (authDiv) {
        const userId = localStorage.getItem("userId");  
        if (userId) {
            const link = document.createElement("a");
            link.href = isAdmin === '1' ? "admin/dashboard.php" : `admin/account.php?userId=${userId}`;
            link.classList.add("btn-link");

            const newButton = document.createElement("button");
            newButton.textContent = isAdmin === '1' ? "Admin Control" : "Thông tin tài khoản";
            newButton.classList.add("bg-blue-500", "text-white", "px-4", "py-2", "rounded", "hover:bg-blue-700", "focus:outline-none", "focus:ring", "focus:ring-blue-300");
            newButton.classList.add("btnAdmin");

            link.appendChild(newButton);
            authDiv.appendChild(link);
        }
    }

    if (btnAuth) {
        btnAuth.addEventListener("click", () => {
            if (isLogin === '1') {
                localStorage.setItem("isLogin", "0");
                localStorage.setItem("isAdmin", "0");
                localStorage.setItem("userId", "0");
                window.location.href = "index.php";
            }
        });
    }

    const listBtn = document.querySelectorAll(".btnPage");
    listBtn.forEach(btn => {
        btn.addEventListener("click", function() {
            const page = this.classList.contains("btnPage") ? this.classList[1].split("-")[1] : null;

            if (page) {
                window.location.href = window.location.pathname + "?page=" + page;
            }
        });
    });
</script>

</body>



</html>