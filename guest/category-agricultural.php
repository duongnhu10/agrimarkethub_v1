<?php include('partials/menu.php'); ?>

<?php
//Check whether id is passed or not
if (isset($_GET['loai_id'])) {
    //Category id is set and get the id
    $loai_id = $_GET['loai_id'];
    //Get the category title based on Category ID
    $sql = "SELECT ten_loai FROM loai_san_pham WHERE id=$loai_id";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    //Get the vaue from Database
    $row = mysqli_fetch_assoc($res);
    //Get the title
    $ten_loai = $row['ten_loai'];
} else {
    //Category not passed
    //Redirect to Home page
    header('location:' . SITEURL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <h2>Danh mục <a href="#" class="text-white">"<?php echo $ten_loai; ?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">SẢN PHẨM</h2>

        <?php
        //Create SQL Query to Get foods based on Selected Category
        $sql2 = "SELECT * FROM san_pham WHERE loai_id = $loai_id";

        //Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //COunt the rows
        $count2 = mysqli_num_rows($res2);

        //Check whether food is available or not
        if ($count2 > 0) {
            //Food is available 
            while ($row2 = mysqli_fetch_assoc($res2)) {
                $id = $row2['id'];
                $ten_san_pham = $row2['ten_san_pham'];
                $gia = $row2['gia'];
                $gia_khuyen_mai = $row2['gia_khuyen_mai'];
                $mo_ta = $row2['mo_ta'];
                $anh = $row2['anh'];
        ?>

                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        //Check whether image available or not
                        if ($anh == "") {
                            //Image not Available
                            echo "<div class='error'>Không có hình ảnh.</div>";
                        } else {
                            //Image Available
                        ?>
                            <img height="130px" src="<?php echo SITEURL; ?>images/agricultural/<?php echo $anh; ?>" alt="" class="img-responsive img-curve">
                        <?php
                        }
                        ?>

                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $ten_san_pham; ?></h4>
                        <p class="food-price">
                            <?php

                            if ($gia_khuyen_mai != 0) {
                                echo "<i style='text-decoration-line: line-through;'>" . str_replace(',', ' ', number_format($gia)) . " VND/Kg <br></i>";
                                $gia_km = $gia - $gia_khuyen_mai * 0.01 * $gia;
                                echo "<i class='red'>" . str_replace(',', ' ', number_format($gia_km)) . " VND/Kg</i>";
                            } else {
                                echo "<i>" . str_replace(',', ' ', number_format($gia)) . " VND/Kg <br></i>";
                            }

                            ?>
                        </p>
                        <p class="food-detail">
                            <?php echo $mo_ta; ?>
                        </p>
                        <br>


                        <a href="<?php echo SITEURL; ?>guest/sign-up.php?>" class="btn btn-primary">Đặt hàng</a>

                        <a href="<?php echo SITEURL; ?>guest/sign-up.php?>" class="btn btn-primary">Thêm vào giỏ hàng</a>

                    </div>
                </div>

        <?php
            }
        } else {
            //Food not available
            echo "<div class='error'>Không có sản phẩm.</div>";
        }
        ?>

        <div class="clearfix"></div>

    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials/footer.php'); ?>