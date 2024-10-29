<script>
    function confirmDelete(id) {
        if (confirm("Bạn có chắc chắn muốn xóa tin tức này không?")) {
            // Nếu người dùng chọn 'Có', chuyển hướng đến trang xóa
            window.location.href = 'index.php?controller=News&action=delete&id=' + id + '&confirm=true';
        }
    }
    </script>