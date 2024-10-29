<?php
require_once 'model/admin/EmployeeModel.php';

class HeaderController {
    private $employeeModel;

    public function __construct($db) {
        $this->employeeModel = new EmployeeModel($db);
    }

    public function displayHeader($admin_id) {
        // Lấy thông tin nhân viên từ model
        $employee = $this->employeeModel->getEmployeeById($admin_id);

        // Truyền dữ liệu sang view
        require 'view/admin/header.php';
    }
    
}
?>
