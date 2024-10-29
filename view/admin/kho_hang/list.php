<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quản lí kho hàng và nhà cung cấp</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="public/css/admin_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <style>
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }

        thead th {
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 10;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            
            <div class="col-md-6">
                <h2>Quản lí kho hàng</h2>
                <form method="GET" action="index.php">
                    <input type="hidden" name="controller" value="khoHang">
                    <input type="hidden" name="action" value="searchProducts">
                    <input type="text" name="search" placeholder="Nhập tên nguyên liệu..." required class="form-control"
                        style="width: auto; display: inline-block; margin-right: 10px;">
                    <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                </form>
                <br>
                <form method="GET" action="index.php">
                    <input type="hidden" name="controller" value="khoHang">
                    <input type="hidden" name="action" value="listProducts">
                    <button type="submit" class="btn btn-secondary">Danh sách</button>
                </form>
                <br>
                <form method="GET" action="index.php">
                    <input type="hidden" name="controller" value="khoHang">
                    <input type="hidden" name="action" value="addProduct">
                    <button type="submit" class="btn btn-primary">Thêm nguyên liệu</button>
                </form>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên nguyên liệu</th>
                                <th>Số lượng</th>
                                <th>Ngày nhập</th>
                                <th>Giá (đồng)</th>
                                <th>Nhà cung cấp</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td><?php echo $product['ten_nl']; ?></td>
                                <td><?php echo $product['so_luong']; ?></td>
                                <td>
                                    <?php 
                                        $date = new DateTime($product['ngay_nhap']);
                                        echo $date->format('d/m/Y'); 
                                    ?>
                                </td>
                                <td><?php echo $product['gia_nhap']; ?></td>
                                <td><?php echo $product['ncc_id']; ?></td>
                                <td>
                                    <a href="index.php?controller=khoHang&action=updateProduct&id=<?php echo $product['id']; ?>">Sửa</a>
                                    <a href="index.php?controller=khoHang&action=deleteProduct&id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Xóa</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bên phải: Quản lí nhà cung cấp -->
            <div class="col-md-6">
                <h2>Quản lí nhà cung cấp</h2>
                <form method="GET" action="index.php">
                    <input type="hidden" name="controller" value="khoHang">
                    <input type="hidden" name="action" value="searchSupplier">
                    <input type="text" name="search" placeholder="Nhập tên nhà cung cấp..." required class="form-control"
                        style="width: auto; display: inline-block; margin-right: 10px;">
                    <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                </form>
                <br>
                <form method="GET" action="index.php">
                    <input type="hidden" name="controller" value="khoHang">
                    <input type="hidden" name="action" value="listProducts">
                    <button type="submit" class="btn btn-secondary">Danh sách</button>
                </form>
                <br>
                <form method="GET" action="index.php">
                    <input type="hidden" name="controller" value="khoHang">
                    <input type="hidden" name="action" value="addSupplier">
                    <button type="submit" class="btn btn-primary">Thêm nhà cung cấp</button>
                </form>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên nhà cung cấp</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Mã số thuế</th>
                                <th>Ghi chú</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td><?php echo $supplier['ncc_id']; ?></td>
                                <td><?php echo $supplier['ten_ncc']; ?></td>
                                <td><?php echo $supplier['diachi']; ?></td>
                                <td><?php echo $supplier['sdt']; ?></td>
                                <td><?php echo $supplier['masothue']; ?></td>
                                <td><?php echo $supplier['ghichu']; ?></td>
                                <td>
                                    <a href="index.php?controller=khoHang&action=updateSupplier&id=<?php echo $supplier['ncc_id']; ?>">Sửa</a>
                                    <a href="index.php?controller=khoHang&action=deleteSupplier&id=<?php echo $supplier['ncc_id']; ?>" onclick="return confirm('Are you sure you want to delete this supplier?');">Xóa</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/admin_script.js"></script>
</body>

</html>
