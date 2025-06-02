<?php

//header('Content-Type: application/json');



session_start();
require_once __DIR__ . '/../config.php';
require_once '../Controller/UserController.php';

$Controller = new UserController($pdo);

// Verifica se há dados POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    // AÇÃO: LOGIN
    if ($action === 'login') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Buscar usuário no banco de dados
        $stmt = $pdo->prepare("SELECT id, password, theme_color FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['theme_color'] = $user['theme_color'];

            header("Location: user.php");
            exit;
        } else {
            $error_message = "E-mail ou senha incorretos.";
        }

        // AÇÃO: REGISTRO
    } elseif ($action === 'register') {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $currentdatetime = new DateTime('now');
        $data_de_registro = $currentdatetime->format("Y-m-d H:i:s" . ".000000");
        $theme_color = 'theme-base';

        $registred = $Controller->register($username, $email, $password, $data_de_registro);
        $error_code = 0;

        if ($registred && $error_code == null) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'redirect' => 'login.php']);
            exit;
        } else {
            $error_message = "Erro ao registrar usuário.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>N-Project - Login</title>
    <style>
        :root {
            --primary-cyan: #00ffff;
            --primary-magenta: #ff00ff;
            --primary-yellow: #ffff00;
            --glitch-green: #00ff41;
            --dark-bg: #0a0a0f;
            --darker-bg: #050508;
            --error-red: #ff0055;
            --warning-orange: #ff6600;
            --subtle-cyan: #4dd8ff;
            --subtle-purple: #b566ff;
        }

        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--darker-bg) 100%);
            color: #fff;
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                    radial-gradient(circle at 20% 50%, rgba(0, 255, 255, 0.02) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(255, 0, 255, 0.02) 0%, transparent 50%),
                    radial-gradient(circle at 40% 80%, rgba(255, 255, 0, 0.02) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .login-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: transparent;
            max-width: 600px;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        #welcome-message {
            font-size: 32px;
            margin-bottom: 20px;
            min-height: 50px;
            line-height: 1.4;
            font-weight: 600;
        }

        #question-container {
            margin-top: 20px;
        }

        #question-text {
            font-size: 28px;
            margin-bottom: 20px;
            min-height: 35px;
            font-weight: 400;
        }

        #input-container {
            margin-top: 20px;
        }

        #input-prompt {
            font-size: 24px;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
            min-height: 1.2em;
            font-weight: 400;
        }

        .hidden-input {
            padding: 0;
            border: none;
            background-color: transparent;
            color: transparent;
            outline: none;
            font-size: 24px;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            caret-color: transparent;
            font-family: 'JetBrains Mono', monospace;
        }

        @keyframes glitch {
            0% {
                text-shadow:
                        0.05em 0 0 var(--primary-cyan),
                        -0.05em -0.025em 0 var(--primary-magenta),
                        0.025em 0.05em 0 var(--primary-yellow);
            }
            14% {
                text-shadow:
                        0.05em 0 0 var(--primary-cyan),
                        -0.05em -0.025em 0 var(--primary-magenta),
                        0.025em 0.05em 0 var(--primary-yellow);
            }
            15% {
                text-shadow:
                        -0.05em -0.025em 0 var(--primary-cyan),
                        0.025em 0.025em 0 var(--primary-magenta),
                        -0.05em 0.05em 0 var(--primary-yellow);
            }
            49% {
                text-shadow:
                        -0.05em -0.025em 0 var(--primary-cyan),
                        0.025em 0.025em 0 var(--primary-magenta),
                        -0.05em 0.05em 0 var(--primary-yellow);
            }
            50% {
                text-shadow:
                        0.025em 0.05em 0 var(--primary-cyan),
                        0.05em 0 0 var(--primary-magenta),
                        0 -0.05em 0 var(--primary-yellow);
            }
            99% {
                text-shadow:
                        0.025em 0.05em 0 var(--primary-cyan),
                        0.05em 0 0 var(--primary-magenta),
                        0 -0.05em 0 var(--primary-yellow);
            }
            100% {
                text-shadow:
                        -0.025em 0 0 var(--primary-cyan),
                        -0.025em -0.025em 0 var(--primary-magenta),
                        -0.025em -0.05em 0 var(--primary-yellow);
            }
        }

        .glitch {
            animation: glitch 1.5s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        .blinking-cursor {
            display: inline-block;
            width: 3px;
            height: 1.2em;
            background: linear-gradient(45deg, var(--subtle-cyan), var(--glitch-green));
            margin-left: 5px;
            animation: blink 1.2s infinite;
            vertical-align: middle;
            box-shadow: 0 0 8px var(--subtle-cyan);
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: linear-gradient(135deg, rgba(77, 216, 255, 0.9), rgba(0, 255, 65, 0.9));
            color: var(--dark-bg);
            border-radius: 8px;
            box-shadow:
                    0 4px 15px rgba(77, 216, 255, 0.3),
                    0 0 0 1px rgba(77, 216, 255, 0.5);
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            z-index: 1000;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
            max-width: 300px;
            backdrop-filter: blur(10px);
        }

        .notification.show {
            opacity: 1;
            transform: translateX(0);
        }

        .notification.error {
            background: linear-gradient(135deg, rgba(255, 0, 85, 0.9), rgba(255, 102, 0, 0.9));
            color: #fff;
            box-shadow:
                    0 4px 15px rgba(255, 0, 85, 0.3),
                    0 0 0 1px rgba(255, 0, 85, 0.5);
        }

        .input-text {
            color: var(--subtle-cyan);
            margin-left: 5px;
            font-size: 24px;
            display: inline-block;
            text-shadow: 0 0 10px rgba(77, 216, 255, 0.5);
            font-family: 'JetBrains Mono', monospace;
        }

        #choice-question {
            font-size: 26px;
            margin-bottom: 30px;
            color: #fff;
            font-weight: 400;
            min-height: 1.2em;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-top: 20px;
        }

        /* Botões menos psicodélicos - mais elegantes */
        .cyberpunk-button {
            background: linear-gradient(145deg,
            rgba(13, 13, 18, 0.9),
            rgba(20, 20, 30, 0.8));
            border: 2px solid var(--subtle-cyan);
            color: var(--subtle-cyan);
            padding: 16px 32px;
            font-size: 16px;
            font-family: 'JetBrains Mono', monospace;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 200px;
            backdrop-filter: blur(10px);
            box-shadow:
                    0 0 15px rgba(77, 216, 255, 0.2),
                    inset 0 0 15px rgba(77, 216, 255, 0.05);
            clip-path: polygon(10px 0%, calc(100% - 10px) 0%, 100% 10px, 100% calc(100% - 10px), calc(100% - 10px) 100%, 10px 100%, 0% calc(100% - 10px), 0% 10px);
        }

        .cyberpunk-button::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg,
            var(--subtle-cyan),
            var(--subtle-purple),
            var(--subtle-cyan));
            background-size: 200% 200%;
            animation: subtleBorderFlow 4s linear infinite;
            z-index: -1;
            border-radius: inherit;
            clip-path: polygon(10px 0%, calc(100% - 10px) 0%, 100% 10px, 100% calc(100% - 10px), calc(100% - 10px) 100%, 10px 100%, 0% calc(100% - 10px), 0% 10px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        @keyframes subtleBorderFlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .cyberpunk-button .button-text {
            position: relative;
            display: block;
            z-index: 3;
            text-shadow: 0 0 8px rgba(77, 216, 255, 0.3);
        }

        .cyberpunk-button:hover {
            color: #fff;
            background: linear-gradient(145deg,
            rgba(77, 216, 255, 0.15),
            rgba(181, 102, 255, 0.1));
            border-color: #fff;
            transform: translateY(-2px);
            box-shadow:
                    0 0 25px rgba(77, 216, 255, 0.4),
                    inset 0 0 25px rgba(77, 216, 255, 0.1);
        }

        .cyberpunk-button:hover::before {
            opacity: 1;
        }

        .cyberpunk-button:active {
            transform: translateY(0);
        }

        .buttons-wrapper {
            display: none;
            justify-content: center;
            gap: 40px;
            opacity: 0;
            margin-top: 20px;
        }

        .loading-dots {
            font-size: 24px;
            color: var(--subtle-cyan);
            text-align: center;
            font-weight: 600;
        }

        .command-line {
            font-size: 18px;
            color: var(--subtle-cyan);
            text-align: left;
            font-family: 'JetBrains Mono', monospace;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(10, 10, 15, 0.9));
            padding: 20px;
            border-radius: 8px;
            border: 1px solid var(--subtle-cyan);
            margin-top: 20px;
            text-shadow: 0 0 10px rgba(77, 216, 255, 0.3);
            box-shadow:
                    0 0 20px rgba(77, 216, 255, 0.2),
                    inset 0 0 20px rgba(77, 216, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg,
            rgba(77, 216, 255, 0.2),
            rgba(181, 102, 255, 0.2));
            border-radius: 3px;
            margin: 10px 0;
            overflow: hidden;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg,
            var(--subtle-cyan),
            var(--subtle-purple));
            width: 0%;
            transition: width 0.3s ease;
            box-shadow: 0 0 10px rgba(77, 216, 255, 0.5);
            background-size: 200% 100%;
            animation: progressShimmer 2s linear infinite;
        }

        @keyframes progressShimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .password-strength {
            margin-top: 10px;
            font-size: 14px;
            text-align: left;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 500;
        }

        .strength-weak {
            color: var(--error-red);
            text-shadow: 0 0 5px rgba(255, 0, 85, 0.5);
        }
        .strength-medium {
            color: var(--warning-orange);
            text-shadow: 0 0 5px rgba(255, 102, 0, 0.5);
        }
        .strength-strong {
            color: var(--glitch-green);
            text-shadow: 0 0 5px rgba(0, 255, 65, 0.5);
        }

        /* Ícones mais sutis */
        .icon-glitch {
            display: inline-block;
            position: relative;
            margin-right: 8px;
            animation: subtleIconGlitch 3s infinite;
        }

        @keyframes subtleIconGlitch {
            0%, 95%, 100% {
                transform: translate(0);
                filter: hue-rotate(0deg);
            }
            2% {
                transform: translate(-1px, 0);
                filter: hue-rotate(30deg);
            }
            4% {
                transform: translate(1px, 0);
                filter: hue-rotate(-30deg);
            }
        }
    </style>
</head>
<body>
<div class="login-container">
    <div id="welcome-message"></div>
    <div id="question-container">
        <p id="question-text"></p>
        <div id="input-container">
            <p id="input-prompt"></p>
            <input type="text" id="current-input" class="hidden-input">
            <div id="password-strength" class="password-strength" style="display: none;"></div>
            <div class="button-container" id="button-container" style="display: none;">
                <p id="choice-question"></p>
                <div class="buttons-wrapper">
                    <button class="cyberpunk-button" id="register-button">
                        <span class="button-text"><span class="icon-glitch">●</span>Registrar</span>
                    </button>
                    <button class="cyberpunk-button" id="login-button">
                        <span class="button-text"><span class="icon-glitch">○</span>Login</span>
                    </button>
                </div>
            </div>
            <div class="loading-dots" id="loading-dots" style="display: none;"></div>
            <div class="command-line" id="command-line" style="display: none;"></div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const welcomeMessage = document.getElementById('welcome-message');
        const questionText = document.getElementById('question-text');
        const inputPrompt = document.getElementById('input-prompt');
        const currentInput = document.getElementById('current-input');
        const buttonContainer = document.getElementById('button-container');
        const registerButton = document.getElementById('register-button');
        const loginButton = document.getElementById('login-button');
        const commandLine = document.getElementById('command-line');
        const loadingDots = document.getElementById('loading-dots');
        const passwordStrength = document.getElementById('password-strength');

        let currentStep = 'welcome';
        let userData = {};

        // Ícones mais sutis
        const icons = {
            welcome: '●',
            user: '■',
            email: '◆',
            password: '▲',
            success: '●',
            error: '▼',
            loading: '○',
            secure: '■',
            warning: '▲',
            info: '●'
        };

        function typeWriter(element, text, speed, callback) {
            let i = 0;
            element.textContent = '';
            function typing() {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                    setTimeout(typing, speed);
                } else if (callback) {
                    callback();
                }
            }
            typing();
        }

        function addGlitchEffect(element) {
            element.classList.add('glitch');
        }

        function showNotification(message, isError = false) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            if (isError) {
                notification.classList.add('error');
            }
            notification.textContent = message;
            document.body.appendChild(notification);
            notification.offsetHeight;
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 500);
            }, 4000);
        }

        function showCursor() {
            hideCursor();
            const cursor = document.createElement('span');
            cursor.className = 'blinking-cursor';
            inputPrompt.appendChild(cursor);
        }

        function hideCursor() {
            const cursor = inputPrompt.querySelector('.blinking-cursor');
            if (cursor) {
                cursor.remove();
            }
        }

        function clearAll() {
            hideCursor();
            currentInput.style.display = 'none';
            currentInput.value = '';
            currentInput.type = 'text';
            buttonContainer.style.display = 'none';
            commandLine.style.display = 'none';
            loadingDots.style.display = 'none';
            passwordStrength.style.display = 'none';

            const inputText = inputPrompt.querySelector('.input-text');
            if (inputText) {
                inputText.remove();
            }

            const choiceQuestion = document.getElementById('choice-question');
            if (choiceQuestion) {
                choiceQuestion.textContent = '';
                choiceQuestion.classList.remove('glitch');
            }

            const buttonsWrapper = document.querySelector('.buttons-wrapper');
            if (buttonsWrapper) {
                buttonsWrapper.style.display = 'none';
                buttonsWrapper.style.opacity = '0';
            }
        }

        function showInput() {
            const existingInputText = inputPrompt.querySelector('.input-text');
            if (existingInputText) {
                existingInputText.remove();
            }

            currentInput.style.display = 'block';
            currentInput.focus();

            const inputText = document.createElement('span');
            inputText.className = 'input-text';
            inputPrompt.appendChild(inputText);
        }

        function checkPasswordStrength(password) {
            const strength = {
                score: 0,
                checks: {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                }
            };

            Object.values(strength.checks).forEach(check => {
                if (check) strength.score++;
            });

            if (currentStep === 'reg-password') {
                passwordStrength.style.display = 'block';

                if (strength.score < 3) {
                    passwordStrength.className = 'password-strength strength-weak';
                    passwordStrength.innerHTML = `<span class="icon-glitch">${icons.warning}</span> Senha fraca - Adicione maiúsculas, números e símbolos`;
                } else if (strength.score < 4) {
                    passwordStrength.className = 'password-strength strength-medium';
                    passwordStrength.innerHTML = `<span class="icon-glitch">${icons.info}</span> Senha média - Quase lá!`;
                } else {
                    passwordStrength.className = 'password-strength strength-strong';
                    passwordStrength.innerHTML = `<span class="icon-glitch">${icons.secure}</span> Senha forte - Excelente segurança!`;
                }
            }

            return strength;
        }

        function animateLoadingDots(callback) {
            loadingDots.style.display = 'block';
            let count = 0;
            const loadingIcons = ['◇', '◈', '◉', '◊'];

            const interval = setInterval(() => {
                const icon = loadingIcons[count % 4];
                loadingDots.innerHTML = `<span class="icon-glitch">${icon}</span> Processando`;
                count++;

                if (count >= 12) {
                    clearInterval(interval);
                    loadingDots.style.display = 'none';
                    if (callback) callback();
                }
            }, 200);
        }

        function createProgressBar() {
            const progressContainer = document.createElement('div');
            progressContainer.className = 'progress-bar';
            const progressFill = document.createElement('div');
            progressFill.className = 'progress-fill';
            progressContainer.appendChild(progressFill);
            return { container: progressContainer, fill: progressFill };
        }

        // Event listeners para input
        currentInput.addEventListener('input', function() {
            const inputText = inputPrompt.querySelector('.input-text');
            if (inputText) {
                if (currentInput.type === 'password') {
                    inputText.textContent = '•'.repeat(this.value.length);
                    checkPasswordStrength(this.value);
                } else {
                    inputText.textContent = this.value;
                }

                if (this.value.length > 0) {
                    hideCursor();
                } else {
                    showCursor();
                    if (currentStep === 'reg-password' || currentStep === 'login-password') {
                        passwordStrength.style.display = 'none';
                    }
                }
            }
        });

        currentInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                handleEnterPress();
            }
        });

        currentInput.addEventListener('blur', function() {
            if (currentStep !== 'choice' && currentStep !== 'welcome') {
                setTimeout(() => {
                    this.focus();
                }, 10);
            }
        });

        inputPrompt.addEventListener('click', function() {
            if (currentInput.style.display !== 'none' && currentStep !== 'choice') {
                currentInput.focus();
            }
        });

        function handleEnterPress() {
            const value = currentInput.value.trim();

            if (!value) {
                showNotification(`${icons.warning} Campo obrigatório! Digite algo para continuar.`, true);
                return;
            }

            switch (currentStep) {
                case 'name':
                    if (value.length < 2) {
                        showNotification(`${icons.warning} Nome deve ter pelo menos 2 caracteres.`, true);
                        return;
                    }
                    userData.name = value;
                    clearAll();
                    questionText.style.display = 'none';
                    inputPrompt.textContent = '';

                    buttonContainer.style.display = 'flex';

                    const choiceQuestion = document.getElementById('choice-question');
                    typeWriter(choiceQuestion, `${icons.welcome} Olá, ${value}! Escolha sua próxima ação:`, 80, function() {
                        addGlitchEffect(choiceQuestion);

                        setTimeout(() => {
                            const buttonsWrapper = document.querySelector('.buttons-wrapper');
                            buttonsWrapper.style.opacity = '0';
                            buttonsWrapper.style.display = 'flex';

                            setTimeout(() => {
                                buttonsWrapper.style.transition = 'opacity 0.5s ease';
                                buttonsWrapper.style.opacity = '1';
                            }, 100);
                        }, 500);
                    });

                    currentStep = 'choice';
                    break;

                case 'reg-username':
                    if (value.length < 3) {
                        showNotification(`${icons.warning} Nome de usuário deve ter pelo menos 3 caracteres.`, true);
                        return;
                    }
                    if (!/^[a-zA-Z0-9_.-]+$/.test(value)) {
                        showNotification(`${icons.warning} Use apenas letras, números, pontos, hífens e sublinhados.`, true);
                        return;
                    }
                    userData.username = value;
                    clearAll();
                    typeWriter(questionText, `${icons.email} Agora precisamos do seu email para contato`, 70, function() {
                        typeWriter(inputPrompt, 'Digite um email válido:', 50, function() {
                            showCursor();
                            showInput();
                            currentStep = 'reg-email';
                        });
                    });
                    break;

                case 'reg-email':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        showNotification(`${icons.warning} Formato de email inválido. Exemplo: usuario@exemplo.com`, true);
                        return;
                    }
                    userData.email = value;
                    clearAll();
                    typeWriter(questionText, `${icons.password} Última etapa: Crie uma senha super segura!`, 70, function() {
                        typeWriter(inputPrompt, 'Sua senha (mín. 8 chars, maiúscula, número):', 50, function() {
                            showCursor();
                            showInput();
                            currentInput.type = 'password';
                            currentStep = 'reg-password';
                        });
                    });
                    break;

                case 'reg-password':
                    const strength = checkPasswordStrength(value);
                    if (strength.score < 4) {
                        showNotification(`${icons.warning} Senha muito fraca! Precisa de: maiúscula, minúscula, número e 8+ caracteres.`, true);
                        return;
                    }
                    userData.password = value;
                    processRegistration();
                    break;

                case 'login-email':
                    const loginEmailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!loginEmailRegex.test(value)) {
                        showNotification(`${icons.warning} Formato de email inválido.`, true);
                        return;
                    }
                    userData.loginEmail = value;
                    clearAll();
                    typeWriter(questionText, `${icons.password} Digite sua senha para acessar`, 70, function() {
                        typeWriter(inputPrompt, 'Senha:', 50, function() {
                            showCursor();
                            showInput();
                            currentInput.type = 'password';
                            currentStep = 'login-password';
                        });
                    });
                    break;

                case 'login-password':
                    userData.loginPassword = value;
                    processLogin();
                    break;
            }
        }

        //Função genérica para enviar dados via POST e tratar resposta JSON
        function sendPost(url, data) {
            return fetch(url, {
                method: 'POST',
                body: data
            })
                .then(response => {
                    console.log(response);
                    if (!response.ok) {
                        throw new Error('Erro de rede: ' + response.status);
                    }
                    return response.json();
                });
        }



// Função que processa o registro do usuário
        function processRegistration() {
            clearAll();
            questionText.style.display = 'none';
            commandLine.style.display = 'block';

            const progress = createProgressBar();
            commandLine.appendChild(progress.container);

            typeWriter(commandLine, `${icons.loading} Iniciando processo de registro...`, 40, function() {
                progress.fill.style.width = '20%';

                const formData = new FormData();
                formData.append('action', 'register');
                formData.append('username', userData.username);
                formData.append('email', userData.email);
                formData.append('password', userData.password);

                sendPost(window.location.href, formData)
                    .then(data => {
                        if (data.success) {
                            setTimeout(() => {
                                commandLine.innerHTML = '';
                                commandLine.appendChild(progress.container);
                                progress.fill.style.width = '50%';
                                typeWriter(commandLine, `${icons.user} Criando seu perfil personalizado...`, 30, function() {
                                    setTimeout(() => {
                                        commandLine.innerHTML = '';
                                        commandLine.appendChild(progress.container);
                                        progress.fill.style.width = '80%';
                                        typeWriter(commandLine, `${icons.secure} Configurando ambiente e segurança...`, 30, function() {
                                            setTimeout(() => {
                                                commandLine.innerHTML = '';
                                                commandLine.appendChild(progress.container);
                                                progress.fill.style.width = '100%';
                                                typeWriter(commandLine, `${icons.success} Registro concluído! Agora faça login com suas credenciais.`, 25, function() {
                                                    commandLine.style.display = 'none';
                                                    showNotification(`${icons.success} ${data.message}`);

                                                    setTimeout(() => {
                                                        userData.loginEmail = userData.email;
                                                        userData.loginPassword = userData.password;
                                                        clearAll();
                                                        typeWriter(questionText, `${icons.info} Redirecionando para login...`, 70, function() {
                                                            setTimeout(() => {
                                                                clearAll();
                                                                typeWriter(questionText, `${icons.email} Email: ${userData.email}`, 50, function() {
                                                                    typeWriter(inputPrompt, 'Digite sua senha:', 50, function() {
                                                                        showCursor();
                                                                        showInput();
                                                                        currentInput.type = 'password';
                                                                        currentStep = 'login-password';
                                                                    });
                                                                });
                                                            }, 1000);
                                                        });
                                                    }, 2000);
                                                });
                                            }, 1000);
                                        });
                                    }, 1000);
                                });
                            }, 1000);
                        } else {
                            commandLine.style.display = 'none';
                            showNotification(`${icons.error} ${data.message}`, true);
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        commandLine.style.display = 'none';
                        showNotification(`${icons.error} Erro de conexão. Verificando sistemas...`, true);
                        setTimeout(() => {
                            //location.reload();
                        }, 3000);
                    });
            });
        }

// Função que processa o login do usuário
        function processLogin() {
            clearAll();
            questionText.style.display = 'none';
            commandLine.style.display = 'block';

            const progress = createProgressBar();
            commandLine.appendChild(progress.container);

            typeWriter(commandLine, `${icons.loading} Verificando suas credenciais...`, 40, function() {
                progress.fill.style.width = '30%';

                const formData = new FormData();
                formData.append('action', 'login');
                formData.append('email', userData.loginEmail);
                formData.append('password', userData.loginPassword);

                sendPost(window.location.href, formData)
                    .then(data => {
                        if (data.success) {
                            setTimeout(() => {
                                commandLine.innerHTML = '';
                                commandLine.appendChild(progress.container);
                                progress.fill.style.width = '70%';
                                typeWriter(commandLine, `${icons.secure} Autenticação confirmada! Carregando perfil...`, 30, function() {
                                    setTimeout(() => {
                                        commandLine.innerHTML = '';
                                        commandLine.appendChild(progress.container);
                                        progress.fill.style.width = '100%';
                                        typeWriter(commandLine, `${icons.success} Acesso liberado! Bem-vindo de volta${data.data?.username ? ', ' + data.data.username : ''}!`, 25, function() {
                                            commandLine.style.display = 'none';
                                            showNotification(`${icons.success} ${data.message}`);
                                            setTimeout(() => {
                                                window.location.href = data.redirect;
                                            }, 2500);
                                        });
                                    }, 1000);
                                });
                            }, 1000);
                        } else {
                            commandLine.style.display = 'none';
                            showNotification(`${icons.error} ${data.message}`, true);
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        commandLine.style.display = 'none';
                        showNotification(`${icons.error} Erro de conexão. Tentando reconectar...`, true);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    });
            });
        }


        // Event listeners para botões
        registerButton.addEventListener('click', function() {
            clearAll();
            typeWriter(inputPrompt, `${icons.loading} Inicializando sistema de registro...`, 60, function() {
                setTimeout(() => {
                    inputPrompt.textContent = '';
                    animateLoadingDots(function() {
                        typeWriter(inputPrompt, `${icons.success} Sistema pronto! Vamos criar sua conta`, 60, function() {
                            setTimeout(() => {
                                clearAll();
                                typeWriter(questionText, `${icons.user} Primeiro, escolha seu nome de usuário único`, 70, function() {
                                    typeWriter(inputPrompt, 'Nome de usuário (3+ chars, sem espaços):', 50, function() {
                                        showCursor();
                                        showInput();
                                        currentStep = 'reg-username';
                                    });
                                });
                            }, 1000);
                        });
                    });
                }, 1000);
            });
        });

        loginButton.addEventListener('click', function() {
            clearAll();
            typeWriter(inputPrompt, `${icons.loading} Acessando sistema de autenticação...`, 60, function() {
                setTimeout(() => {
                    inputPrompt.textContent = '';
                    animateLoadingDots(function() {
                        typeWriter(inputPrompt, `${icons.welcome} Sistema carregado! Bem-vindo de volta`, 60, function() {
                            setTimeout(() => {
                                clearAll();
                                typeWriter(questionText, `${icons.email} Digite seu email para continuar`, 70, function() {
                                    typeWriter(inputPrompt, 'Email:', 50, function() {
                                        showCursor();
                                        showInput();
                                        currentStep = 'login-email';
                                    });
                                });
                            }, 1000);
                        });
                    });
                }, 1000);
            });
        });

        // Iniciar a aplicação
        typeWriter(welcomeMessage, `${icons.welcome} Bem-vindo ao N-Project (Nōdo) - O TaskBoard preferido por desenvolvedores!`, 40, function() {
            addGlitchEffect(welcomeMessage);

            setTimeout(() => {
                welcomeMessage.style.transition = 'opacity 0.5s ease';
                welcomeMessage.style.opacity = '0';

                setTimeout(() => {
                    welcomeMessage.style.display = 'none';
                    typeWriter(questionText, `${icons.user} Para começar, como posso te chamar?`, 70, function() {
                        addGlitchEffect(questionText);
                        typeWriter(inputPrompt, 'Seu nome:', 50, function() {
                            showCursor();
                            showInput();
                            currentStep = 'name';
                        });
                    });
                }, 500);
            }, 2500);
        });
    });
</script>
</body>
</html>