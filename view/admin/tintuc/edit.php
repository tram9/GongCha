<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Tin Tức</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="file"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .editor {
            height: 200px;
            margin-bottom: 15px;
        }
        .current-image {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Sửa Tin Tức</h1>
    <form action="index.php?controller=News&action=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $newsItem['id_tintuc']; ?>">

        <label for="tieude">Tiêu đề:</label>
        <input type="text" id="tieude" name="tieude" value="<?= htmlspecialchars($newsItem['tieude']); ?>" required>

        <label for="mota">Mô tả:</label>
        <textarea id="mota" name="mota" rows="4"><?= htmlspecialchars($newsItem['mota']); ?></textarea>

        <label for="anh">Ảnh hiện tại:</label>
        <div class="current-image">
            <img src="public/images/tintuc/<?= htmlspecialchars($newsItem['anh']); ?>" alt="Ảnh hiện tại" width="100">
        </div>
        <label for="anh">Chọn ảnh mới (nếu có):</label>
        <input type="file" id="anh" name="anh" accept="image/*">

        <label for="trang_thai">Trạng thái:</label>
        <select id="trang_thai" name="trang_thai">
            <option value="Xuất bản" <?= $newsItem['trang_thai'] === 'Xuất bản' ? 'selected' : ''; ?>>Xuất bản</option>
            <option value="Bản nháp" <?= $newsItem['trang_thai'] === 'Bản nháp' ? 'selected' : ''; ?>>Bản nháp</option>
        </select>

        <label for="id_nhanvien">Chọn Nhân Viên:</label>
        <select id="id_nhanvien" name="id_nhanvien" required>
            <option value="">--- Chọn Nhân Viên ---</option>
            <?php foreach ($nhanvien as $nv): ?>
                <option value="<?= $nv['id_nhanvien']; ?>" <?= $nv['id_nhanvien'] === $newsItem['id_nhanvien'] ? 'selected' : ''; ?>><?= $nv['tenNV']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="noidung">Nội dung:</label>
        <div id="editor" class="editor"><?= htmlspecialchars_decode($newsItem['noidung']); ?></div>
        <input type="hidden" id="noidung" name="noidung">

        <input type="submit" value="Cập nhật Tin Tức">
        <button onclick="window.location.href='index.php?controller=News&action=index';">Hủy</button>
        <a href=""></a>
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Khởi tạo Quill cho trường nội dung
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                ['link', 'image', 'code-block']
            ]
        }
    });

    // Khi gửi form, lưu nội dung vào trường ẩn
    document.querySelector('form').onsubmit = function() {
        var content = quill.root.innerHTML;
        document.querySelector('#noidung').value = content;
    };
</script>

</body>
</html>