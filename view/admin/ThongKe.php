<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="././public/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="././public/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="././public/css/style-thao.css" type="text/css">
    <title>Thống kê</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="././public/css/admin_style.css">    

    <style>
        /* Định dạng cho Header */
        header {
            background-color: rgb(0, 28, 64);
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            padding-left: 70px;
        }

        /* Định dạng cho Sidebar */
        .sidebar {
            height: 100vh;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        /* Định dạng cho nội dung chính */
        .content {
            display: flex;
            justify-content: center; /* Căn giữa theo chiều ngang */
            align-items: center; /* Căn giữa theo chiều dọc nếu cần */
            flex-direction: column; /* Đặt hướng chiều của các phần tử con */
            margin-left: 60px; /* Khoảng cách bên trái cho nội dung để không đè lên sidebar */
            padding: 20px;
        }

        a.canvasjs-chart-credit {
            display: none;
        }

        body {
            font-size: 14px; /* Thiết lập kích thước chữ toàn bộ trang */
        }

        /* Định dạng cho các trường nhập và nút */
        .action .row {
            display: flex; /* Sử dụng flexbox cho hàng */
            gap: 20px; /* Khoảng cách giữa các phần tử trong hàng */
            align-items: center; /* Căn giữa theo chiều dọc */
            margin-bottom: 10px; /* Thêm khoảng cách dưới mỗi hàng */
        }

        /* Định dạng cho hàng đầu tiên chứa loại báo cáo */
        .action .row:first-child {
            margin-bottom: 20px; /* Thêm khoảng cách cho hàng đầu tiên */
        }

        /* Định dạng cho hàng chứa ngày và nút */
        .action .row:nth-child(2) {
            flex-wrap: wrap; /* Cho phép các phần tử wrap nếu không đủ không gian */
        }

        /* Định dạng cho nút */
        .action button {
            padding: 10px 10px; /* Thêm padding cho nút */
            font-size: 14px; /* Kích thước chữ cho nút */
            background-color: #007bff; /* Màu nền của nút */
            color: white; /* Màu chữ của nút */
            border: none; /* Không viền */
            border-radius: 4px; /* Bo tròn các góc của nút */
            cursor: pointer; /* Con trỏ sẽ là bàn tay khi hover */
            margin-top: -10px;
        }

        .action button:hover {
            background-color: #0056b3; /* Màu nền khi hover */
        }

        /* Định dạng cho các trường nhập */
        input[type="date"] {
            margin-left: 10px; /* Thêm khoảng cách giữa nhãn và trường nhập */
            margin-right: 10px; /* Thêm khoảng cách giữa các trường nhập */
            padding: 5px;
        }
        #chartContainer {
            height: 300px; 
            width: 99%; 
            margin-right: 60px; /* Dịch sang trái 20px */
            text-align: center;
            padding: 8px;
        }
        .action {
            display: flex; /* Flexbox cho action */
        }
        label {
            display: inline-block; /* Để căn chỉnh label và select trên cùng một hàng */
            width: 150px; /* Đặt chiều rộng cho label */
            margin-right: 8px; /* Khoảng cách giữa label và select */
        }
        select {
            width: 200px; /* Đặt chiều rộng cho select */
            padding: 5px; /* Thêm khoảng cách bên trong cho select */
            border-radius: 5px; /* Bo góc cho select */
            border: 1px solid #ccc; /* Viền cho select */
            font-size: 14px; /* Kích thước font cho select */
        }

    </style>
    <script>
        window.onload = function () {
            var dataPoints = [];
            var options = {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Thống kê doanh thu bán hàng"
                },
                axisX: {
                    valueFormatString: "DD MMM YYYY" // Định dạng ngày
                },
                axisY: {
                    title: "Tổng tiền bán (đ)",
                    titleFontSize: 24
                },
                data: [{
                    type: "spline",
                    yValueFormatString: "#,### đ",
                    dataPoints: dataPoints
                }]
    };
    function addData(data, reportType) {
        dataPoints.length = 0; // Xóa dữ liệu cũ
        for (var i = 0; i < data.length; i++) {
            dataPoints.push({
                x: new Date(data[i].date), // Chuyển đổi ngày thành đối tượng Date
                y: parseFloat(data[i].units) // Giá trị doanh thu
            });
        }
        // Cập nhật định dạng cho axisX dựa trên loại báo cáo
        options.axisX.valueFormatString = reportType === "daily" ? "DD MMM YYYY" : "MMM YYYY";

        $("#chartContainer").CanvasJSChart(options); // Cập nhật biểu đồ
    }
    document.getElementById("submitBtn").addEventListener("click", function () {
        var reportType = document.getElementById("reportType").value;
        var salesType = document.getElementById("salesType").value; // Lấy loại doanh thu
        var startDate = document.getElementById("startDate").value;
        var endDate = document.getElementById("endDate").value;

        // Kiểm tra xem người dùng đã chọn loại thời gian và khoảng thời gian chưa
        if (!reportType) {
            alert("Vui lòng chọn loại thời gian.");
            return;
        }
        if (!startDate || !endDate) {
            alert("Vui lòng chọn khoảng thời gian hợp lệ.");
            return;
        }

        // Thiết lập URL dựa trên loại báo cáo và loại doanh thu đã chọn
        var url;
        if (reportType === "daily") {
            url = `/GongCha/admin/thongkengay?startDate=${startDate}&endDate=${endDate}`;
        } else if (reportType === "monthly") {
            url = `/GongCha/admin/thongkethang?startDate=${startDate}&endDate=${endDate}`;
        }

        if (salesType) { // Kiểm tra nếu có loại doanh thu
            url += `&type=${salesType}`;
        }

        // Gọi API với URL đã thiết lập và xử lý dữ liệu nhận được
        $.getJSON(url, function(data) {
            addData(data, reportType); // Gọi addData với cả dữ liệu và loại báo cáo
        });
    });
};

    </script>
</head>

<body>
    <?php
        require_once 'header.php';
    ?>
    <!-- Header -->
    <header>
        Thống kê doanh thu bán hàng
    </header>
    <!-- Nội dung chính -->
    <div class="content">
       
        <div class="action">
            <div class="row">
                <div>
                    <label for="reportType">Loại thời gian: </label>
                    <select id="reportType" name="reportType">
                        <option value="" class="holder" disabled selected hidden>Chọn loại </option>
                        <option value="daily">Báo cáo theo ngày</option>
                        <option value="monthly">Báo cáo theo tháng</option>
                    </select>
                </div>
                <div>
                    <label for="salesType">Loại doanh thu:</label>
                    <select id="salesType" name="salesType">
                        <option value="" class="holder" disabled selected hidden>Doanh thu bán </option>
                        <option value="online">Bán Online</option>
                        <option value="trực tiếp">Bán Trực Tiếp</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div>
                    <label for="startDate">Ngày bắt đầu:</label>
                    <input type="date" id="startDate" name="startDate">
                </div>

                <div>
                    <label for="endDate">Ngày kết thúc:</label>
                    <input type="date" id="endDate" name="endDate">
                </div>

                <button id="submitBtn">Xem thống kê</button>
            </div>
        </div>

        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    </div>

    <!-- Script -->
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
</body>

</html>
