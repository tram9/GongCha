<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>GongCha - Tin Tức</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="public/css/style.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

   <style>
        .news-item {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .news-item:hover {
            transform: scale(1.02);
        }

        .news-item h5 {
            width: 100%;
            height: 50px;
            font-size: 15px;
            margin: 0;
        }

        .news-item img {
            width: 100%; /* Đặt chiều rộng ảnh 100% */
            height: auto;
            object-fit: cover;
        }

        .news-content h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #c32032;
        }

        .news-content p {
            color: #666;
        }

        .news-meta {
            font-size: 0.9em;
            color: #999;
        }
        .btn {
            background-color: var(--red);
            color:var(--black);
            border:var(--border);
            line-height:4rem;
            cursor: pointer;
            font-size: 2rem;
        }
        .btn:hover {
            background-color: var(--red);
            border:var(--border);
        }
    </style>
</head>
<body>



<section>
    <div class="container">
        <h1 class="title text-center">Tin Tức</h1>
        <div class="row">
            <form action="" method="GET" class="row">
                <?php if (!empty($news)): ?>
                    <?php foreach ($news as $fetch_news): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                        <div class="news-item" data-toggle="modal" data-target="#newsModal<?= $fetch_news['id_tintuc']; ?>" data-id="<?= $fetch_news['id_tintuc']; ?>"> <!-- Thêm data-id ở đây -->
                            <img src="public/images/tintuc/<?= htmlspecialchars($fetch_news['anh']); ?>" alt="News Image" class="img-fluid">
                            <div class="news-content p-3">
                                <h5 class="h5"><?= htmlspecialchars($fetch_news['tieude']); ?></h5>
                                <p><?= htmlspecialchars(mb_substr($fetch_news['mota'], 0, 50)); ?><?= (strlen($fetch_news['mota']) > 50) ? '...' : ''; ?></p>
                                    <div class="news-meta d-flex justify-content-between mt-3">
                                        
                                        <span><?= date('d/m/Y', strtotime($fetch_news['ngaydang'])); ?></span>
                                    </div>
                            </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="newsModal<?= $fetch_news['id_tintuc']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?= $fetch_news['id_tintuc']; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel<?= $fetch_news['id_tintuc']; ?>"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="public/images/tintuc/<?= htmlspecialchars($fetch_news['anh']); ?>" alt="News Image" class="img-fluid mb-3">
                                            <div class="editor"><?= htmlspecialchars_decode($fetch_news['noidung']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty text-center">No news available!</p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</section>

<?php include 'view/user/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="public/js/script.js"></script>

<script>
$(document).ready(function() {
    $('.news-item').click(function() {
        var id_tintuc = $(this).data('id'); // Lấy id_tintuc từ data attribute

        // // Gửi yêu cầu AJAX để cập nhật lượt xem
        // $.ajax({
        //     url: '/GongCha/controller/user/NewsController.php?action=viewNews&id=' + id_tintuc, // Đường dẫn chính xác đến controller
        //     method: 'GET',
        //     success: function(response) {
        //         // Hiển thị thông tin chi tiết tin tức trong modal
        //         $('#modalLabel' + id_tintuc).text(response.tieude);
        //         $('#newsModal' + id_tintuc + ' .editor').html(response.noidung);
        //         $('#newsModal' + id_tintuc).modal('show'); // Hiện modal
        //     },
        //     error: function() {
        //         alert('Có lỗi xảy ra!');
        //     }
        // });
    });
});
</script>

<script>
var swiper = new Swiper(".hero-slider", {
    loop: true,
    grabCursor: true,
    effect: "flip",
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});
</script>

</body>
</html>

