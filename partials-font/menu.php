<?php include('config/constants.php');
include('login-check.php');
$session_user = ""; // Khởi tạo biến session_user

if (isset($_GET['session_user'])) {
    $session_user = $_GET['session_user']; // Lấy giá trị session_user từ URL nếu tồn tại
}
$sql_s = "SELECT * FROM khach_hang WHERE ten_nguoi_dung='$session_user'";
$res_s = mysqli_query($conn, $sql_s);
$row_s = mysqli_fetch_assoc($res_s);
$count_s = mysqli_num_rows($res_s);
if ($count_s == 1) {
    //Have data
    $id_us = $row_s['id'];
} else {
    //No data
}
?>

<!DOCTYPE html>
<html lang="en">


<?php
$sql = "SELECT * FROM gio_hang WHERE user_id=$id_us";
$res = mysqli_query($conn, $sql);

$count = mysqli_num_rows($res);
?>

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nông sản</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <!-- Navbar Section Ends Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="<?php echo SITEURL; ?>index.php?session_user=<?php echo $_SESSION['user']; ?>" title="Logo">
                    <img height="60px" width="20px" src="images/index/logo1.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>index.php?session_user=<?php echo $_SESSION['user']; ?>">TRANG CHỦ</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php?session_user=<?php echo $_SESSION['user']; ?>">LOẠI SẢN PHẨM</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>agricultural.php?session_user=<?php echo $_SESSION['user']; ?>">SẢN PHẨM</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>tracking-order.php?session_user=<?php echo $_SESSION['user']; ?>">ĐƠN HÀNG</a>
                    </li>

                    <li>
                        <a href="<?php echo SITEURL; ?>cart.php?session_user=<?php echo $_SESSION['user']; ?>" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-quantity"><?php echo $count; ?></span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropbtn">
                                <?php
                                $sql = "SELECT * FROM khach_hang WHERE ten_nguoi_dung='" . $_SESSION['user'] . "'";
                                $res = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($res);
                                $anh = $row['anh'];
                                $doanh_nghiep = $row['doanh_nghiep'];
                                if ($anh != "") {
                                    if ($doanh_nghiep == 1) {
                                        echo "<img src='" . SITEURL . "images/avatar/$anh' style='max-width: 50px; max-height: 50px; border-radius: 50%; border: 10px solid yellow;'>";
                                    } else {
                                        echo "<img src='" . SITEURL . "images/avatar/$anh' style='max-width: 50px; max-height: 50px; border-radius: 50%;'>";
                                    }
                                } else {
                                    echo "<i class='fas fa-user fa-lg'></i>";
                                }
                                ?>
                            </a>
                            <div id="myDropdown" class="dropdown-content">
                                <a href="<?php echo SITEURL; ?>infor.php?session_user=<?php echo $_SESSION['user']; ?>">THÔNG TIN <i class="fas fa-question-circle fa-sm"></i></a>
                                <a href="<?php echo SITEURL; ?>update-password.php?session_user=<?php echo $_SESSION['user']; ?>">ĐỔI MẬT KHẨU</a>
                                <a href="<?php echo SITEURL; ?>logout.php">ĐĂNG XUẤT <i class="fas fa-sign-out-alt"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->