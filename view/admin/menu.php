<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Thức uống</title>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/admin_style.css">
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Danh sách Thức uống</h1>

        <div class="d-flex mb-3">
        <form action="index.php?controller=menu&action=searchMenu" method="POST" class="d-flex flex-grow-1 me-2">
            <select name="search_type" class="form-select" id="searchType">
                <option value="name">Tìm theo tên Sản phẩm</option>
                <option value="category">Tìm theo danh mục</option>
            </select>

            <input type="text" name="search" class="form-control" placeholder="Nhập tên Sản phẩm" id="searchInput">

            <select name="search_category" class="form-select d-none" id="searchCategory">
                <option value="" disabled selected>Chọn danh mục</option>
                <?php foreach ($danhMucList as $danhMuc): ?>
                    <option value="<?= $danhMuc['id_danhmuc']; ?>"><?= $danhMuc['tenLoai']; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn btn-success mx-1 flex-grow-1">Tìm kiếm</button>
            <a href="index.php?controller=menu&action=listMenu" class="btn btn-secondary mx-1">
                <i class="bi bi-arrow-left-circle"></i> Quay lại
            </a>
        </form>

            
            <div class="d-flex flex-grow-1 me-2">
                <button id= "exportExcel" class="btn btn-success mx-1 flex-grow-1">Xuất Excel</button>
                <button type="button" class="btn btn-success mx-1 flex-grow-1" data-bs-toggle="modal" data-bs-target="#addMenuModal">Thêm Thức uống</button>
            </div>
        </div>

        <table id="menuTbl" class="table table-bordered table-hover table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Tên Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Công thức</th>
                    <th>Giá S</th>
                    <th>Giá M</th>
                    <th>Giá L</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($menuItems)): ?>
                    <?php foreach ($menuItems as $menu): ?>
                        <tr class="text-center">
                            <td><?php echo $menu['id_sanpham']; ?></td>
                            <td><?php echo $menu['danhmuc']; ?></td>
                            <td><?php echo $menu['tenSP']; ?></td>
                            <td><img src="public/images/<?php echo $menu['hinh_anh']; ?>" alt="Hình ảnh sản phẩm" style="width: 50px; height: auto;"></td>
                            <td><?php echo $menu['congthuc']; ?></td>
                            <td><?php echo number_format($menu['gia_S'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($menu['gia_M'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($menu['gia_L'], 0, ',', '.'); ?> VND</td>
                            <td>
                                <button class="btn option-btn btn-sm" data-bs-toggle="modal" data-bs-target="#updateMenuModal<?php echo $menu['id_sanpham']; ?>">Sửa</button>
                                <form action="index.php?controller=menu&action=deleteMenu&id=<?php echo $menu['id_sanpham']; ?>" method="POST" style="display:inline;">
                                    <button type="submit" class="btn delete-btn btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa Thức uống này?');">Xóa</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Sửa Thức uống -->
                        <div class="modal fade" id="updateMenuModal<?php echo $menu['id_sanpham']; ?>" tabindex="-1" aria-labelledby="updateMenuModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sửa Thức uống</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="index.php?controller=menu&action=updateMenu&id=<?php echo $menu['id_sanpham']; ?>" method="POST">
                                            <div class="mb-3">
                                                <label for="id_danhmuc" class="form-label">Danh mục:</label>
                                                <select name="id_danhmuc" class="form-select" required>
                                                    <?php foreach ($danhMucList as $danhMuc): ?>
                                                        <option value="<?php echo $danhMuc['id_danhmuc']; ?>" 
                                                            <?php echo ($menu['id_danhmuc'] == $danhMuc['id_danhmuc']) ? 'selected' : ''; ?>>
                                                            <?php echo $danhMuc['tenLoai']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tenSP" class="form-label">Tên Sản phẩm:</label>
                                                <input type="text" name="tenSP" class="form-control" value="<?php echo $menu['tenSP']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hinh_anh" class="form-label">Hình ảnh:</label>
                                                <input type="file" name="hinh_anh" class="form-control" accept="image/*" value="<?php echo $menu['hinh_anh']; ?>">
                                             </div>
                                            <div class="mb-3">
                                                <label for="congthuc" class="form-label">Công thức:</label>
                                                <textarea name="congthuc" class="form-control" ><?php echo $menu['congthuc']; ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="gia_S" class="form-label">Giá S:</label>
                                                <input type="number" name="gia_S" class="form-control" value="<?php echo $menu['gia_S']; ?>" min = 0>
                                             </div>
                                             <div class="mb-3">
                                                <label for="gia_M" class="form-label">Giá M:</label>
                                                <input type="number" name="gia_M" class="form-control" value="<?php echo $menu['gia_M']; ?>" min = 0>
                                             </div>
                                             <div class="mb-3">
                                                <label for="gia_L" class="form-label">Giá L:</label>
                                                <input type="number" name="gia_L" class="form-control" value="<?php echo $menu['gia_L']; ?>" min = 0>
                                             </div>
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Không có Thức uống nào để hiển thị.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal Thêm Thức uống -->
        <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Thức uống</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="index.php?controller=menu&action=addMenu" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="id_sanpham" class="form-label">Mã sản phẩm:</label>
                            <input type="text" id="id_sanpham" name="id_sanpham" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_danhmuc" class="form-label">Danh mục:</label>
                            <select name="id_danhmuc" class="form-select" required>
                            <option value="" disabled selected>Chọn danh mục</option>
                                <?php if (!empty($danhMucList)): ?>
                                    <?php foreach ($danhMucList as $danhMuc): ?>
                                        <option value="<?php echo $danhMuc['id_danhmuc']; ?>">
                                            <?php echo $danhMuc['tenLoai']; // Sử dụng tên danh mục để hiển thị ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Không có danh mục nào</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tenSP" class="form-label">Tên sản phẩm:</label>
                            <input type="text" id="tenSP" name="tenSP" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="hinh_anh" class="form-label">Hình ảnh:</label>
                            <input type="file" id="hinh_anh" name="hinh_anh" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="congthuc" class="form-label">Công thức:</label>
                            <textarea id="congthuc" name="congthuc" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="gia_S" class="form-label">Giá S:</label>
                            <input type="number" id="gia_S" name="gia_S" class="form-control" min = 0>
                        </div>

                        <div class="mb-3">
                            <label for="gia_M" class="form-label">Giá M:</label>
                            <input type="number" id="gia_M" name="gia_M" class="form-control" min = 0>
                        </div>

                        <div class="mb-3">
                            <label for="gia_L" class="form-label">Giá L:</label>
                            <input type="number" id="gia_L" name="gia_L" class="form-control" min = 0>
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchType = document.getElementById('searchType');
        const searchInput = document.getElementById('searchInput');
        const searchCategory = document.getElementById('searchCategory');

        searchType.addEventListener('change', () => {
            const isNameSearch = searchType.value === 'name';
            searchInput.classList.toggle('d-none', !isNameSearch);
            searchCategory.classList.toggle('d-none', isNameSearch);
        });
    </script>
    <script>
   document.getElementById('exportExcel').addEventListener('click', function() {
            let tableId = 'menuTbl'; 
            exportExcel(tableId);
   });
   function exportExcel(tableId) {
        var table = document.getElementById(tableId);

        if (!table) {
            console.error("Không tìm thấy bảng với ID: " + tableId);
            return;
        }

        // Lấy tất cả các hàng của bảng
        var rows = table.getElementsByTagName('tr');
        var data = [];
        
        // Thêm tiêu đề vào mảng dữ liệu, bỏ qua cột cuối nếu có
        var headers = [];
        var headerCells = rows[0].getElementsByTagName('th');
        for (var j = 0; j < headerCells.length - 1; j++) { // Bỏ qua cột cuối cùng
            headers.push(headerCells[j].innerText);
        }
        data.push(headers); 

        // Xử lý các hàng dữ liệu
        for (var i = 1; i < rows.length; i++) { // Bắt đầu từ 1 để bỏ qua hàng tiêu đề
            var cells = rows[i].getElementsByTagName('td');
            var rowData = [];
            for (var j = 0; j < cells.length - 1; j++) { // Bỏ qua cột cuối cùng
                var cellValue = cells[j].innerText;
                rowData.push(cellValue); 
            }
            data.push(rowData);
        }

        // Tạo workbook từ mảng dữ liệu
        var worksheet = XLSX.utils.aoa_to_sheet(data);
        var workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

        // Định dạng tiêu đề
        const headerCellStyle = {
            font: { bold: true },
            alignment: { horizontal: "center" },
        };

        // Áp dụng định dạng cho các ô tiêu đề
        for (let i = 0; i < headers.length; i++) {
            const cellAddress = XLSX.utils.encode_cell({ c: i, r: 0 });
            worksheet[cellAddress].s = headerCellStyle; 
        }

        // Định dạng các cột (khoảng cách)
        worksheet["!cols"] = worksheet["!cols"] || []; 
        for (let i = 0; i < headers.length; i++) { 
            worksheet["!cols"][i] = { wch: i === 6 ? 25 : 13 }; 
        }

        // Xuất file Excel
        XLSX.writeFile(workbook, 'Thực đơn.xlsx');
    }
</script>
    <!-- Custom JS file link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script src="public/js/admin_script.js"></script>
</body>
</html>
