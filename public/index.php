<?php
session_start();

require_once __DIR__ . '/../config/database.php';

// Lấy controller và action từ URL
$controller = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Ghép tên class controller, ví dụ: phong -> PhongController1
$controllerName = ucfirst($controller) . 'Controller1';
$controllerFile = __DIR__ . "/../controllers/{$controllerName}.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerName)) {
        $db = new Database();
        $conn = $db->getConnection();
        $controllerObj = new $controllerName($conn);

        // Xử lý POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nếu là thêm/cập nhật
            if (isset($_POST['them']) || isset($_POST['capnhat'])) {
                $controllerObj->createOrUpdate();
            }
            // Nếu là tìm kiếm, chỉ cần POST dữ liệu sẽ được index() xử lý
        }

        // Gọi action
        if (method_exists($controllerObj, $action)) {
            $controllerObj->$action();
        } elseif (method_exists($controllerObj, 'index')) {
            $controllerObj->index();
        } else {
            echo "❌ Không tìm thấy phương thức <b>$action</b> trong <b>$controllerName</b>";
        }
    } else {
        echo "❌ Không tìm thấy class <b>$controllerName</b> trong file.";
    }
} else {
    echo "❌ Không tìm thấy file controller: $controllerFile";
}
