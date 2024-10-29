<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Cập nhật nguyên liệu</h2>
        <form action="index.php?controller=khoHang&action=updateProduct&id=<?php echo $product['id']; ?>" method="POST">
            <div class="form-group">
                <label for="ten_nl">Tên nguyên liệu:</label>
                <input type="text" class="form-control" name="ten_nl" value="<?php echo $product['ten_nl']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="so_luong">Số lượng:</label>
                <input type="number" class="form-control" name="so_luong" value="<?php echo $product['so_luong']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="ngay_nhap">Ngày nhập:</label>
                <input type="date" class="form-control" name="ngay_nhap" value="<?php echo $product['ngay_nhap']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="gia_nhap">Giá:</label>
                <input type="number" class="form-control" step="0" name="gia_nhap"
                    value="<?php echo $product['gia_nhap']; ?>" required>
            </div>
            <div class="form-group">
                <label for="ncc_id">Nhà cung cấp:</label>
                <input type="number" class="form-control" step="1" min="1" name="ncc_id"
                    value="<?php echo $product['ncc_id']; ?>" required>
            </div>
            <button type="submit" class="btn btn-blue">Cập nhật</button>
            <form method="GET" action="index.php">
                <input type="hidden" name="controller" value="khoHang">
                <input type="hidden" name="action" value="listProducts">
                <button type="submit" class="btn btn-secondary">Trở về</button>
            </form>
        </form>
        <br>

        <!-- <a href="index.php?controller=khoHang&action=listProducts">Trở về</a> -->
    </div>

</body>

</html>