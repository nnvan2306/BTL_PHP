<!-- <?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
?> -->

<script>
    localStorage.setItem("isLogin" , "0")
    localStorage.setItem("isAdmin", "0")
    localStorage.setItem("userId" , "0")
    window.location.hred="index.php"
</script>