<?php include('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">

    <div class="wrapper">

        <h1>QUẢN LÝ NÔNG SẢN</h1>
        <br><br><br>

        <!-- Button to Add Admin -->
        <a href="<?php echo SITEURL; ?>admin/add-agricultural.php" class="btn-primary">Thêm sản phẩm</a>

        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Full name</th>
                <th>Username</th>
                <th>Action</th>
            </tr>

            <tr>
                <td>1.</td>
                <td>Duong Nhu</td>
                <td>nhuduong10</td>
                <td>
                    <a href="#" class="btn-secondary">Update admin</a>
                    <a href="#" class="btn-danger">Delete admin</a>
                </td>
            </tr>

            <tr>
                <td>2.</td>
                <td>Duong Nhu</td>
                <td>nhuduong10</td>
                <td>
                    <a href="#" class="btn-secondary">Update admin</a>
                    <a href="#" class="btn-danger">Delete admin</a>
                </td>
            </tr>

            <tr>
                <td>3.</td>
                <td>Duong Nhu</td>
                <td>nhuduong10</td>
                <td>
                    <a href="#" class="btn-secondary">Update admin</a>
                    <a href="#" class="btn-danger">Delete admin</a>
                </td>
            </tr>

        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php') ?>