<?php include('partials-font/menu.php');
$session_user = ""; // Khởi tạo biến session_user

$id_us = "";

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
} ?>

<?php
if (isset($_SESSION['delete'])) {
    echo $_SESSION['delete'];
    unset($_SESSION['delete']);
}
?>


<section class="food-menu">
    <div class="container">

        <h2 class="text-center">THÔNG TIN ĐƠN HÀNG</h2>

        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng/kg</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Tên khách hàng</th>
                    <th>SDT</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Đoạn mã PHP để hiển thị dữ liệu từ cơ sở dữ liệu vào bảng -->
                <?php
                $sn = 1;
                $sql = "SELECT * FROM don_hang WHERE user_id=$id_us ORDER BY id DESC";  //Lấy thông tin
                $res = mysqli_query($conn, $sql); //Kết nối
                $count = mysqli_num_rows($res); //Đếm số dòng
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        echo "<td>" . $sn++ . "</td>";
                        echo "<td>" . $row['san_pham'] . "</td>";

                        echo "<td>" .  str_replace(',', ' ', number_format($row['gia'])) . " VND</td>";
                        echo "<td>" . $row['so_luong'] . "</td>";
                        echo "<td>" . str_replace(',', ' ', number_format($row['tong_tien'])) . "  VND</td>";
                        echo "<td>" . $row['ngay_dat'] . "</td>";
                        if ($row['trang_thai']  == "Chờ xác nhận") {
                            echo "<td>" . $row['trang_thai'] . "</td>";
                        } else if ($row['trang_thai']  == "Đang giao hàng") {
                            echo "<td style='color:orange;'>" . $row['trang_thai'] . "</td>";
                        } else if ($row['trang_thai'] == "Đã giao hàng") {
                            echo "<td style='color:green;'>" . $row['trang_thai'] . "</td>";
                        } else if ($row['trang_thai'] == "Đã hủy") {
                            echo "<td style='color:red;'>" . $row['trang_thai'] . "</td>";
                        }
                        echo "<td>" . $row['khach_ten'] . "</td>";
                        echo "<td>" . $row['khach_sdt'] . "</td>";
                        echo "<td>" . $row['khach_email'] . "</td>";
                        echo "<td>" . $row['khach_diachi'] . "</td>";
                        echo "<td><a href='" . SITEURL . "delete-order.php?order-id=" . $row['id'] . "&session_user=" . $_SESSION['user'] . "' class='btn btn-primary'>Hủy đơn hàng</a></td>";



                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12' class='error'>Không có đơn hàng.</td></tr>
                    ";
                }

                ?>
            </tbody>
        </table>
    </div>
</section>

<?php include('partials-font/footer.php'); ?>