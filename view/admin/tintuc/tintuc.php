<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tin tức</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="public/css/admin_style.css">
    <style>
        body {
            /* font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px; */
            font-size: 16px;
        }
        h1 {
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            color: white;
            background-color: gray;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .button:hover {
            background-color: #218838;
        }
        .search-container {
            margin: 20px 0;
            display: flex;
            align-items: center;
        }
        select, input[type="text"], input[type="submit"] {
            margin-right: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-links{
            display: flex;
        }
        .action-links button {
            /* display: inline-block; */
            padding: 10px 15px;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 10px;
            margin-top: 10px;
            background-color: darkgray;
            justify-content: center;
            align-items: center;
        }
        .action-links button:hover {
            color: yellow;
            background-color: green;
        }
    </style>
    <script>
        function toggleSearchInput() {
            const searchBy = document.querySelector('select[name="searchBy"]');
            const statusSelect = document.getElementById('statusSelect');
            const searchInput = document.getElementById('search');
            if (searchBy.value === 'trang_thai') {
                searchInput.style.display = 'none';
                statusSelect.style.display = 'inline';
            } else {
                searchInput.style.display = 'inline';
                statusSelect.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Quản lý Tin tức</h1>
        <!-- Nút thêm tin tức -->
        <a href="index.php?controller=News&action=add" class="button">Thêm Tin Tức</a>
        <!-- Thanh tìm kiếm -->
        <div class="search-container">
            <form >
                <select name="searchBy" onchange="toggleSearchInput()">
                    <option value="tieude" <?php echo ($searchBy == 'tieude') ? 'selected' : ''; ?>>Tiêu đề</option>
                    <option value="mota" <?php echo ($searchBy == 'mota') ? 'selected' : ''; ?>>Mô tả</option>
                    <option value="trang_thai" <?php echo ($searchBy == 'trang_thai') ? 'selected' : ''; ?>>Trạng thái</option>
                    <option value="ngaydang" <?php echo ($searchBy == 'ngaydang') ? 'selected' : ''; ?>>Ngày đăng</option>
                    <option value="luotxem" <?php echo ($searchBy == 'luotxem') ? 'selected' : ''; ?>>Lượt xem</option>
                    <option value="tenNV" <?php echo ($searchBy == 'tenNV') ? 'selected' : ''; ?>>Tên nhân viên</option>
                </select>

                <select name="status" id="statusSelect" style="display: <?php echo ($searchBy == 'trang_thai') ? 'inline' : 'none'; ?>;">
                    <option value="">Tất cả</option>
                    <option value="Xuất bản" <?php echo ($search == 'Xuất bản') ? 'selected' : ''; ?>>Xuất bản</option>
                    <option value="Bản nháp" <?php echo ($search == 'Bản nháp') ? 'selected' : ''; ?>>Bản nháp</option>
                </select>

                <input type="text" name="search" id="search" placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>" style="display: <?php echo ($searchBy == 'trang_thai') ? 'none' : 'inline'; ?>;">
                <input type="submit" style="background-color: gray;" value="Tìm kiếm">
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Ảnh</th>
                    <th>Trạng thái</th>
                    <th>Ngày đăng</th>
                    <th>Tên nhân viên</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($news)): ?>
                    <tr><td colspan="9">Không có tin tức nào để hiển thị.</td></tr>
                <?php else: ?>
                    <?php foreach ($news as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['id_tintuc']); ?></td>
                            <td><?php echo htmlspecialchars($item['tieude']); ?></td>
                            <td><?php echo htmlspecialchars($item['mota']); ?></td>
                            <td><img width="100" height="100" src="public/images/tintuc/<?= htmlspecialchars($item['anh']); ?>" alt=""></td>
                            <td><?php echo htmlspecialchars($item['trang_thai']); ?></td>
                            <td><?php echo htmlspecialchars($item['ngaydang']); ?></td>
                            <td><?php echo htmlspecialchars($item['tenNV']); ?></td>
                            <td class="action-links">
                                <button onclick="window.location.href='index.php?controller=News&action=edit&id=<?= $item['id_tintuc']; ?>'" class="btn btn-edit">Sửa</button>
                                <form action="index.php?controller=News&action=delete&id=<?= $item['id_tintuc']; ?>" method="POST" style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa tin tức này?');">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="public/js/admin_script.js"></script>
</body>
</html>