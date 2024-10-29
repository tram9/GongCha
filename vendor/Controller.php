<?php

/**
 * 
 */
class Controller
{
	protected $folder;
	function render($file, $data = array(), $title = null, $layout = 'user')
	{
		// Đường dẫn tới file view
		$file_path = "view/" . $this->folder . "/" . $file . ".php";
		// var_dump($file_path);
		if (file_exists($file_path)) {
			// ob_start(); // Bắt đầu buffer
			require_once($file_path); // Gọi file view
			// $content = ob_get_clean(); // Lưu nội dung vào biến $content/
			// Chọn layout dựa vào giá trị của $layout
			// if ($layout === 'admin') {
			// 	require_once('././view/admin/login.php');
			// } else {
			// 	require_once('././view/user/home.php');
			// }
		} else {
			echo "Không tìm thấy view";
			echo "<br>" . $file_path;
		}
	}


	public function model($model)
	{
		require_once "model/admin/" . $model . ".php";
		return new $model;
	}
}
