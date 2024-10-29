<?php
// controller/user/NewsController.php

require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/config/connect.php'; // Đường dẫn tuyệt đối
require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/model/user/NewsModel.php'; // Cũng sử dụng đường dẫn tuyệt đối
require_once 'controller/user/headerController.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

class NewsController {
    private $newsModel;
    private $headerController;

    public function __construct($db) {
        $this->newsModel = new NewsModel($db);
        $this->headerController = new headerController($db);

    }

    public function displayNews() {
        // $news = $this->newsModel->getPublishedNews();
        // include $_SERVER['DOCUMENT_ROOT'] . '/GongCha/view/user/tintuc.php';
        $user_id = $_SESSION['user_id'] ?? '';
        $this->headerController->getHeaderData($user_id);

        $news = $this->newsModel->getPublishedNews(); // Gọi phương thức để lấy dữ liệu

        if ($news === false|| empty($news)) {
            echo 'Không có dữ liệu tin tức.';
            return; // Dừng thực thi nếu không có dữ liệu
        }
        
        include $_SERVER['DOCUMENT_ROOT'] . '/GongCha/view/user/tintuc.php'; // Chuyển dữ liệu đến view
    }
}

// $Newscontroller = new NewsController($conn);
// $Newscontroller->displayNews();

?>
