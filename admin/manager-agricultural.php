<?php include('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">

    <div class="wrapper">

        <h1>QUẢN LÝ NÔNG SẢN</h1>
        <br><br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }


        if (isset($_SESSION['unauthorize'])) {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }
        ?>
        <br><br><br>

        <!-- Button to Add Admin -->
        <a href="<?php echo SITEURL; ?>admin/add-agricultural.php" class="btn-primary">Thêm sản phẩm</a>

        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá gốc</th>
                <th>Giá hiện tại</th>
                <th>Khuyến mãi</th>
                <th>Hình ảnh</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>

            <?php
            //Create a SQL Query to Get all the products
            $sql = "SELECT * FROM san_pham";

            //Execute the query
            $res = mysqli_query($conn, $sql);

            //Count Rows to check whether we have products or not
            $count = mysqli_num_rows($res);

            //Create Serial Number Variable and set default value as 1
            $sn = 1;

            if ($count > 0) {
                //We have product in Database
                //Get the products from Database and display
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $ten_san_pham = $row['ten_san_pham'];
                    $gia_goc = $row['gia_goc'];
                    $gia = $row['gia'];
                    $gia_khuyen_mai = $row['gia_khuyen_mai'];
                    $anh = $row['anh'];
                    $trang_thai = $row['trang_thai'];
            ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $ten_san_pham; ?></td>
                        <td><?php echo $gia_goc; ?>VND</td>
                        <td><?php echo $gia; ?>VND</td>
                        <td><?php echo $gia_khuyen_mai; ?>%</td>
                        <td>
                            <?php
                            //Check whether we have image or not
                            if ($anh == "") {
                                //We don not have image, Display Error Message
                                echo "<div class='error'>Hình ảnh không được thêm.</div>";
                            } else {
                                //We have Image, Display Image
                            ?>
                                <img src="<?php echo SITEURL; ?>images/agricultural/<?php echo $anh; ?>" width="150px;">
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $trang_thai; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-agricultural.php?id=<?php echo $id; ?>" class="btn-secondary">Cập nhật sản phẩm</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-agricultural.php?id=<?php echo $id; ?>&anh=<?php echo $anh; ?>" class="btn-danger">Xóa sản phẩm</a>
                        </td>
                    </tr>

            <?php
                }
            } else {
                //Product not Added in Database
                echo "<tr><td colspan='7' class='error'>Thêm sản phẩm thất bại.</td></tr>";
            }

            ?>

        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php') ?>