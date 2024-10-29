<?php
// controller/admin/NewsController.php

require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/config/connect.php'; // Đường dẫn tuyệt đối
require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/model/admin/News.php'; // Cũng sử dụng đường dẫn tuyệt đối
require_once 'controller/admin/HeaderController.php';


class NewsController {
    private $newsModel;
    private $headerController;

    public function __construct($db) {
        $this->newsModel = new News($db);
        $this->headerController = new HeaderController($db);

    }

    // Hiển thị danh sách tin tức
    public function tintuc() {
        $admin_id = $_SESSION['id_nhanvien'];
        $this->headerController->displayHeader($admin_id);

        $search = isset($_POST['search']) ? $_POST['search'] : ''; // Lấy giá trị tìm kiếm
        $searchBy = isset($_POST['searchBy']) ? $_POST['searchBy'] : 'tieude'; // Mặc định tìm theo tiêu đề

        // Nếu tìm kiếm theo trạng thái
        if ($searchBy == 'trang_thai') {
            $search = isset($_POST['status']) ? $_POST['status'] : ''; // Lấy giá trị từ combobox trạng thái
        }

        $news = $this->newsModel->getAllNews($search, $searchBy); // Lấy dữ liệu tin tức
        require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/view/admin/tintuc/tintuc.php'; // Gọi view
    }
    
    // Hiển thị trang thêm tin tức
    public function add() {
        $nhanvien = $this->newsModel->getEmployees(); // Lấy danh sách nhân viên
        require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/view/admin/tintuc/add.php'; // Gọi view
    }

    // Xử lý thêm tin tức
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Lấy dữ liệu từ form
                $tieude = $_POST['tieude'];
                $mota = $_POST['mota'];
                $trang_thai = $_POST['trang_thai'];
                $noidung = $_POST['noidung'];
                $id_nhanvien = $_POST['id_nhanvien'];

                // Xử lý upload ảnh
                $anh = null;
                if (isset($_FILES['anh']) && $_FILES['anh']['error'] === UPLOAD_ERR_OK) {
                    $targetDir = "public/images/tintuc/"; // Cập nhật đường dẫn

                    // Kiểm tra và tạo thư mục nếu không tồn tại
                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0755, true); // Tạo thư mục với quyền 755
                    }

                    $anh = basename($_FILES['anh']['name']);
                    $targetFilePath = $targetDir . $anh;

                    // Kiểm tra loại file
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                    $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];

                    if (!in_array($fileType, $allowedTypes)) {
                        throw new Exception("Chỉ cho phép upload các file ảnh có định dạng JPG, JPEG, PNG, GIF.");
                    }

                    // Di chuyển tệp tải lên vào thư mục uploads
                    if (!move_uploaded_file($_FILES['anh']['tmp_name'], $targetFilePath)) {
                        throw new Exception("Lỗi khi tải lên ảnh.");
                    }
                }

                // Thêm dữ liệu vào cơ sở dữ liệu
                $this->newsModel->addNews([
                    'tieude' => $tieude,
                    'mota' => $mota,
                    'anh' => $anh,
                    'trang_thai' => $trang_thai,
                    'noidung' => $noidung,
                    'id_nhanvien' => $id_nhanvien
                ]);

                header('Location: index.php?controller=News&action=index');
                exit();
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }

    // Hiển thị form sửa tin tức
    public function edit($id) {
        $newsItem = $this->newsModel->getNewsById($id);
        if ($newsItem) {
            $nhanvien = $this->newsModel->getEmployees();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/view/admin/tintuc/edit.php';
        } else {
            // Xử lý khi không tìm thấy tin tức
            echo "Tin tức không tồn tại.";
        }
    }

    // Xử lý cập nhật tin tức
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Lấy dữ liệu từ form
                $tieude = $_POST['tieude'];
                $mota = $_POST['mota'];
                $trang_thai = $_POST['trang_thai'];
                $noidung = $_POST['noidung'];
                $id_nhanvien = $_POST['id_nhanvien'];
    
                // Lấy tin tức hiện tại
                $currentNews = $this->newsModel->getNewsById($id);
                $anh = null;
                // Xử lý upload ảnh
                if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                    $anh = $_FILES['anh']['name'];;
                    $targetDir = "public/images/tintuc/"; // Cập nhật đường dẫn
    
                    // Kiểm tra và tạo thư mục nếu không tồn tại
                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0755, true); // Tạo thư mục với quyền 755
                    }
    
                    $newFileName = basename($_FILES['anh']['name']);
                    $targetFilePath = $targetDir . $newFileName;
    
                    // Kiểm tra loại file
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                    $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
    
                    if (!in_array($fileType, $allowedTypes)) {
                        throw new Exception("Chỉ cho phép upload các file ảnh có định dạng JPG, JPEG, PNG, GIF.");
                    }
    
                    // Di chuyển tệp tải lên vào thư mục uploads
                    if (!move_uploaded_file($_FILES['anh']['tmp_name'], $targetFilePath)) {
                        throw new Exception("Lỗi khi tải lên ảnh.");
                    }
    
                    // Cập nhật biến $anh với tên file mới
                    $anh = $newFileName;
                }else{
                    $anh = $currentNews['anh'];
                }
    
                // Cập nhật dữ liệu vào cơ sở dữ liệu
                $this->newsModel->editNews(array_merge($_POST, ['id_tintuc' => $id, 'anh' => $anh]));
                header('Location: index.php?controller=News&action=index');
                exit();
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }

    // Xóa tin tức
    public function delete($id) {
        if ($this->newsModel->deleteNews($id)) {
            header('Location: index.php?controller=News&action=index');
            exit();
        } else {
            echo "Lỗi khi xóa tin tức.";
        }
    }

    // Tìm kiếm tin tức
    public function search() {
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $newsList = $this->newsModel->getAllNews($search);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/view/admin/news/index.php';
    }

    // RESTful API: List news
    public function apiListNews() {
        $news = $this->newsModel->getAllNews();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $news]);
    }

    public function apiGetNews($id) {
        $newsItem = $this->newsModel->getNewsById($id);
        if ($newsItem) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $newsItem]);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['success' => false, 'message' => 'Tin tức không tồn tại.']);
        }
    }

    // RESTful API: Create news
    public function apiCreateNews() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = json_decode(file_get_contents('php://input'), true);
                // Xử lý upload ảnh nếu có
                $anh = null;
                if (isset($_FILES['anh']) && $_FILES['anh']['error'] === UPLOAD_ERR_OK) {
                    $anh = $this->uploadImage($_FILES['anh']);
                }

                $this->newsModel->addNews(array_merge($data, ['anh' => $anh]));
                header('HTTP/1.1 201 Created');
                echo json_encode(['success' => true, 'message' => 'Tin tức đã được thêm thành công.']);
            } catch (Exception $e) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
    }

    // RESTful API: Update news
    public function apiUpdateNews($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            try {
                $data = json_decode(file_get_contents('php://input'), true);
                $currentNews = $this->newsModel->getNewsById($id);

                if (!$currentNews) {
                    header('HTTP/1.1 404 Not Found');
                    echo json_encode(['success' => false, 'message' => 'Tin tức không tồn tại.']);
                    return;
                }

                // Xử lý upload ảnh nếu có
                $anh = $currentNews['anh']; // Giữ ảnh cũ
                if (isset($_FILES['anh']) && $_FILES['anh']['error'] === UPLOAD_ERR_OK) {
                    $anh = $this->uploadImage($_FILES['anh']);
                }

                $this->newsModel->editNews(array_merge($data, ['id_tintuc' => $id, 'anh' => $anh]));
                echo json_encode(['success' => true, 'message' => 'Tin tức đã được cập nhật thành công.']);
            } catch (Exception $e) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
    }

    // // RESTful API: Add News
    // public function apiAddNews() {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     if (isset($data['tieude'], $data['mota'], $data['anh'], $data['trang_thai'], $data['noidung'], $data['id_nhanvien'], $data['ngaydang'])) {
          
    //         if ($this->newsModel->addNews($data['tieude'], $data['mota'], $data['anh'], $data['trang_thai'], $data['noidung'], $data['id_nhanvien'], $data['ngaydang'])) {
    //             http_response_code(201);
    //             echo json_encode(['success' => true, 'message' => 'News added successfully']);
    //         } else {
    //             http_response_code(400);
    //             echo json_encode(['success' => false, 'message' => 'Failed to add news']);
    //         }
    //     } else {
    //         http_response_code(400);
    //         echo json_encode(['success' => false, 'message' => 'Invalid input']);
    //     }
    // }

    // // RESTful API: Update News
    // public function apiUpdateNews($id) {
      
    //     $data = json_decode(file_get_contents('php://input'), true);
    
        
    //     if (isset($data['tieude'], $data['mota'], $data['anh'], $data['trang_thai'], $data['noidung'], $data['id_nhanvien'], $data['ngaydang'])) {
            
            
    //         if ($this->newsModel->updateNews($id, $data['tieude'], $data['mota'], $data['anh'], $data['trang_thai'], $data['noidung'], $data['id_nhanvien'], $data['ngaydang'])) {
    //             echo json_encode(['success' => true, 'message' => 'News updated successfully']);
    //         } else {
    //             http_response_code(400);
    //             echo json_encode(['success' => false, 'message' => 'Failed to update news']);
    //         }
    //     } else {
    //         http_response_code(400);
    //         echo json_encode(['success' => false, 'message' => 'Invalid input']);
    //     }
    // }
    

    // RESTful API: Delete News
    public function apiDeleteNews($id) {
        if ($this->newsModel->deleteNews($id)) {
            echo json_encode(['success' => true, 'message' => 'News deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Failed to delete news']);
        }
    }

    private function uploadImage($file) {
        $targetDir = "public/images/tintuc/";  // Thư mục lưu ảnh
        $targetFile = $targetDir . basename($file["name"]);

        // Kiểm tra định dạng file
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $validImageTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $validImageTypes)) {
            throw new Exception("Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF).");
        }

        // Kiểm tra nếu file đã tồn tại và tạo tên mới nếu cần
        if (file_exists($targetFile)) {
            $fileNameWithoutExt = pathinfo($file["name"], PATHINFO_FILENAME);
            $targetFile = $targetDir . $fileNameWithoutExt . "_" . time() . "." . $imageFileType;
        }

        // Di chuyển file từ vị trí tạm thời đến thư mục đích
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return basename($targetFile);  // Trả về tên file đã lưu
        } else {
            throw new Exception("Lỗi khi upload ảnh.");
        }
    }

}
?>
