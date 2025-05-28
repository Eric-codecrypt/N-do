<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$errorMessage = $_SESSION['error_message'] ?? null;
$successMessage = $_SESSION['success_message'] ?? null;
$uploadError = $_SESSION['upload_error'] ?? null;


unset($_SESSION['error_message'], $_SESSION['success_message'], $_SESSION['upload_error']);


$controllerPath = __DIR__ . '/../Controller/UserController.php';
if (file_exists($controllerPath)) {
    require_once $controllerPath;
} else {
    die("Erro: Arquivo UserController.php não encontrado em $controllerPath");
}

$configPath = __DIR__ . '/../config.php';
if (file_exists($configPath)) {
    require_once $configPath;
} else {
    die("Erro: Arquivo config.php não encontrado em $configPath");
}

if (!class_exists('UserController')) {
    die("Erro: Classe UserController não encontrada.");
}

$Controller = new UserController($pdo);

if (!isset($_SESSION['user_id'])) {
    header("Location: User.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $Controller->getUserFromID($user_id)["username"];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($themeColor); ?>" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="user-styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAclBMVEX///8hlvMAkPLF4Pvr9v6hzfklmfMAj/Itm/Tv+P6z1/ofl/MQkvMXlPP2+//i8P2p0voAi/LW6/2Bvvd6u/c2nvRjr/bz+v47ofS83PtMpPTZ7f11uPel0PnG4vzq8/2VyflQqvXQ5vxbrPVqsfaDvPcwwE3YAAAEeklEQVR4nO3dW3raMBAFYEsOFgENTjFQm0AwSbr/Ldbu5aEPpR7KkWR952yg/WNJWLdxUTAMwzAMwzAMwzAMwzAMEzZ1v3hMzi+rVfe2vTx/3cQ2/Znyi31QvPfWOuer9rDrV9un2LLfKa15cMSIDNb18XR+j60b83jhb+jIlOtim63wl9O7qnmL2jPBwhEpbtlEbK944Yj0tn2J9SCDCH8im0vWwiHe7uq8hYNRduF/JoMKR2OfuXDoj1WZt3AwutNz3sKhqVZd5sLhMTaZC42x12CDaiTh0FJDvZLHEg6vq4HG1GjCoTO+ZC40JgwxpjAMMarQ2FXuQrFvmQuNGPiEKrLQyD53ofGfuQuNBQ+o8YUi2K4YX2j8MXehcefchWKQU6kUhMbvEhHK7fwH0QInixrh8laqyljr73T6QwpCqV6fb+VSv3b9Z+X8PUiH27rRCKeMB5ttI3d0bfmYjXDMaq9/ju51TsKiWBgtUWDDKUZY1EdlU5U1aiEcJCyKk5LoUS/gMGHR6IhynZ2waLyKaEFTDKCwOKiIfgEBQoWbSjOiopopUli8O4XQuK8IIFZY7DTt1GJ2FbHCi+ZN3GM2FbFC3XjaPp5XwIW1aqyBdESwsPjQNFPIFAot7BRvNh6yT4MWbhQ/GJihBi0srtObqUDWMuDCfvpoKpClYbhQ0RFljxhM4cLL9I5457/wj8CFm7WiIyImUHhhOxmImSLChZrffIdY+sYLPxVCxEtNAOH0nwvIyQy88DT9GVrEUbe0hPN8hopWOtN+eMh+LD0qWuksfw81S4rzfKe5KN68K8TNKM4t/luY//xQ8eI9zzm+Yno403UaRSOd51rbZqlYL7VzXC990WwEe8hWPlaoeoSz3LdQ7a7Nce9ppdohhcwOscKt7miUxdzYBwq3Gh7uaBtOWCoPfqHO7MOEvVUKBXQUGiQsW91xIeAhWoiwbJ36+CVoJAUIn96aSu8zBnb/SXUK+ulG6vr1vVucjuv7jkFb0Jkv3Un29Y2MfwJ7/1F28Sig7r4F6C7CEN+nIYRFKlwFojSEyCvPSQgxS1ApCZGXgpIQgiaG6QjBl53jC8XnfksWXVchutCiyw3FFnrcpbU0hB51UyYVoRzxhc2iCqUNULktptAfQ1T8jCiE1/yILQxVlS6aMFClr2hCvw9WIzpS3cRTuKrCUWpfrvOufTk8QMxFw0SEYo+Bq7QHFro2ZAMNLhS3D1BjL5pQvL0GrpEcUjjwlg2stkd0oXgnn2W07yOgv/4g1smpi/n5B5xw/ISHLA/nSI0TKPzxFZahYbaHpoutG6MRjh/L+WvGj+m4IbZqD9/61faSyieDFML1eXUrXVe+b+ugBeUnRbPLnd7/fkrw9y1ih0IK0w+FFKYfCilMPxRSmH4opDD9UEhh+qGQwvRDIYXph0IK0w+FFKYfCilMPxRSmH4opDD9UEhh+qGQwvRDIYXph0IK0w+FFKYfCilMP+UXOzHezFNY94upOadyG41hGIZhGIZhGIZhGIZhmMflO7iScULsLU8KAAAAAElFTkSuQmCC" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAclBMVEX///8hlvMAkPLF4Pvr9v6hzfklmfMAj/Itm/Tv+P6z1/ofl/MQkvMXlPP2+//i8P2p0voAi/LW6/2Bvvd6u/c2nvRjr/bz+v47ofS83PtMpPTZ7f11uPel0PnG4vzq8/2VyflQqvXQ5vxbrPVqsfaDvPcwwE3YAAAEeklEQVR4nO3dW3raMBAFYEsOFgENTjFQm0AwSbr/Ldbu5aEPpR7KkWR952yg/WNJWLdxUTAMwzAMwzAMwzAMwzAMEzZ1v3hMzi+rVfe2vTx/3cQ2/Znyi31QvPfWOuer9rDrV9un2LLfKa15cMSIDNb18XR+j60b83jhb+jIlOtim63wl9O7qnmL2jPBwhEpbtlEbK944Yj0tn2J9SCDCH8im0vWwiHe7uq8hYNRduF/JoMKR2OfuXDoj1WZt3AwutNz3sKhqVZd5sLhMTaZC42x12CDaiTh0FJDvZLHEg6vq4HG1GjCoTO+ZC40JgwxpjAMMarQ2FXuQrFvmQuNGPiEKrLQyD53ofGfuQuNBQ+o8YUi2K4YX2j8MXehcefchWKQU6kUhMbvEhHK7fwH0QInixrh8laqyljr73T6QwpCqV6fb+VSv3b9Z+X8PUiH27rRCKeMB5ttI3d0bfmYjXDMaq9/ju51TsKiWBgtUWDDKUZY1EdlU5U1aiEcJCyKk5LoUS/gMGHR6IhynZ2waLyKaEFTDKCwOKiIfgEBQoWbSjOiopopUli8O4XQuK8IIFZY7DTt1GJ2FbHCi+ZN3GM2FbFC3XjaPp5XwIW1aqyBdESwsPjQNFPIFAot7BRvNh6yT4MWbhQ/GJihBi0srtObqUDWMuDCfvpoKpClYbhQ0RFljxhM4cLL9I5457/wj8CFm7WiIyImUHhhOxmImSLChZrffIdY+sYLPxVCxEtNAOH0nwvIyQy88DT9GVrEUbe0hPN8hopWOtN+eMh+LD0qWuksfw81S4rzfKe5KN68K8TNKM4t/luY//xQ8eI9zzm+Yno403UaRSOd51rbZqlYL7VzXC990WwEe8hWPlaoeoSz3LdQ7a7Nce9ppdohhcwOscKt7miUxdzYBwq3Gh7uaBtOWCoPfqHO7MOEvVUKBXQUGiQsW91xIeAhWoiwbJ36+CVoJAUIn96aSu8zBnb/SXUK+ulG6vr1vVucjuv7jkFb0Jkv3Un29Y2MfwJ7/1F28Sig7r4F6C7CEN+nIYRFKlwFojSEyCvPSQgxS1ApCZGXgpIQgiaG6QjBl53jC8XnfksWXVchutCiyw3FFnrcpbU0hB51UyYVoRzxhc2iCqUNULktptAfQ1T8jCiE1/yILQxVlS6aMFClr2hCvw9WIzpS3cRTuKrCUWpfrvOufTk8QMxFw0SEYo+Bq7QHFro2ZAMNLhS3D1BjL5pQvL0GrpEcUjjwlg2stkd0oXgnn2W07yOgv/4g1smpi/n5B5xw/ISHLA/nSI0TKPzxFZahYbaHpoutG6MRjh/L+WvGj+m4IbZqD9/61faSyieDFML1eXUrXVe+b+ugBeUnRbPLnd7/fkrw9y1ih0IK0w+FFKYfCilMPxRSmH4opDD9UEhh+qGQwvRDIYXph0IK0w+FFKYfCilMPxRSmH4opDD9UEhh+qGQwvRDIYXph0IK0w+FFKYfCilMP+UXOzHezFNY94upOadyG41hGIZhGIZhGIZhGIZhmMflO7iScULsLU8KAAAAAElFTkSuQmCC" type="image/x-icon">
    <link rel="stylesheet" href="dark-mode.css">
</head>
<body>
<main>
    <div class="style-switcher">
        <!-- Botão de alternância do painel -->
        <div class="style-switcher-toggler s-icon">
            <i class="fas fa-palette fa-spin"></i>
        </div>

        <!-- Botão claro/escuro -->
        <div class="day-night s-icon" id="theme-toggle">
            <i class="fas fa-moon icon moon"></i>
            <i class="fas fa-sun icon sun"></i>
        </div>

        <!-- Painel de cores -->
        <div class="theme-panel">
            <h4>Temas</h4>

            <?php  echo htmlspecialchars($themeColor); ?>
            <hr>
            <br>
            <div class="colors">
                <!-- Temas originais -->
                <button class="theme-btn" data-theme="theme-base" style="background-color: #0064fa;" aria-label="Azul padrão"></button>
                <button class="theme-btn" data-theme="theme-red" style="background-color: #ff0000;" aria-label="Vermelho"></button>
                <button class="theme-btn" data-theme="theme-green" style="background-color: #00ff00;" aria-label="Verde"></button>
                <button class="theme-btn" data-theme="theme-blue" style="background-color: #0000ff;" aria-label="Azul"></button>
                <button class="theme-btn" data-theme="theme-yellow" style="background-color: #ffff00;" aria-label="Amarelo"></button>
                <button class="theme-btn" data-theme="theme-purple" style="background-color: #800080;" aria-label="Roxo"></button>
                <button class="theme-btn" data-theme="theme-pink" style="background-color: #ff69b4;" aria-label="Rosa"></button>
                <button class="theme-btn" data-theme="theme-teal" style="background-color: #008080;" aria-label="Teal"></button>
                <button class="theme-btn" data-theme="theme-orange" style="background-color: #ffa500;" aria-label="Laranja"></button>
                <button class="theme-btn" data-theme="theme-brown" style="background-color: #8b4513;" aria-label="Marrom"></button>
                <button class="theme-btn" data-theme="theme-gray" style="background-color: #808080;" aria-label="Cinza"></button>

                <!-- Metálicos -->
                <button class="theme-btn" data-theme="theme-gold" style="background-color: #ffd700;" aria-label="Dourado"></button>
                <button class="theme-btn" data-theme="theme-silver" style="background-color: #c0c0c0;" aria-label="Prata"></button>
                <button class="theme-btn" data-theme="theme-bronze" style="background-color: #cd7f32;" aria-label="Bronze"></button>
                <button class="theme-btn" data-theme="theme-copper" style="background-color: #b87333;" aria-label="Cobre"></button>
                <button class="theme-btn" data-theme="theme-platinum" style="background-color: #e5e4e2;" aria-label="Platina"></button>
                <button class="theme-btn" data-theme="theme-titanium" style="background-color: #878681;" aria-label="Titânio"></button>

                <!-- Cores vibrantes -->
                <button class="theme-btn" data-theme="theme-neon-green" style="background-color: #39ff14;" aria-label="Verde Neon"></button>
                <button class="theme-btn" data-theme="theme-hot-pink" style="background-color: #ff1493;" aria-label="Rosa Vibrante"></button>
                <button class="theme-btn" data-theme="theme-electric-purple" style="background-color: #bf00ff;" aria-label="Roxo Elétrico"></button>
                <button class="theme-btn" data-theme="theme-neon-blue" style="background-color: #1e90ff;" aria-label="Azul Neon"></button>
                <button class="theme-btn" data-theme="theme-magenta" style="background-color: #ff00ff;" aria-label="Magenta"></button>
                <button class="theme-btn" data-theme="theme-cyan" style="background-color: #00ffff;" aria-label="Ciano"></button>

                <!-- Cores pastéis -->
                <button class="theme-btn" data-theme="theme-pastel-blue" style="background-color: #a7c7e7;" aria-label="Azul Pastel"></button>
                <button class="theme-btn" data-theme="theme-pastel-pink" style="background-color: #f8c8dc;" aria-label="Rosa Pastel"></button>
                <button class="theme-btn" data-theme="theme-pastel-green" style="background-color: #b5e7a0;" aria-label="Verde Pastel"></button>
                <button class="theme-btn" data-theme="theme-pastel-yellow" style="background-color: #fdfd96;" aria-label="Amarelo Pastel"></button>
                <button class="theme-btn" data-theme="theme-pastel-lavender" style="background-color: #d8b5e7;" aria-label="Lavanda Pastel"></button>

                <!-- Cores terrosas e naturais -->
                <button class="theme-btn" data-theme="theme-terra-cotta" style="background-color: #e2725b;" aria-label="Terracota"></button>
                <button class="theme-btn" data-theme="theme-sage" style="background-color: #9caf88;" aria-label="Sálvia"></button>
                <button class="theme-btn" data-theme="theme-moss" style="background-color: #8a9a5b;" aria-label="Musgo"></button>
                <button class="theme-btn" data-theme="theme-sand" style="background-color: #d2b48c;" aria-label="Areia"></button>
                <button class="theme-btn" data-theme="theme-slate" style="background-color: #708090;" aria-label="Ardósia"></button>

                <!-- Temas de marcas -->
                <button class="theme-btn" data-theme="theme-social-blue" style="background-color: #1877f2;" aria-label="Azul Social"></button>
                <button class="theme-btn" data-theme="theme-social-red" style="background-color: #ff0000;" aria-label="Vermelho Social"></button>
                <button class="theme-btn" data-theme="theme-eco-green" style="background-color: #00d084;" aria-label="Verde Ecológico"></button>
                <button class="theme-btn" data-theme="theme-tech-dark" style="background-color: #333333;" aria-label="Preto Tech"></button>
                <button class="theme-btn" data-theme="theme-streaming-red" style="background-color: #e50914;" aria-label="Vermelho Streaming"></button>

                <!-- Temas gradientes (representados pela cor principal) -->
                <button class="theme-btn" data-theme="theme-sunset" style="background-color: #ff7e5f;" aria-label="Pôr do Sol"></button>
                <button class="theme-btn" data-theme="theme-ocean" style="background-color: #2193b0;" aria-label="Oceano"></button>
                <button class="theme-btn" data-theme="theme-forest" style="background-color: #134e5e;" aria-label="Floresta"></button>
                <button class="theme-btn" data-theme="theme-berry" style="background-color: #6f0000;" aria-label="Frutas Vermelhas"></button>
                <button class="theme-btn" data-theme="theme-aurora" style="background-color: #00c9ff;" aria-label="Aurora"></button>

                <!-- Temas conceituais -->
                <button class="theme-btn" data-theme="theme-vintage" style="background-color: #d1b280;" aria-label="Vintage"></button>
                <button class="theme-btn" data-theme="theme-cyberpunk" style="background-color: #f706cf;" aria-label="Cyberpunk"></button>
                <button class="theme-btn" data-theme="theme-space" style="background-color: #3e1f47;" aria-label="Espaço"></button>
                <button class="theme-btn" data-theme="theme-coffee" style="background-color: #65433c;" aria-label="Café"></button>
                <button class="theme-btn" data-theme="theme-mint" style="background-color: #3eb489;" aria-label="Menta"></button>

                <!-- Pedras preciosas -->
                <button class="theme-btn" data-theme="theme-ruby" style="background-color: #e0115f;" aria-label="Rubi"></button>
                <button class="theme-btn" data-theme="theme-emerald" style="background-color: #046307;" aria-label="Esmeralda"></button>
                <button class="theme-btn" data-theme="theme-sapphire" style="background-color: #0f52ba;" aria-label="Safira"></button>
                <button class="theme-btn" data-theme="theme-amethyst" style="background-color: #9966cc;" aria-label="Ametista"></button>
                <button class="theme-btn" data-theme="theme-topaz" style="background-color: #ffc87c;" aria-label="Topázio"></button>
            </div>
        </div>

    </div>

    <style>
        /* Style Switcher */
        .style-switcher {
            position: fixed;
            right: 0;
            top: 60px;
            padding: 15px;
            width: 200px;
            background: var(--bg-black-100, #fff);
            z-index: 101;
            border-radius: 5px;
            transform: translateX(100%);
            border: 1px solid var(--primary, #0064fa);
            transition: all 0.3s ease;
        }

        .style-switcher.open {
            transform: translateX(0%);
            box-shadow: -3px 0 15px rgba(0,0,0,0.1);
        }

        .style-switcher .s-icon {
            position: absolute;
            height: 40px;
            width: 40px;
            text-align: center;
            background: var(--bg-black-100, #fff);
            color: var(--primary, #0064fa);
            right: 100%;
            border: 1px solid var(--primary, #0064fa);
            margin-right: 25px;
            cursor: pointer;
            border-radius: 50%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .style-switcher .s-icon i {
            line-height: 40px;
            font-size: 20px;
        }

        .style-switcher .s-icon:hover {
            background: var(--primary, #0064fa);
            color: #fff;
        }

        .style-switcher .style-switcher-toggler {
            top: 0;
        }

        .style-switcher .day-night {
            top: 55px;
        }

        .style-switcher h4 {
            margin: 0 0 10px;
            color: var(--text-black-700, #333);
            font-size: 16px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .style-switcher .colors {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 5px;
        }

        .style-switcher .theme-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid #fff;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .style-switcher .theme-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 8px rgba(0,0,0,0.3);
        }

        /* Animação para o ícone de configuração */
        @keyframes fa-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .fa-spin {
            animation: fa-spin 2s infinite linear;
        }

        /* Animação para o botão claro/escuro */
        [data-theme='dark'] .day-night .sun {
            display: none;
        }

        [data-theme='dark'] .day-night .moon {
            display: block;
        }

        [data-theme='light'] .day-night .sun {
            display: block;
        }

        [data-theme='light'] .day-night .moon {
            display: none;
        }

        /* Temas escuro/claro */
        [data-theme='dark'] {
            --bg-black-100: #222;
            --text-black-700: #fff;
        }

        [data-theme='light'] {
            --bg-black-100: #fff;
            --text-black-700: #333;
        }





        /* Temas originais */
        .theme-cyan {
            --primary: #00ffff;
            --primary-light: #80ffff;
            --primary-dark: #008080;
            --bg-black-100: #000;
            --text-black-700: #fff;
            --secondary: #e0ffff;
        }

        .theme-black {
            --primary: #000000;
            --primary-light: #333333;
            --primary-dark: #000000;
            --secondary: #4d4d4d;
        }

        .theme-gold {
            --primary: #ffd700;
            --primary-light: #ffe54d;
            --primary-dark: #d7bf00;
            --secondary: #fff5b3;
        }

        .theme-silver {
            --primary: #c0c0c0;
            --primary-light: #d9d9d9;
            --primary-dark: #8c8c8c;
            --secondary: #f2f2f2;
        }

        .theme-red {
            --primary: #ff4d4d;
            --primary-light: #ff9999;
            --primary-dark: #cc0000;
            --secondary: #ffdddd;
        }

        .theme-green {
            --primary: #4dff4d;
            --primary-light: #99ff99;
            --primary-dark: #008000;
            --secondary: #ddffdd;
        }

        .theme-blue {
            --primary: #4d4dff;
            --primary-light: #9999ff;
            --primary-dark: #000080;
            --secondary: #ddddff;
        }

        .theme-yellow {
            --primary: #ffff4d;
            --primary-light: #ffff99;
            --primary-dark: #ffcc00;
            --secondary: #ffffcc;
        }

        .theme-purple {
            --primary: #8000ff;
            --primary-light: #b366ff;
            --primary-dark: #5900cc;
            --secondary: #e6ccff;
        }

        .theme-pink {
            --primary: #fd55ac;
            --primary-light: #ffc0ff;
            --primary-dark: #ff69b4;
            --secondary: #ffd6e9;
        }

        .theme-teal {
            --primary: #008080;
            --primary-light: #4cb3b3;
            --primary-dark: #004d4d;
            --secondary: #b3e6e6;
        }

        .theme-orange {
            --primary: #ffa500;
            --primary-light: #ffcc80;
            --primary-dark: #ff7700;
            --secondary: #ffedcc;
        }

        .theme-brown {
            --primary: #8b4513;
            --primary-light: #a36741;
            --primary-dark: #59270e;
            --secondary: #d2b89b;
        }

        .theme-gray {
            --primary: #808080;
            --primary-light: #b3b3b3;
            --primary-dark: #4d4d4d;
            --secondary: #e6e6e6;
        }

        /* Novas cores vibrantes */
        .theme-neon-green {
            --primary: #39ff14;
            --primary-light: #85ff70;
            --primary-dark: #00cc00;
            --secondary: #d4ffcf;
        }

        .theme-hot-pink {
            --primary: #ff1493;
            --primary-light: #ff69b4;
            --primary-dark: #c71585;
            --secondary: #ffcce6;
        }

        .theme-electric-purple {
            --primary: #bf00ff;
            --primary-light: #d580ff;
            --primary-dark: #8a00b8;
            --secondary: #f0ccff;
        }

        .theme-neon-blue {
            --primary: #1e90ff;
            --primary-light: #6cb8ff;
            --primary-dark: #0066cc;
            --secondary: #d1e8ff;
        }

        .theme-magenta {
            --primary: #ff00ff;
            --primary-light: #ff80ff;
            --primary-dark: #cc00cc;
            --secondary: #ffccff;
        }

        /* Cores pastéis */
        .theme-pastel-blue {
            --primary: #a7c7e7;
            --primary-light: #d6e6f5;
            --primary-dark: #6a9ac7;
            --secondary: #e9f2fa;
        }

        .theme-pastel-pink {
            --primary: #f8c8dc;
            --primary-light: #fce6ee;
            --primary-dark: #e293b5;
            --secondary: #fdf2f6;
        }

        .theme-pastel-green {
            --primary: #b5e7a0;
            --primary-light: #d8f2ce;
            --primary-dark: #86cd6e;
            --secondary: #ebf8e5;
        }

        .theme-pastel-yellow {
            --primary: #fdfd96;
            --primary-light: #fefecb;
            --primary-dark: #f9f959;
            --secondary: #fefefd;
        }

        .theme-pastel-lavender {
            --primary: #d8b5e7;
            --primary-light: #ecdcf5;
            --primary-dark: #b586cd;
            --secondary: #f5ebfa;
        }

        /* Cores terrosas e naturais */
        .theme-terra-cotta {
            --primary: #e2725b;
            --primary-light: #eea08d;
            --primary-dark: #c45240;
            --secondary: #f7ddd5;
        }

        .theme-sage {
            --primary: #9caf88;
            --primary-light: #c1cfb5;
            --primary-dark: #778d63;
            --secondary: #e6ebe0;
        }

        .theme-moss {
            --primary: #8a9a5b;
            --primary-light: #b0bd8e;
            --primary-dark: #637346;
            --secondary: #e5ead8;
        }

        .theme-sand {
            --primary: #d2b48c;
            --primary-light: #e5d3b3;
            --primary-dark: #b39067;
            --secondary: #f4ede1;
        }

        .theme-slate {
            --primary: #708090;
            --primary-light: #a4b0bc;
            --primary-dark: #4c5866;
            --secondary: #dce0e5;
        }

        /* Temas de marcas famosas */
        .theme-social-blue {
            --primary: #1877f2;
            --primary-light: #619ef5;
            --primary-dark: #0e5bbc;
            --secondary: #e2ebfa;
        }

        .theme-social-red {
            --primary: #ff0000;
            --primary-light: #ff6666;
            --primary-dark: #cc0000;
            --secondary: #ffcccc;
        }

        .theme-eco-green {
            --primary: #00d084;
            --primary-light: #66e3b7;
            --primary-dark: #00a368;
            --secondary: #ccf5e6;
        }

        .theme-tech-dark {
            --primary: #333333;
            --primary-light: #666666;
            --primary-dark: #000000;
            --secondary: #bbbbbb;
        }

        .theme-streaming-red {
            --primary: #e50914;
            --primary-light: #f45762;
            --primary-dark: #b20710;
            --secondary: #fad3d6;
        }

        /* Temas gradientes */
        .theme-sunset {
            --primary: #ff7e5f;
            --primary-light: #ffaf9f;
            --primary-dark: #e35d4d;
            --secondary: #feb692;
        }

        .theme-ocean {
            --primary: #2193b0;
            --primary-light: #6bc6d9;
            --primary-dark: #186d84;
            --secondary: #6dd5ed;
        }

        .theme-forest {
            --primary: #134e5e;
            --primary-light: #5c8d9a;
            --primary-dark: #0c3945;
            --secondary: #71b280;
        }

        .theme-berry {
            --primary: #6f0000;
            --primary-light: #a64d4d;
            --primary-dark: #490000;
            --secondary: #200122;
        }

        .theme-aurora {
            --primary: #00c9ff;
            --primary-light: #66deff;
            --primary-dark: #0098c0;
            --secondary: #92fe9d;
        }

        /* Temas conceituais */
        .theme-vintage {
            --primary: #d1b280;
            --primary-light: #e2cdaa;
            --primary-dark: #a89066;
            --secondary: #f0e6d5;
        }

        .theme-cyberpunk {
            --primary: #f706cf;
            --primary-light: #fa62dd;
            --primary-dark: #c405a5;
            --secondary: #04e1fc;
        }

        .theme-space {
            --primary: #3e1f47;
            --primary-light: #7c5d87;
            --primary-dark: #29142f;
            --secondary: #4b257c;
        }

        .theme-coffee {
            --primary: #65433c;
            --primary-light: #926c64;
            --primary-dark: #462e29;
            --secondary: #c0a392;
        }

        .theme-mint {
            --primary: #3eb489;
            --primary-light: #7dcab0;
            --primary-dark: #2a8c69;
            --secondary: #c3e8d7;
        }

        /* Cores metálicas */
        .theme-bronze {
            --primary: #cd7f32;
            --primary-light: #dba570;
            --primary-dark: #9c5e26;
            --secondary: #f0d4bc;
        }

        .theme-copper {
            --primary: #b87333;
            --primary-light: #d49e70;
            --primary-dark: #9a5526;
            --secondary: #f1d9c5;
        }

        .theme-platinum {
            --primary: #e5e4e2;
            --primary-light: #f0efee;
            --primary-dark: #b8b8b5;
            --secondary: #f8f8f7;
        }

        .theme-titanium {
            --primary: #878681;
            --primary-light: #b0afab;
            --primary-dark: #5e5d5a;
            --secondary: #dbdad8;
        }

        /* Cores de pedras preciosas */
        .theme-ruby {
            --primary: #e0115f;
            --primary-light: #eb6097;
            --primary-dark: #b00d4a;
            --secondary: #f7d1e0;
        }

        .theme-emerald {
            --primary: #046307;
            --primary-light: #3e8e41;
            --primary-dark: #023d04;
            --secondary: #a7e8a9;
        }

        .theme-sapphire {
            --primary: #0f52ba;
            --primary-light: #5382d2;
            --primary-dark: #093b85;
            --secondary: #d1ddf1;
        }

        .theme-amethyst {
            --primary: #9966cc;
            --primary-light: #b799dd;
            --primary-dark: #7744aa;
            --secondary: #e6d9f2;
        }

        .theme-topaz {
            --primary: #ffc87c;
            --primary-light: #ffdba9;
            --primary-dark: #ffb74d;
            --secondary: #fff0db;
        }
</main>
</body>
</html>