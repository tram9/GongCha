<!DOCTYPE HTML>
<html>

<head>
    <style>
        /* Định dạng cho Header */
        header {
            background-color: rgb(0, 28, 64);
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            padding-left: 230px !important;
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
            margin-left: 220px;
            /* Khoảng cách bên trái cho nội dung để không đè lên sidebar */
            padding: 20px;
        }
        
        a.canvasjs-chart-credit{
            display: none;
        }

        .action {
            padding: 20px 30px 40px 30px;
            display: flex;
            gap: 20px;
        }

    </style>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    <script>
        window.onload = function() {
            var dataPoints = [];

            var options = {
                animationEnabled: true,
                title: {
                    text: "Top sản phẩm bán chạy nhất" // Tiêu đề ban đầu
                },
                axisY: {
                    title: "Số lượng bán",
                    suffix: " sp"
                },
                axisX: {
                    title: "Sản phẩm"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0 sp",
                    dataPoints: dataPoints
                }]
            };

            function fetchTopProducts(limit) {
                $.ajax({
                    url: '/CHVanPhongPham/CheckoutController/thongkeSP?limit=' + limit,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        dataPoints.length = 0;
                        $.each(data, function(index, product) {
                            dataPoints.push({
                                label: product.label,
                                y: product.y
                            });
                        });

                        // Lấy giá trị từ ô input
                        var limit = document.getElementById("productLimit").value;

                        // Cập nhật tiêu đề của biểu đồ
                        options.title.text = "Top " + limit + " sản phẩm bán chạy nhất";

                        // Vẽ lại biểu đồ với dữ liệu mới
                        $("#chartContainer").CanvasJSChart(options);
                    },
                    error: function(xhr, status, error) {
                        alert("Có lỗi xảy ra khi lấy dữ liệu: " + error);
                    }
                });
            }

            document.getElementById("statBtn").addEventListener("click", function() {
                var limit = parseInt(document.getElementById("productLimit").value);
                if (isNaN(limit) || limit <= 0) {
                    alert("Vui lòng nhập một số hợp lệ.");
                } else {
                    fetchTopProducts(limit);
                }
            });
        }
    </script>
</head>

<body>
    <?php
    include "header.php";
    include "Left_side.php";
    ?>
    <header>
        Thống kê top sản phẩm bán chạy
    </header>
    <div class="content">
        <div class="action">
            <div>
                <label for="productLimit">Số lượng sản phẩm:</label>
                <input type="number" id="productLimit" name="productLimit" min="1" placeholder="Nhập số lượng">
            </div>
            <button id="statBtn">Thống kê</button>
        </div>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>

    </div>
</body>

</html>