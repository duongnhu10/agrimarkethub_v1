<?php
include('partials-font/menu.php');
ob_start();
$session_user = ""; // Khởi tạo biến session_user

if (isset($_GET['session_user'])) {
    $session_user = $_GET['session_user']; // Lấy giá trị session_user từ URL nếu tồn tại
}

//Lấy thông tin khách hàng đăng nhập
$sql_s = "SELECT * FROM khach_hang WHERE ten_nguoi_dung='$session_user'";
$res_s = mysqli_query($conn, $sql_s);
$row_s = mysqli_fetch_assoc($res_s);
$count_s = mysqli_num_rows($res_s);
if ($count_s == 1) {
    //Có
    $id_us = $row_s['id'];
} else {
    //Không
} ?>

<?php
//Kiểm tra lấy id sản phẩm và số lượng khách hàng thêm vào giỏ hàng
if (isset($_GET['spham_id']) && isset($_GET['so'])) {
    if ($_GET['so'] == 0) {
        $_SESSION['het_hang'] = "<div class='error text-center'>Đã hết hàng.</div>";
        header('location:' . SITEURL . 'cart.php?session_user=' . $_SESSION['user']);
        exit; // Dừng việc thực hiện tiếp các lệnh sau khi chuyển hướng
    }
    //Lấy chi tiết sản phẩm đặt hàng
    $spham_id = $_GET['spham_id'];
    $so = $_GET['so'];

    //Lấy các thông tin
    $sql = "SELECT * FROM san_pham WHERE id=$spham_id";
    //Chạy SQL
    $res = mysqli_query($conn, $sql);
    //Đếm số dòng
    $count = mysqli_num_rows($res);
    //Kiểm tra dữ liệu 
    if ($count == 1) {
        //Có dữ liệu
        $row = mysqli_fetch_assoc($res);
        $ten_san_pham = $row['ten_san_pham'];
        $gia = $row['gia'];
        $gia_dn = $row['gia_dn'];
        $gia_khuyen_mai = $row['gia_khuyen_mai'];
        $anh = $row['anh'];
        $ton_kho = $row['ton_kho'];
    } else {
        //Không có sản phẩm và chuyển hướng
        header('location:' . SITEURL . "?session_user=" . $_SESSION['user']);
    }
} else {
    //Chuyển hướng trang chủ
    header('location:' . SITEURL . "?session_user=" . $_SESSION['user']);
}
?>

<!-- Bắt đầu thông tin đặt hàng -->
<section class="food-menu">
    <div class="container">

        <h2 class="text-center " style="color: black;">ĐIỀN THÔNG TIN ĐỂ ĐẶT HÀNG</h2>

        <form action="" method="POST" class="order">
            <fieldset style="border: 1px solid black;">
                <legend>SẢN PHẨM ĐÃ CHỌN</legend>

                <div class="food-menu-img">
                    <?php
                    //Kiểm tra ảnh
                    if ($anh == "") {
                        //Không có
                        echo "<div class='error'>Không có hình ảnh.</div>";
                    } else {
                        //Có
                    ?>
                        <img height="130px" src="<?php echo SITEURL; ?>images/agricultural/<?php echo $anh; ?>" alt="" class="img-responsive img-curve">
                    <?php
                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $ten_san_pham; ?></h3>
                    <input type="hidden" name="san_pham" value="<?php echo $ten_san_pham; ?>">

                    <p class="food-price">
                        <?php
                        $sql_km = "SELECT * FROM khuyen_mai WHERE sanpham_id = $spham_id ORDER BY ngay_batdau DESC LIMIT 1";
                        $res_km = mysqli_query($conn, $sql_km);

                        if ($res_km) {
                            if (mysqli_num_rows($res_km) > 0) {
                                $row_km = mysqli_fetch_assoc($res_km);
                                $ngay_bat_dau = $row_km['ngay_batdau'];
                                $ngay_ket_thuc = $row_km['ngay_ketthuc'];
                            } else {
                                // Không có dữ liệu từ truy vấn
                                $ngay_bat_dau = "0000-00-00";
                                $ngay_ket_thuc = "0000-00-00";
                            }
                        } else {
                            // Lỗi khi thực hiện truy vấn
                            $ngay_bat_dau = "0000-00-00";
                            $ngay_ket_thuc = "0000-00-00";
                        }

                        $sql_dn = "SELECT * FROM khach_hang WHERE id=$id_us";
                        $res_dn = mysqli_query($conn, $sql_dn);
                        if ($res_dn == true) {
                            //Thành công
                            $row_dn = mysqli_fetch_assoc($res_dn);
                            $doanh_nghiep = $row_dn['doanh_nghiep'];
                        } else {
                            //Kết nối thất bại
                        }

                        if ($doanh_nghiep == 1) {
                            //Hiển thị giá doanh nghiệp
                            echo "<i class='fas fa-fire blinking-icon'></i>";
                            echo "<i> " . str_replace(',', ' ', number_format($gia_dn)) . " VND/Kg <br></i>";
                        } else {
                            //Hiển thị giá người dùng không phải doanh nghiệp
                            if ($gia_khuyen_mai != 0) {
                                echo "<i style='text-decoration-line: line-through;'>" . str_replace(',', ' ', number_format($gia)) . " VND/Kg <br></i>";
                                $gia_km = $gia - $gia_khuyen_mai * 0.01 * $gia;
                                echo "<i class='red'>" . str_replace(',', ' ', number_format($gia_km)) . " VND/Kg<br></i>";
                                echo "<i><b> Từ ngày: " . $ngay_bat_dau . " đến " . $ngay_ket_thuc . "</b></i>";
                            } else {
                                echo "<i>" . str_replace(',', ' ', number_format($gia)) . " VND/Kg <br></i>";
                            }
                        }
                        ?>
                    </p>

                    <!-- Hiển thị giá -->
                    <input type="hidden" name="gia" value="<?php
                                                            if ($doanh_nghiep == 1) {
                                                                echo $gia_dn;
                                                            } else
                                                            if ($gia_khuyen_mai != 0) {
                                                                echo $gia_km;
                                                            } else {
                                                                echo $gia;
                                                            } ?>">
                    <?php
                    $sql_tk = "SELECT * FROM san_pham WHERE id=$spham_id";
                    $res_tk = mysqli_query($conn, $sql_tk);
                    $row_tk = mysqli_fetch_assoc($res_tk);
                    $ton_kho = $row_tk['ton_kho'];
                    ?>
                    <br>

                    <!-- Hiển thị tồn kho -->
                    <p class="food-price">
                        <?php
                        if ($ton_kho == 0) {
                            echo "<i class='red'>HẾT HÀNG</i>";
                        } else {
                            echo "<i> <b>Tồn kho: </b>" . $ton_kho . " Kg <br></i>";
                        }
                        ?>
                    </p>

                    <!-- Lấy số lượng sản phẩm đã thêm vào giỏ hàng -->
                    <?php
                    if ($so > 1) {
                        echo '<input type="number" name="so_luong" class="input-responsive" value="' . $so . '" required>';
                    } else {
                        echo '<input type="number" name="so_luong" class="input-responsive" value="1" required>';
                    }
                    ?>
                </div>

            </fieldset>

            <fieldset style="border: 1px solid black;">
                <legend style="color: black;">THÔNG TIN GIAO HÀNG</legend>
                <div class="order-label">Họ và tên</div>
                <input type="text" name="khach_ten" placeholder="VD. Nguyễn Văn A" class="input-responsive" required>

                <div class="order-label">Số điện thoại</div>
                <input type="tel" name="khach_sdt" placeholder="VD. 0385673xxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="khach_email" placeholder="VD. vana@gmail.com" class="input-responsive" required>

                <div class="order-label">Địa chỉ</div>
                <textarea name="khach_diachi" rows="10" placeholder="VD. Trần Văn Khéo, Cái Khế, Ninh Kiều, Cần Thơ" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Đặt hàng" class="btn btn-primary">

            </fieldset>

        </form>

        <?php
        //Kiểm tra nút đặt hàng
        if (isset($_POST['submit'])) {
            //Lấy thông tin chi tiết
            $san_pham = $_POST['san_pham'];
            $gia = $_POST['gia'];
            $so_luong = $_POST['so_luong'];

            // Kiểm tra xem số lượng đặt hàng có vượt quá số lượng tồn kho hay không
            if ($so_luong > $ton_kho) {
                // Nếu vượt quá, hiển thị cảnh báo và chuyển hướng trở lại trang đặt hàng
                $_SESSION['dat_hang'] = "<div class='error text-center'>Số lượng đặt hàng vượt quá số lượng tồn kho.</div>";
                header('location:' . SITEURL . '?session_user=' . $_SESSION['user']);
                exit; // Dừng việc thực hiện tiếp các lệnh sau khi chuyển hướng
            } else {
                $ton_kho = $ton_kho - $so_luong;
            }

            // Cập nhật số lượng tồn kho sau khi đặt hàng
            $sql_tk = "UPDATE san_pham SET ton_kho = $ton_kho WHERE ten_san_pham='$ten_san_pham'";
            $res_tk = mysqli_query($conn, $sql_tk);

            $tong_tien = $gia * $so_luong;

            $ngay_dat = date("Y-m-d h:i:sa"); //Ngày đặt

            $trang_thai = "Chờ xác nhận"; //Trạng thái giao hàng

            $khach_ten = $_POST['khach_ten'];
            $khach_sdt = $_POST['khach_sdt'];
            $khach_email = $_POST['khach_email'];
            $khach_diachi = $_POST['khach_diachi'];

            //Lưu vào database
            $sql2 = "INSERT INTO don_hang SET
                san_pham = '$san_pham',
                gia = $gia,
                so_luong = $so_luong,
                tong_tien = $tong_tien,
                ngay_dat = '$ngay_dat',
                trang_thai = '$trang_thai',
                khach_ten = '$khach_ten',
                khach_sdt = '$khach_sdt',
                khach_email = '$khach_email',
                khach_diachi = '$khach_diachi',
                user_id = $id_us
            ";

            //Chạy SQL
            $res2 = mysqli_query($conn, $sql2);

            //Kiểm tra kết nối
            if ($res2 == true) {
                //Thành công
                $_SESSION['dat_hang'] = "<div class='success text-center'>Đặt hàng thành công.</div>";
                header('location:' . SITEURL . '?session_user=' . $_SESSION['user']);
            } else {
                //Thất bại
                $_SESSION['dat_hang'] = "<div class='error  text-center'>Đặt hàng thất bại.</div>";
                header('location:' . SITEURL . '?session_user=' . $_SESSION['user']);
            }
        }
        ?>
    </div>
</section>
<!-- Kết thúc đặt hàng -->

<?php
include('partials-font/footer.php');
ob_end_flush();
?>