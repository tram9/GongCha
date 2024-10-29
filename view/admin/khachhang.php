<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khách hàng</title>
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
</head>
<body>
    <div class="container">
        <h1>Khách hàng</h1>
        <!-- Thanh tìm kiếm -->
        <div class="search-container">
            <form method="GET" action="">
                <select name="searchBy" onchange="toggleSearchInput()">
                    <option value="username" <?php echo ($searchBy == 'username') ? 'selected' : ''; ?>>username</option>
                    <option value="hoten" <?php echo ($searchBy == 'hoten') ? 'selected' : ''; ?>>Họ tên</option>
                    <option value="sdt" <?php echo ($searchBy == 'sdt') ? 'selected' : ''; ?>>Số điện thoại</option>
                    <option value="diachi" <?php echo ($searchBy == 'diachi') ? 'selected' : ''; ?>>Địa chỉ</option>
                </select>

                <input type="text" name="search" id="search" placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>" >
                <input type="submit" style="background-color: gray;" value="Tìm kiếm">
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>username</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($khach)): ?>
                    <tr><td colspan="9">Không có khách hàng nào để hiển thị.</td></tr>
                <?php else: ?>
                    <?php foreach ($khach as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['username']); ?></td>
                            <td><?php echo htmlspecialchars($item['hoten']); ?></td>
                            <td><?php echo htmlspecialchars($item['sdt']); ?></td>
                            <td><?php echo htmlspecialchars($item['diachi']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="public/js/admin_script.js"></script>
</body>
</html>