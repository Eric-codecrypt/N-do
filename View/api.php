<?php
header('Content-Type: application/json');

session_start();
require_once __DIR__ . '/../config.php';
require_once 'C:\Users\Turma 2\PhpstormProjects\N-project\Controller\UserController.php';
$Controller = new UserController($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $response = [];

    if ($action === 'login') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $stmt = $pdo->prepare("SELECT id, password, theme_color FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['theme_color'] = $user['theme_color'];
            $response['success'] = true;
            $response['redirect'] = 'index.php';
        } else {
            $response['success'] = false;
            $response['message'] = "E-mail ou senha incorretos.";
        }
    } elseif ($action === 'register') {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $currentDateTime = new DateTime('now');
        $data_de_registro = $currentDateTime->format("Y-m-d H:i:s" . ".000000");
        $theme_color = 'theme-base';
        $registred = $Controller->register($username, $email, $password, $data_de_registro);
        if ($registred) {
            $response['success'] = true;
            $response['redirect'] = 'login.php';
        } else {
            $response['success'] = false;
            $response['message'] = "Erro ao registrar usuário.";
        }
    }

    echo json_encode($response);
    exit;
}
?>
