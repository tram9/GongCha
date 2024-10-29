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
    <h2>Chỉnh Sửa Nhà Cung Cấp</h2>
    <form action="index.php?controller=khoHang&action=updateSupplier&id=<?php echo $supplier['ncc_id']; ?>"
        method="POST">
        <div class="form-group">
            <label for="ten_ncc">Tên Nhà Cung Cấp:</label>
            <input type="text" name="ten_ncc" class="form-control" value="<?php echo $supplier['ten_ncc']; ?>" required>
        </div>
        <div class="form-group">
            <label for="diachi">Địa Chỉ:</label>
            <input type="text" name="diachi" class="form-control" value="<?php echo $supplier['diachi']; ?>" required>
        </div>
        <div class="form-group">
            <label for="sdt">Số Điện Thoại:</label>
            <input type="text" name="sdt" class="form-control" value="<?php echo $supplier['sdt']; ?>" required>
        </div>
        <div class="form-group">
            <label for="masothue">Mã Số Thuế:</label>
            <input type="text" name="masothue" class="form-control" value="<?php echo $supplier['masothue']; ?>">
        </div>
        <div class="form-group">
            <label for="ghichu">Ghi Chú:</label>
            <textarea name="ghichu" class="form-control"><?php echo $supplier['ghichu']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-blue">Cập nhật</button>
        <form method="GET" action="index.php">
            <input type="hidden" name="controller" value="khoHang">
            <input type="hidden" name="action" value="listProducts">
            <button type="submit" class="btn btn-secondary">Trở về</button>
        </form>
    </form>
</div>