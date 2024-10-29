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

<div class="container">
    <h2>Thêm Nhà Cung Cấp</h2>
    <form method="POST" action="index.php?controller=khoHang&action=addSupplier">
        <div class="form-group">
            <label for="ten_ncc">Tên Nhà Cung Cấp:</label>
            <input type="text" name="ten_ncc" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="diachi">Địa Chỉ:</label>
            <input type="text" name="diachi" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="sdt">Số Điện Thoại:</label>
            <input type="text" name="sdt" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="masothue">Mã Số Thuế:</label>
            <input type="text" name="masothue" class="form-control">
        </div>
        <div class="form-group">
            <label for="ghichu">Ghi Chú:</label>
            <textarea name="ghichu" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Nhà Cung Cấp</button>
        <a href="index.php?controller=khoHang&action=listProducts" class="btn btn-secondary">Hủy</a>
    </form>
</div>
