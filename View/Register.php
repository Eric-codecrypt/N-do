<?php
include_once  '../Controller/UserController.php';
include_once '../config.php';

$Controller = new UserController($pdo);

if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $currentdatetime = new DateTime('now');
    $data_de_registro = $currentdatetime->format("Y-m-d H:i:s" . ".000000");
    $theme_color = 'theme-base';


    $registred = $Controller->register($username, $email, $password, $data_de_registro);
    $error_code = 0;

    if ($registred && $error_code == null) {
        header("Location: login.php");
    }
}



?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($themeColor); ?>" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registrar</title>
</head>
<body>
<main>
    <form method="POST" enctype="multipart/form-data">
        <input required type="text" name="username" placeholder="nome de usuário">
        <br>
        <input required type="password" name="password" placeholder="senha">
        <br>
        <input required type="email" name="email" placeholder="email">
        <br>
        <button  class="btn btn-primary" style="white" type="submit">Cadastrar Conta</button>
    </form>
</main>
</body>
</html>
