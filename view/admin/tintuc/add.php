<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tin Tức</title>
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
    </style>
</head>
<body>

<div class="container">
    <h1>Thêm Tin Tức</h1>
    <form action="index.php?controller=News&action=create" method="POST" enctype="multipart/form-data">
        <label for="tieude">Tiêu đề:</label>
        <input type="text" id="tieude" name="tieude" required>

        <label for="mota">Mô tả:</label>
        <textarea id="mota" name="mota" rows="4"></textarea>

        <label for="anh">Ảnh:</label>
        <input type="file" id="anh" name="anh" accept="image/*">

        <label for="trang_thai">Trạng thái:</label>
        <select id="trang_thai" name="trang_thai">
            <option value="Xuất bản">Xuất bản</option>
            <option value="Bản nháp">Bản nháp</option>
        </select>

        <label for="id_nhanvien">Chọn Nhân Viên:</label>
        <select id="id_nhanvien" name="id_nhanvien" required>
            <option value="">--- Chọn Nhân Viên ---</option>
            <?php foreach ($nhanvien as $nv): ?>
                <option value="<?= $nv['id_nhanvien']; ?>"><?= $nv['tenNV']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="noidung">Nội dung:</label>
        <div id="editor" class="editor"></div>
        <input type="hidden" id="noidung" name="noidung">

        <input type="submit" value="Lưu Tin Tức">
        <button onclick="window.location.href='index.php?controller=News&action=index';">Hủy</button>
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