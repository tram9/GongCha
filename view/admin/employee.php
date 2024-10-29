<?php
// session_start();
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
     <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/admin_style.css">

</style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Danh sách nhân viên</h1>
        <div class="d-flex mb-3">
        <form action="index.php?controller=Employee&action=searchEmployees" method="POST" class="d-flex flex-grow-1 me-2">
            <select name="search_type" class="form-select" id="searchType">
                <option value="name">Tìm theo tên</option>
                <option value="date">Tìm theo ngày vào làm</option>
            </select>
            
            <!-- Tìm kiếm theo tên -->
            <input type="text" name="search" class="form-control" placeholder="Nhập tên nhân viên" id="searchInput">
            
            <!-- Tìm kiếm theo ngày vào làm trong khoảng thời gian -->
            <input type="date" name="startDate" class="form-control d-none" id="startDate" placeholder="Ngày bắt đầu">
            <input type="date" name="endDate" class="form-control d-none" id="endDate" placeholder="Ngày kết thúc">
            
            <button type="submit" class="btn btn-success mx-1 flex-grow-1">Tìm kiếm</button>
            <a href="index.php?controller=Employee&action=listEmployees" class="btn btn-secondary mx-1">
                <i class="bi bi-arrow-left-circle"></i> Quay lại
            </a>
        </form>
            
            <div class="d-flex flex-grow-1 me-2">
                <button id= "exportExcel" class="btn btn-success mx-1 flex-grow-1">Xuất Excel</button>
                <button type="button" class="btn btn-success mx-1 flex-grow-1" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Thêm Nhân Viên</button>
            </div>
            <form>
            
            </form>
        </div>

        <table class="table table-bordered table-hover table-striped" id="employeeTbl">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Tên Nhân viên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Ngày vào làm</th>
                    <th>Lương</th>
                    <th>Tài khoản</th>
                    <th>Quyền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($employees)): ?>
                    <?php foreach ($employees as $employee): ?>
                        <tr class="text-center">
                            <td><?php echo $employee['id_nhanvien']; ?></td>
                            <td><?php echo $employee['tenNV']; ?></td>
                            <td><?php echo $employee['email']; ?></td>
                            <td><?php echo $employee['sdt']; ?></td>
                            <td><?php echo $employee['ngayvaolam']; ?></td>
                            <td><?php echo number_format($employee['luong'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo $employee['taikhoan']; ?></td>
                            <td><?php echo $employee['quyen'] == 0 ? 'Admin' : 'Nhân viên'; ?></td>
                            <td>
                                <button class="btn option-btn btn-sm" data-bs-toggle="modal" data-bs-target="#updateEmployeeModal<?php echo $employee['id_nhanvien']; ?>">Sửa</button>
                                <form action="index.php?controller=Employee&action=deleteEmployee&id=<?php echo $employee['id_nhanvien']; ?>" method="POST" style="display:inline;">
                                    <button type="submit" class="btn delete-btn btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');">Xóa</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Sửa Nhân Viên -->
                        <div class="modal fade" id="updateEmployeeModal<?php echo $employee['id_nhanvien']; ?>" tabindex="-1" aria-labelledby="updateEmployeeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sửa Nhân Viên</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="index.php?controller=Employee&action=updateEmployee&id=<?php echo $employee['id_nhanvien']; ?>" method="POST">
                                            <div class="mb-3">
                                                <label for="tenNV" class="form-label">Tên Nhân Viên:</label>
                                                <input type="text" name="tenNV" class="form-control" value="<?php echo $employee['tenNV']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email:</label>
                                                <input type="email" name="email" class="form-control" value="<?php echo $employee['email']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sdt" class="form-label">Số Điện Thoại:</label>
                                                <input type="text" name="sdt" class="form-control" value="<?php echo $employee['sdt']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ngayvaolam" class="form-label">Ngày Vào Làm:</label>
                                                <input type="date" name="ngayvaolam" class="form-control" value="<?php echo $employee['ngayvaolam']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="luong" class="form-label">Lương:</label>
                                                <input type="number" name="luong" class="form-control" value="<?php echo $employee['luong']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="taikhoan" class="form-label">Tài Khoản:</label>
                                                <input type="text" name="taikhoan" class="form-control" value="<?php echo $employee['taikhoan']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="matkhau" class="form-label">Mật Khẩu:</label>
                                                <input type="password" name="matkhau" class="form-control" placeholder="Để trống nếu không thay đổi">
                                            </div>
                                            <div class="mb-3">
                                                <label for="quyen" class="form-label">Quyền:</label>
                                                <select name="quyen" class="form-select" required>
                                                    <option value="0" <?php echo $employee['quyen'] == 0 ? 'selected' : ''; ?>>Admin</option>
                                                    <option value="1" <?php echo $employee['quyen'] == 1 ? 'selected' : ''; ?>>Nhân viên</option>
                                                </select>
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
                        <td colspan="9" class="text-center">Không có nhân viên nào để hiển thị.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal Thêm Nhân Viên -->
        <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Nhân Viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="index.php?controller=Employee&action=addEmployee" method="POST">
                        <div class="mb-3">
                                <label for="id_nhanvien" class="form-label">Mã Nhân Viên:</label>
                                <input type="text" id="id_nhanvien" name="id_nhanvien" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="tenNV" class="form-label">Tên Nhân Viên:</label>
                                <input type="text" id="tenNV" name="tenNV" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="sdt" class="form-label">Số Điện Thoại:</label>
                                <input type="text" id="sdt" name="sdt" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="ngayvaolam" class="form-label">Ngày Vào Làm:</label>
                                <input type="date" id="ngayvaolam" name="ngayvaolam" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="luong" class="form-label">Lương:</label>
                                <input type="number" id="luong" name="luong" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="taikhoan" class="form-label">Tài Khoản:</label>
                                <input type="text" id="taikhoan" name="taikhoan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="matkhau" class="form-label">Mật Khẩu:</label>
                                <input type="password" id="matkhau" name="matkhau" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="quyen" class="form-label">Quyền:</label>
                                <select name="quyen" class="form-select" required>
                                    <option value="0">Admin</option>
                                    <option value="1">Nhân viên</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const searchType = document.getElementById('searchType');
        const searchInput = document.getElementById('searchInput');
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');

        function toggleSearchFields() {
            if (searchType.value === 'name') {
                // Hiển thị tìm kiếm theo tên
                searchInput.classList.remove('d-none');
                startDate.classList.add('d-none');
                endDate.classList.add('d-none');
                searchInput.value = ''; // Đặt lại giá trị
                startDate.value = '';   // Đặt lại giá trị
                endDate.value = '';     // Đặt lại giá trị
            } else {
                // Hiển thị tìm kiếm theo ngày vào làm
                searchInput.classList.add('d-none');
                startDate.classList.remove('d-none');
                endDate.classList.remove('d-none');
                startDate.value = '';   // Đặt lại giá trị
                endDate.value = '';     // Đặt lại giá trị
            }
        }

        toggleSearchFields(); // Hiển thị input ban đầu

        searchType.addEventListener('change', toggleSearchFields);
        
        document.getElementById('exportExcel').addEventListener('click', function() {
           
            let tableId = 'employeeTbl'; 
            
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
        XLSX.writeFile(workbook, 'DanhSachNhanVien.xlsx');
    }
 });

    </script>
<script src="public/js/admin_script.js"></script>

</body>
</html>