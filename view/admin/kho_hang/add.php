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
        <h2>Thêm nguyên liệu mới</h2>
        <form action="index.php?controller=khoHang&action=addProduct" method="POST">
            <div class="form-group">
                <label for="ten_nl">Tên nguyên liệu:</label>
                <input type="text" class="form-control" name="ten_nl" required>
            </div>
            <div class="form-group">
                <label for="so_luong">Số lượng:</label>
                <input type="number" class="form-control" name="so_luong" required>
            </div>
            <div class="form-group">
                <label for="ngay_nhap">Ngày nhập:</label>
                <input type="date" class="form-control" name="ngay_nhap" required>
            </div>
            <div class="form-group">
                <label for="gia_nhap">Giá nhập:</label>
                <input type="number" class="form-control" step="0.01" name="gia_nhap" required>
            </div>
            <div class="form-group">
                <label for="ncc_id">Nhà cung cấp:</label>
                <input type="number" class="form-control" name="ncc_id" required>
            </div>
            <div class="form-group">
                <button type="submit">Thêm</button>
            </div>
        </form>
        <a href="index.php?controller=khoHang&action=listProducts">Trở về</a>
    </div>
</body>

</html>