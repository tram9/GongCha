<?php
// PHP code here if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- CSS Files -->
    <link rel="stylesheet" href="././public/css/bootstrap.min.css" type="text/css"> 
    <link rel="stylesheet" href="././public/css/font-awesome.min.css" type="text/css"> 
    <link rel="stylesheet" href="././public/css/style-thao.css" type="text/css"> 
    <link rel="stylesheet" href="././public/css/admin_style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css"> 

    <!-- JS Files -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script> 
</head>
<style>
    td:last-child, th:last-child {
        width: 50px; 
    }
    th:nth-child(4), td:nth-child(4) {
        width: 80px; 
    }
    th:nth-child(2), td:nth-child(2) {
        width: 80px; 
    }
    .back-link {
        text-decoration: none;  /* Bỏ gạch chân */
        color: #c32032;        
        font-size: 16px;
        cursor: pointer; 
    }
    .back-link:hover,
    .back-link:focus,
    .back-link:active {
        text-decoration: none;  /* Bỏ gạch chân khi hover, focus hoặc active */
        color: #c32032; /* Giữ nguyên màu sắc */
    }
</style>
<body>

<?php require_once 'header.php'; ?>
<section class="order">
    <div class='app-title'>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item active" data-target="#allOrders"><a href="http://localhost/GongCha/invoice" class="back-link"><b>Hóa đơn</b></a></li>
        </ul>
    </div>
    
    <div class="search-bar">
        <button class="btnsearch btn-primary" id="openDrawer">Tìm kiếm</button>
        <div class="statistic-button">
            <button id="exportExcel" class="export-button">Xuất excel</button>
        </div>
    </div>
    
    <div id="searchInfo" class="search-info"></div>
   
    <div id="recordCount" style="margin-left: 7px;margin-top: 3px; font-weight: bold; font-size: 14px;">Tổng số hóa đơn: <?=$data['totalOrder']?> </div>
    <div id="allOrders" class="tab-content active">
        <table id="orderTable">
            <thead class="order_admin">
                <tr>
                    <th>STT</th>
                    <th>Mã hóa đơn</th>
                    <th>Thời gian</th>
                    <th>Kênh bán</th>
                    <th>Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; ?>
                <?php foreach ($data['allOrders'] as $order): ?>
                    <tr class="order-row admin">
                        <td><?= $stt++;?></td> 
                        <td><?= $order['id_DatHang']; ?></td>
                        <td><?= (new DateTime($order['ngayDat']))->format('d/m/Y H:i'); ?></td>
                        <td><?= $order['loai'] ?></td>
                        <td><?= $order['tenKH'] ?></td>
                        <td><?= $order['sdt'] ?></td>
                        <td><?= $order['diaChi'] ?></td>
                        <td><?= number_format($order['tongTien'], 0, ',', ',') ?></td>
                        <td>
                            <a href="./invoice/invoiceDetail/<?= $order['id_DatHang']?>">
                                <i class="fa-sharp fa-solid fa-pen-to-square" style="color: #288ae6;" title="Chi tiết"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="drawer" id="searchDrawer">
        <div class="header-drawer">
            <h5>Tìm kiếm hóa đơn</h5>
            <button type="button" class="close" id="closeDrawer">&times;</button>
        </div>
        <div class="input-group">
            <input type="text" placeholder="Nhập mã hóa đơn" id="invoiceId" class="form-control">
        </div>
        <div class="input-group">
            <input type="text" placeholder="Nhập tên khách hàng" id="customerName" class="form-control">
        </div>
        <div class="input-group">
            <input type="text" placeholder="Nhập địa chỉ" id="address" class="form-control">
        </div>
        <div class="input-group">
            <select id="sales-channel" class="form-control">
                <option value="" disabled selected hidden>Chọn kênh bán</option>
                <option value="trực tiếp">Bán trực tiếp</option>
                <option value="online">Bán online</option>
            </select>
        </div>
        <div class="input-group">
            <div class="form-group">
                    <label for="fromDate" style="margin-left:10px; font-size: 14px">Từ ngày:</label>
                    <input type="date" class="form-control" id="start-date">
                </div>
                <div class="form-group">
                    <label for="toDate" style="margin-left:10px; font-size: 14px">Đến ngày:</label>
                    <input type="date" class="form-control" id="end-date">
                </div>
        </div>
        <div class="btn-group">
            <button type="button" class="popup-btn btn-primary" id="searchButton">Tìm kiếm</button>
            <button type="button" class="popup-btn btn-secondary" id="resetButton">Reset</button>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script>
   $(document).ready(function() {
    // Mở drawer khi nhấn nút tìm kiếm
    $('#openDrawer').on('click', function() {
        $('#searchDrawer').addClass('open');
        $('#overlay').show(); // Hiện overlay
    });

    // Đóng drawer
    $('#closeDrawer, #overlay').on('click', function() {
        $('#searchDrawer').removeClass('open');
        $('#overlay').hide(); // Ẩn overlay
    });

    // Xử lý khi nhấn nút tìm kiếm
    $('#searchButton').on('click', function() {
        performSearch();
        $('#searchDrawer').removeClass('open'); // Đóng popup
        $('#overlay').hide(); // Ẩn overlay
    });

    // Xử lý khi nhấn phím Enter trong form tìm kiếm
    $('#invoiceId, #customerName, #address, #sales-channel, #start-date, #end-date').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault(); // Ngăn chặn hành động mặc định
            performSearch();
            $('#searchDrawer').removeClass('open'); // Đóng popup
            $('#overlay').hide(); // Ẩn overlay
        }
    });

    function performSearch() {
        const invoiceId = $('#invoiceId').val();
        const customerName = $('#customerName').val();
        const address = $('#address').val();
        const salesChannel = $('#sales-channel').val();
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();

        // Kiểm tra xem có tiêu chí tìm kiếm nào không
        if (!invoiceId && !customerName && !address && !salesChannel && !startDate && !endDate) {
            alert('Vui lòng nhập ít nhất một tiêu chí tìm kiếm.');
            return; // Dừng thực hiện nếu không có tiêu chí
        }
        if (startDate && !endDate) {
            alert('Vui lòng chọn ngày kết thúc.');
            return;
        }
        if (!startDate && endDate) {
            alert('Vui lòng chọn ngày bắt đầu.');
            return;
        }

        if (startDate && endDate && startDate > endDate) {
            alert('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.');
            return;
        }

        const data = {
            action: 'search',
            invoiceId: invoiceId,
            customerName: customerName,
            address: address,
            salesChannel: salesChannel,
            startDate: startDate,
            endDate: endDate,
        };

        // Hiện kết quả nhập tìm kiếm dưới dạng nút
        displaySearchInfo(invoiceId, customerName, address, salesChannel, startDate, endDate);

        $.ajax({
            url: 'invoice/action',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                    console.log("Kết quả nhận được:", response); // In dữ liệu để kiểm tra
                    updateTable(response); // Gọi updateTable với dữ liệu đơn hàng
               
            },error: function(xhr, status, error) {
                console.error("Lỗi AJAX:", error);
            }
        });
    }

    function displaySearchInfo(invoiceId, customerName, address, salesChannel, startDate, endDate) {
        $('#searchInfo').empty(); // Xóa thông tin tìm kiếm cũ
        if (invoiceId) {
            $('#searchInfo').append(
                `<button class="btnsearch search-button" data-type="invoiceId">
                    Mã HĐ: ${invoiceId} <span class="close-button" data-type="invoiceId">&times;</span>
                </button>`
            );
        }
        if (customerName) {
            $('#searchInfo').append(
                `<button class="btnsearch search-button" data-type="customerName">
                    Tên KH: ${customerName} <span class="close-button" data-type="customerName">&times;</span>
                </button>`
            );
        }
        if (address) {
            $('#searchInfo').append(
                `<button class="btnsearch search-button" data-type="address">
                    Địa chỉ: ${address} <span class="close-button" data-type="address">&times;</span>
                </button>`
            );
        }
        if (salesChannel) {
            $('#searchInfo').append(
                `<button class="btnsearch search-button" data-type="salesChannel">
                    Kênh bán: ${salesChannel} <span class="close-button" data-type="salesChannel">&times;</span>
                </button>`
            );
        }
        if (startDate) {
            $('#searchInfo').append(
                `<button class="btnsearch search-button" data-type="startDate">
                    Từ ngày: ${startDate} <span class="close-button" data-type="startDate">&times;</span>
                </button>`
            );
        }
        if (endDate) {
            $('#searchInfo').append(
                `<button class="btnsearch search-button" data-type="endDate">
                    Đến ngày: ${endDate} <span class="close-button" data-type="endDate">&times;</span>
                </button>`
            );
        }

    }

    // Xử lý sự kiện nút x để xóa kết quả tìm kiếm và trường nhập liệu
    $(document).on('click', '.close-button', function() {
        const type = $(this).data('type');
        $(`.search-button[data-type="${type}"]`).remove(); // Xóa nút tương ứng

        // Đặt lại giá trị của trường nhập liệu tương ứng
        if (type === 'invoiceId') {
            $('#invoiceId').val(''); // Đặt lại trường mã hóa đơn
        } else if (type === 'customerName') {
            $('#customerName').val(''); // Đặt lại trường tên khách hàng
        } else if (type === 'address') {
            $('#address').val(''); // Đặt lại trường địa chỉ
        } else if (type === 'salesChannel') {
            $('#sales-channel').prop('selectedIndex', 0); // Đặt lại kênh bán
        }
        else if (type === 'startDate') {
            $('#start-date').val(''); // Đặt lại trường từ ngày
        } else if (type === 'endDate') {
            $('#end-date').val(''); // Đặt lại trường đến ngày
        }
        // Nếu không còn nút nào thì hiển thị bảng ban đầu
        if ($('#searchInfo').find('button').length === 0) {
            updateTable(<?= json_encode($data['allOrders']) ?>); // Hiển thị bảng ban đầu
        }
    });

    // Xử lý khi nhấn nút Reset
    $('#resetButton').on('click', function() {
        $('#invoiceId').val('');
        $('#customerName').val('');
        $('#address').val('');
        $('#sales-channel').val('');
        $('#start-date').val(''); // Đặt lại trường từ ngày
        $('#end-date').val('');
        $('#searchInfo').empty(); // Xóa thông tin tìm kiếm
        updateTable(<?= json_encode($data['allOrders']) ?>); // Hiển thị tất cả hóa đơn
    });
    
    function updateTable(data) {
        var tableBody = $('#orderTable tbody');
        tableBody.empty(); // Xóa tất cả hàng cũ trong bảng

        // Kiểm tra nếu không có dữ liệu
        if (!Array.isArray(data) || data.length === 0) {
            tableBody.append('<tr><td colspan="10" style="text-align: center;">Không tìm thấy đơn hàng nào!</td></tr>');
            updateRecordCount(0);
            return;
        }

        // Lặp qua từng kết quả và thêm hàng vào bảng
        data.forEach(function(order, index) {
            var date = new Date(order.ngayDat);
            var formattedDate = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
        var row = `
            <tr class="order-row admin">
                <td>${index + 1}</td>
                <td>${order.id_DatHang}</td>
                <td>${formattedDate}</td>
                <td>${order.loai}</td>
                <td>${order.tenKH}</td>
                <td>${order.sdt}</td>
                <td>${order.diaChi}</td>
                <td>${Number(order.tongTien.replace(/,/g, ''))?.toLocaleString('en-US', { minimumFractionDigits: 0 }) || '0'}</td>
                <td>
                    <a href="./invoice/invoiceDetail/${order.id_DatHang}">
                        <i class="fa-sharp fa-solid fa-pen-to-square" style="color: #288ae6;" title="Chi tiết"></i>
                    </a>
                </td>
            </tr>`;
            
            tableBody.append(row); // Thêm hàng mới vào bảng
        });
        updateRecordCount(data.length);
    }
    function updateRecordCount(recordCount) {
        const recordCountElement = document.getElementById('recordCount');
        recordCountElement.textContent = `Tổng số hóa đơn: ${recordCount}`;
    }
    $(document).ready(function() {
        // Khi nhấn nút xuất Excel
        $('#exportExcel').on('click', function() {
            exportExcel(); // Gọi hàm xuất Excel
        });
    });
    function exportExcel() {
        // Lấy bảng HTML
        var table = document.getElementById('orderTable');

        // Lấy tất cả các hàng của bảng
        var rows = table.getElementsByTagName('tr');
        var data = [];
        
        // Thêm tiêu đề vào mảng dữ liệu, bỏ qua cột cuối
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
        var worksheet = XLSX.utils.aoa_to_sheet(data); // Tạo sheet từ mảng
        var workbook = XLSX.utils.book_new(); // Tạo workbook mới
        XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

        // Định dạng tiêu đề
        const headerCellStyle = {
            font: { bold: true }, // In đậm tiêu đề
            alignment: { horizontal: "center" }, // Căn giữa
        };

        // Áp dụng định dạng cho các ô tiêu đề
        for (let i = 0; i < headers.length; i++) {
            const cellAddress = XLSX.utils.encode_cell({ c: i, r: 0 }); 
            worksheet[cellAddress].s = headerCellStyle; 
        }

        // Định dạng các cột (khoảng cách)
        worksheet["!cols"] = worksheet["!cols"] || []; 
        for (let i = 0; i < headers.length; i++) { // headers.length đã bỏ cột cuối
            worksheet["!cols"][i] = { wch: i === 7 ? 25 : 13 }; // Cột thứ 4 rộng hơn
        }

        // Xuất file Excel
        XLSX.writeFile(workbook, 'DanhSachHoaDon.xlsx');
    }

});

</script>


</body>
</html>
