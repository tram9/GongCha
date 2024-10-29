<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Css Styles -->
    <link rel="stylesheet" href="././public/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="././public/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="././public/css/style-thao.css" type="text/css">
    <link rel="stylesheet" href="././public/css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Thư viện jQuery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <style>
         .date-inputs {
            display: none; 
            align-items: center; 
        }
        .date-inputs span {
            margin-right: 10px;
            font-size: 14px;
        }
        .date-inputs input {
            margin-right: 10px; 
            font-size: 14px; 
            padding: 5px; 
        }
        #select-date-button {
            display: flex;
            align-items: center; 
            cursor: pointer; 
            font-size: 14px; 
            padding: 10px;
        }
        .select-date-icon {
            margin-right: 5px; 
        }
        .container {
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin: 5px 0px; 
            padding: 5px;
        }
        .search-bar {
            flex: 1; 
            margin-right: 10px; 
        }
        #search-button {
            border-radius: 5px; 
            margin: 0px 10px; 
            padding: 8px 12px; 
        }
        #export-button {
            border-radius: 8px; 
            padding: 8px 12px; 
            margin-top: 10px;
        }
      
    </style>
</head>
<body>
<?php require_once 'header.php'; ?>
<section class="order">
    <div class='app-title'>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item active" data-target="#allOrders"><a href="./orderadmin"><b>Tất cả đơn hàng</b></a></li>
            <li class="breadcrumb-item" data-target="#deliveringOrders"><b>Đang giao</b></li>
            <li class="breadcrumb-item" data-target="#completedOrders"><b>Đã giao</b></li>
        </ul>
    </div>
    <div class="search-bar">
        <button class="btnsearch btn-primary" id="openDrawer">Tìm kiếm</button>
        <div class="statistic-button">
            <button id="exportExcel" class="export-button">Xuất excel</button>
        </div>
    </div>
    <div id="searchInfo" class="search-info"></div>

    <div id="recordCount" style="margin-left: 7px;margin-bottom: 3px; font-weight: bold; font-size: 14px;">Tổng số đơn hàng: 0 </div>
    <div id="allOrders" class="tab-content active">
        <table id="orderTable">
            <thead class="order_admin">
                <tr>
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
            <?php $stt =1; ?>
            <?php foreach ($data['allOrders'] as $order): ?>
                <tr class="order-row admin">
                    <td><?= $stt++; ?> </td> 
                    <td><?= $order['id_DatHang'] ?> </td>
                    <td><?= $order['tenKH'] ?> </td>
                    <td><?= $order['sdt'] ?> </td>
                    <td><?= $order['diaChi'] ?> </td>
                    <?php $date = new DateTime($order['ngayDat']);
                    $formattedDate = $date->format('d/m/Y H:i:s');?>
                    <td><?= $formattedDate; ?> </td>
                    <td><?= number_format($order['tongTien'], 0, ',', ',') ?> </td>
                    <td>
                        <button class="status-button" 
                                data-status="<?= htmlspecialchars($order['tinhTrang'], ENT_QUOTES, 'UTF-8') ?>" 
                                data-id="<?= htmlspecialchars($order['id_DatHang'], ENT_QUOTES, 'UTF-8') ?>" 
                                style="padding: 5px; color: #fff; background-color: <?= $order['tinhTrang'] == 'Đang giao' ? 'orange' : 'green'; ?>; border: none; border-radius: 5px; cursor: pointer;">
                            <?= htmlspecialchars($order['tinhTrang'], ENT_QUOTES, 'UTF-8') ?>
                        </button>
                    </td>

                    <td>
                        <a href="./orderadmin/orderDetail/<?= $order['id_DatHang']?>"><i class="fa-sharp fa-solid fa-pen-to-square" style="color: #288ae6;" title="Chi tiết"></i></a>
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
            <input type="text" placeholder="Nhập mã đơn hàng" id="orderId" class="form-control">
        </div>
        <div class="input-group">
            <input type="text" placeholder="Nhập tên khách hàng" id="customerName" class="form-control">
        </div>
        <div class="input-group">
            <input type="text" placeholder="Nhập địa chỉ" id="address" class="form-control">
        </div>
        <div class="input-group">
            <select id="sales-channel" class="form-control">
                <option value="" disabled selected hidden>Trạng thái đơn</option>
                <option value="Đang giao">Đang giao</option>
                <option value="Đã giao">Đã giao</option>
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

    <div id="deliveringOrders" class="tab-content">
        <table id='deliverOrder'>
            <thead class="order_admin">
                <tr>
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
            <?php $stt =1; ?>
            <?php foreach ($data['deliveringOrders'] as $order): ?>
                <tr class="order-row admin">
                    <td><?= $stt++; ?></td> 
                    <td><?= $order['id_DatHang'] ?> </td>
                    <td><?= $order['tenKH'] ?> </td>
                    <td><?= $order['sdt'] ?> </td>
                    <td><?= $order['diaChi'] ?> </td>
                    <?php $date = new DateTime($order['ngayDat']);
                    $formattedDate = $date->format('d/m/Y H:i:s');?>
                    <td><?= $formattedDate; ?> </td>
                    <td><?= number_format($order['tongTien'], 0, ',', ',') ?> </td>
                    <td>
                        <a href="./orderadmin/orderDetail/<?= $order['id_DatHang']?>"><i class="fa-sharp fa-solid fa-pen-to-square" style="color: #288ae6;" title="Chi tiết"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="completedOrders" class="tab-content">
        <table id= "completedOrder">
            <thead class="order_admin">
                <tr>
                <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
            <?php $stt =1; ?>
            <?php foreach ($data['shippedOrders'] as $order): ?>
                <tr class="order-row admin">
                    <td><?= $stt++; ?></td> 
                    <td><?= $order['id_DatHang'] ?> </td>
                    <td><?= $order['tenKH'] ?> </td>
                    <td><?= $order['sdt'] ?> </td>
                    <td><?= $order['diaChi'] ?> </td>
                    <?php $date = new DateTime($order['ngayDat']);
                    $formattedDate = $date->format('d/m/Y H:i:s');?>
                    <td><?= $formattedDate; ?> </td>
                    <td><?= number_format($order['tongTien'], 0, ',', ',') ?> </td>
                    <td>
                        <a href="./order/orderDetail/<?= $order['id_DatHang']?>"><i class="fa-sharp fa-solid fa-pen-to-square" style="color: #288ae6;" title="Chi tiết"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script>
    // visible/hidden search
    updateTotalOrders('#allOrders');
    const tabs = document.querySelectorAll('.breadcrumb-item');
    const contents = document.querySelectorAll('.tab-content');
    const searchBar = document.querySelector('.search-bar'); // Thanh tìm kiếm
    const totalOrdersDisplay = document.querySelector('#recordCount');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Bỏ kích hoạt tab hiện tại
            tabs.forEach(item => item.classList.remove('active'));
            contents.forEach(content => content.classList.remove('active'));

            // Kích hoạt tab mới
            tab.classList.add('active');
            const target = document.querySelector(tab.getAttribute('data-target'));
            target.classList.add('active');

            // Ẩn/Hiển thị thanh tìm kiếm
            if (tab.getAttribute('data-target') === '#allOrders') {
                searchBar.style.display = 'flex'; 
            } else {
                searchBar.style.display = 'none'; 
            }
            updateTotalOrders(tab.getAttribute('data-target'));

        });
    });
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
    $('#orderId, #customerName, #address, #sales-channel, #start-date, #end-date').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault(); // Ngăn chặn hành động mặc định
            performSearch();
            $('#searchDrawer').removeClass('open'); // Đóng popup
            $('#overlay').hide(); // Ẩn overlay
        }
    });
    function performSearch() {
        const orderId = $('#orderId').val();
        const customerName = $('#customerName').val();
        const address = $('#address').val();
        const salesChannel = $('#sales-channel').val();
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();

        // Kiểm tra xem có tiêu chí tìm kiếm nào không
        if (!orderId && !customerName && !address && !salesChannel && !startDate && !endDate) {
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
            orderId: orderId,
            customerName: customerName,
            address: address,
            salesChannel: salesChannel,
            startDate: startDate,
            endDate: endDate,
        };

        // Hiện kết quả nhập tìm kiếm dưới dạng nút
        displaySearchInfo(orderId, customerName, address, salesChannel, startDate, endDate);

        $.ajax({
            url: 'orderadmin/action',
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

    function displaySearchInfo(orderId, customerName, address, salesChannel, startDate, endDate) {
        $('#searchInfo').empty(); // Xóa thông tin tìm kiếm cũ
        if (orderId) {
            $('#searchInfo').append(
                `<button class="btnsearch search-button" data-type="orderId">
                    Mã HĐ: ${orderId} <span class="close-button" data-type="orderId">&times;</span>
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
        if (type === 'orderId') {
            $('#orderId').val(''); // Đặt lại trường mã hóa đơn
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
        $('#orderId').val('');
        $('#customerName').val('');
        $('#address').val('');
        $('#sales-channel').val('');
        $('#start-date').val(''); // Đặt lại trường từ ngày
        $('#end-date').val('');
        $('#searchInfo').empty(); // Xóa thông tin tìm kiếm
        updateTable(<?= json_encode($data['allOrders']) ?>); // Hiển thị tất cả hóa đơn
    });
  
    function updateTotalOrders(tabId) {
        let totalOrders = 0;
        switch (tabId) {
            case '#allOrders':
                totalOrders = <?=$data['totalOrder']?>; // Lấy dữ liệu từ API hoặc nguồn nào đó
                break;
            case '#deliveringOrders':
                totalOrders = <?=$data['totalDeliver']?>; // Tổng số đơn hàng đang giao
                break;
            case '#completedOrders':
                totalOrders = <?=$data['totalComplete']?>; // Tổng số đơn hàng đã giao
                break;
        }
        // Cập nhật hiển thị tổng số đơn hàng
        updateRecordCount(totalOrders); // Cập nhật phần tử recordCount
    }
    // Hàm cập nhật tổng số đơn hàng
    function updateRecordCount(totalOrders) {
        const recordCountElement = document.getElementById('recordCount');
        recordCountElement.innerText = `Tổng số đơn hàng: ${totalOrders}`;
    }
    function updateTable(data) {
        var tableBody = $('#orderTable tbody');
        tableBody.empty(); // Xóa tất cả hàng trong bảng

        if (data.length > 0) {
            // Lặp qua từng kết quả và thêm hàng mới vào bảng
            data.forEach(function(order, index) {
                var date = new Date(order.ngayDat);
                var formattedDate = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
                var statusButton = `
                <button class="status-button" 
                        data-status="${order.tinhTrang}" 
                        data-id="${order.id_DatHang}" 
                        style="padding: 5px; color: #fff; background-color: ${order.tinhTrang === 'Đang giao' ? 'orange' : 'green'}; border: none; border-radius: 5px; cursor: pointer;">
                    ${order.tinhTrang}
                </button>
            `;
                var row = `
                    <tr class="order-row admin">
                        <td>${index + 1}</td>
                        <td>${order.id_DatHang}</td>
                        <td>${order.tenKH}</td>
                        <td>${order.sdt}</td>
                        <td>${order.diaChi}</td>
                        <td>${formattedDate}</td>
                        <td>${Number(order.tongTien.replace(/,/g, ''))?.toLocaleString('en-US', { minimumFractionDigits: 0 }) || '0'}</td>
                        <td>${statusButton}</td>
                        <td>
                            <a href="./orderadmin/orderDetail/${order.id_DatHang}">
                                <i class="fa-sharp fa-solid fa-pen-to-square" style="color: #288ae6;" title="Chi tiết"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tableBody.append(row); // Thêm hàng vào bảng
            });
        } else {
            // Nếu không tìm thấy kết quả, có thể hiển thị một thông báo
            tableBody.append('<tr><td colspan="9" style="text-align: center;">Không tìm thấy đơn hàng nào!</td></tr>');
            updateRecordCount(0);
            return;
        }
        updateRecordCount(data.length);
        bindStatusButtonClick();
    }
   
    $(document).ready(function() {
    // Khi nhấn nút chọn ngày, hiển thị các input ngày
    $('#select-date-button').on('click', function() {
        $('.date-inputs').toggle(); // Chuyển đổi hiển thị của các input ngày
    });

    // Khi nhấn nút tìm kiếm
    $('#search-button').on('click', function() {
        performAction('search');
    });

    // Gọi hàm tìm kiếm khi nhấn phím Enter trong trường tìm kiếm
    $('#search-input').on('keypress', function(e) {
        if (e.which === 13) { // Nếu phím Enter được nhấn
            e.preventDefault(); // Ngăn chặn hành động gửi form
            performAction('search');
        }
    });

    
    $(document).ready(function() {
        // Khi nhấn nút xuất Excel
        $('#exportExcel').on('click', function() {
            exportExcel(); // Gọi hàm xuất Excel
        });
    });
    function updateRecordCount(recordCount) {
        const recordCountElement = document.getElementById('recordCount');
        recordCountElement.textContent = `Tổng số đơn hàng: ${recordCount}`;
    }
    document.getElementById('exportExcel').addEventListener('click', function() {
        // Mặc định bảng là "Tất cả đơn hàng"
        let tableId = 'orderTable'; 
        if (document.getElementById('allOrders').classList.contains('active')) {
            tableId = 'orderTable'; 
        } else if (document.getElementById('deliveringOrders').classList.contains('active')) {
            tableId = 'deliverOrder'; 
        }else{
            tableId = 'completedOrder'; 
        }

        // Gọi hàm exportExcel với ID của bảng hiện tại
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
        XLSX.writeFile(workbook, 'DanhSachDonHang.xlsx');
    }
});

   


  
</script>
<script src="././public/js/admin_script.js"></script>

</body>
</html>

