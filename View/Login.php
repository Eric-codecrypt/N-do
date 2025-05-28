<?php
// Aqui você pode adicionar qualquer lógica PHP necessária antes de renderizar o HTML
// Por exemplo, verificação de sessão, conexão com banco de dados, etc.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
        }
        .login-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: transparent;
        }
        #welcome-message {
            font-size: 32px;
            margin-bottom: 20px;
            min-height: 50px;
        }
        #question-container {
            margin-top: 20px;
        }
        #question-text {
            font-size: 28px;
            margin-bottom: 20px;
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
        }

        }
        @keyframes glitch {
            0% {
                text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75), -0.05em -0.025em 0 rgba(0, 255, 0, 0.75), 0.025em 0.05em 0 rgba(0, 0, 255, 0.75);
            }
            14% {
                text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75), -0.05em -0.025em 0 rgba(0, 255, 0, 0.75), 0.025em 0.05em 0 rgba(0, 0, 255, 0.75);
            }
            15% {
                text-shadow: -0.05em -0.025em 0 rgba(255, 0, 0, 0.75), 0.025em 0.025em 0 rgba(0, 255, 0, 0.75), -0.05em 0.05em 0 rgba(0, 0, 255, 0.75);
            }
            49% {
                text-shadow: -0.05em -0.025em 0 rgba(255, 0, 0, 0.75), 0.025em 0.025em 0 rgba(0, 255, 0, 0.75), -0.05em 0.05em 0 rgba(0, 0, 255, 0.75);
            }
            50% {
                text-shadow: 0.025em 0.05em 0 rgba(255, 0, 0, 0.75), 0.05em 0 0 rgba(0, 255, 0, 0.75), 0 -0.05em 0 rgba(0, 0, 255, 0.75);
            }
            99% {
                text-shadow: 0.025em 0.05em 0 rgba(255, 0, 0, 0.75), 0.05em 0 0 rgba(0, 255, 0, 0.75), 0 -0.05em 0 rgba(0, 0, 255, 0.75);
            }
            100% {
                text-shadow: -0.025em 0 0 rgba(255, 0, 0, 0.75), -0.025em -0.025em 0 rgba(0, 255, 0, 0.75), -0.025em -0.05em 0 rgba(0, 0, 255, 0.75);
            }
        }
        .glitch {
            animation: glitch 1s infinite;
        }
        @keyframes blink {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0;
            }
        }
        .blinking-cursor {
            display: inline-block;
            width: 2px;
            height: 1.2em;
            background-color: #fff;
            margin-left: 5px;
            animation: blink 1s infinite;
            vertical-align: middle;
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transition: opacity 0.5s;
            z-index: 1000;
        }
        .notification.show {
            opacity: 1;
        }
        .input-text {
            color: #fff;
            margin-left: 5px;
            font-size: 24px;
            display: inline-block;
        }
        #choice-question {
            font-size: 24px;
            margin-bottom: 30px;
            color: #fff;
            font-weight: 300;
            min-height: 1.2em;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-top: 20px;
        }



        .cyberpunk-button {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            padding: 16px 32px;
            font-size: 16px;
            font-family: 'Courier New', monospace;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            min-width: 160px;
            backdrop-filter: blur(10px);
            box-shadow:
                    0 0 20px rgba(255, 255, 255, 0.2),
                    inset 0 0 20px rgba(255, 255, 255, 0.1),
                    0 0 40px rgba(255, 255, 255, 0.1);
            clip-path: polygon(15px 0%, calc(100% - 15px) 0%, 100% 15px, 100% calc(100% - 15px), calc(100% - 15px) 100%, 15px 100%, 0% calc(100% - 15px), 0% 15px);
        }

        /* Borda animada superior */
        .cyberpunk-button::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            height: 4px;
            background: linear-gradient(90deg,
            transparent,
            #ffffff,
            rgba(255, 255, 255, 0.8),
            #ffffff,
            rgba(255, 255, 255, 0.6),
            #ffffff,
            transparent
            );
            background-size: 200% 100%;
            animation: borderFlow 3s linear infinite;
            clip-path: polygon(15px 0%, calc(100% - 15px) 0%, 100% 100%, 0% 100%);
        }

        /* Borda animada inferior */
        .cyberpunk-button::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: -2px;
            right: -2px;
            height: 4px;
            background: linear-gradient(90deg,
            transparent,
            rgba(255, 255, 255, 0.6),
            #ffffff,
            rgba(255, 255, 255, 0.8),
            #ffffff,
            rgba(255, 255, 255, 0.6),
            transparent
            );
            background-size: 200% 100%;
            animation: borderFlow 3s linear infinite reverse;
            clip-path: polygon(0% 0%, 100% 0%, calc(100% - 15px) 100%, 15px 100%);
        }

        /* Bordas laterais */
        .cyberpunk-button .button-text::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            bottom: -2px;
            width: 4px;
            background: linear-gradient(180deg,
            transparent,
            #ffffff,
            rgba(255, 255, 255, 0.8),
            #ffffff,
            rgba(255, 255, 255, 0.6),
            transparent
            );
            background-size: 100% 200%;
            animation: borderFlow 2.5s linear infinite;
        }

        .cyberpunk-button .button-text::after {
            content: '';
            position: absolute;
            top: -2px;
            right: -2px;
            bottom: -2px;
            width: 4px;
            background: linear-gradient(180deg,
            transparent,
            rgba(255, 255, 255, 0.6),
            #ffffff,
            rgba(255, 255, 255, 0.8),
            #ffffff,
            transparent
            );
            background-size: 100% 200%;
            animation: borderFlow 2.5s linear infinite reverse;
        }

        .cyberpunk-button .button-text {
            position: relative;
            display: block;
            z-index: 3;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        /* Efeito de scanning interno */
        .cyberpunk-button .button-text:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
            transparent,
            rgba(255, 255, 255, 0.4),
            transparent
            );
            animation: scanning 2s linear infinite;
            z-index: 1;
        }

        /* Estados hover e active */
        .cyberpunk-button:hover {
            color: #ffffff;
            text-shadow:
                    0 0 10px #ffffff,
                    0 0 20px #ffffff,
                    0 0 30px #ffffff,
                    0 0 40px rgba(255, 255, 255, 0.8);
            transform: translateY(-3px) scale(1.02);
            box-shadow:
                    0 0 30px rgba(255, 255, 255, 0.6),
                    inset 0 0 30px rgba(255, 255, 255, 0.2),
                    0 0 60px rgba(255, 255, 255, 0.3),
                    0 10px 25px rgba(0, 0, 0, 0.3);
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
            border-color: rgba(255, 255, 255, 0.6);
        }

        .cyberpunk-button:hover::before,
        .cyberpunk-button:hover::after {
            animation-duration: 1s;
            background: linear-gradient(90deg,
            transparent,
            #ffffff,
            #ffffff,
            #ffffff,
            transparent
            );
        }

        .cyberpunk-button:hover .button-text::before,
        .cyberpunk-button:hover .button-text::after {
            animation-duration: 1s;
            background: linear-gradient(180deg,
            transparent,
            #ffffff,
            #ffffff,
            #ffffff,
            transparent
            );
        }

        .cyberpunk-button:active {
            transform: translateY(-1px) scale(0.98);
            box-shadow:
                    0 0 20px rgba(255, 255, 255, 0.8),
                    inset 0 0 20px rgba(255, 255, 255, 0.3);
        }

        /* Animações */
        @keyframes borderFlow {
            0% {
                background-position: 0% 0%;
            }
            100% {
                background-position: 200% 0%;
            }
        }

        @keyframes scanning {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }

        /* Efeito de partículas brancas */
        .cyberpunk-button:hover:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                    radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.2) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.25) 0%, transparent 50%);
            animation: particles 2s ease-in-out infinite alternate;
            z-index: 1;
        }

        @keyframes particles {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        /* Ajuste no gap dos botões */
        .buttons-wrapper {
            display: none;
            justify-content: center;
            gap: 50px;
            opacity: 0;
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
            <div class="button-container" id="button-container" style="display: none;">
                <p id="choice-question"></p>
                <div class="buttons-wrapper">
                    <button class="cyberpunk-button" id="register-button">
                        <span class="button-text">Registrar</span>
                    </button>
                    <button class="cyberpunk-button" id="login-button">
                        <span class="button-text">Login</span>
                    </button>
                </div>
            </div>
            <div class="loading-dots" id="loading-dots" style="display: none;"></div>
            <div class="command-line" id="command-line"></div>
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

        let currentStep = 'welcome';
        let userData = {};

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

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.textContent = message;
            document.body.appendChild(notification);
            notification.offsetHeight;
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 500);
            }, 3000);
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

            const inputText = inputPrompt.querySelector('.input-text');
            if (inputText) {
                inputText.remove();
            }

            // Limpar a pergunta de escolha
            const choiceQuestion = document.getElementById('choice-question');
            if (choiceQuestion) {
                choiceQuestion.textContent = '';
                choiceQuestion.classList.remove('glitch');
            }

            // Resetar os botões
            const buttonsWrapper = document.querySelector('.buttons-wrapper');
            if (buttonsWrapper) {
                buttonsWrapper.style.display = 'none';
                buttonsWrapper.style.opacity = '0';
            }
        }

        function showInput() {
            // Remover qualquer input-text anterior
            const existingInputText = inputPrompt.querySelector('.input-text');
            if (existingInputText) {
                existingInputText.remove();
            }

            // Mostrar e focar o input
            currentInput.style.display = 'block';
            currentInput.focus();

            // Criar elemento para mostrar o texto digitado
            const inputText = document.createElement('span');
            inputText.className = 'input-text';
            inputPrompt.appendChild(inputText);
        }

        function animateLoadingDots(callback) {
            loadingDots.style.display = 'block';
            let dots = '';
            let count = 0;
            const interval = setInterval(() => {
                if (count % 4 === 0) dots = '.';
                else if (count % 4 === 1) dots = '..';
                else if (count % 4 === 2) dots = '...';
                else dots = '';

                loadingDots.textContent = dots;
                count++;

                if (count >= 8) {
                    clearInterval(interval);
                    loadingDots.style.display = 'none';
                    if (callback) callback();
                }
            }, 250);
        }

        // Event listeners para input (definidos uma única vez)
        currentInput.addEventListener('input', function() {
            const inputText = inputPrompt.querySelector('.input-text');
            if (inputText) {
                inputText.textContent = this.value;

                // Esconder cursor quando começar a digitar
                if (this.value.length > 0) {
                    hideCursor();
                } else {
                    // Mostrar cursor novamente se o campo estiver vazio
                    showCursor();
                }
            }
        });

        currentInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                handleEnterPress();
            }
        });

        // Event listener para detectar quando o input perde o foco
        currentInput.addEventListener('blur', function() {
            // Refocar automaticamente se estivermos em uma etapa que precisa de input
            if (currentStep !== 'choice' && currentStep !== 'welcome') {
                setTimeout(() => {
                    this.focus();
                }, 10);
            }
        });

        // Event listener para clicar na área do input-prompt
        inputPrompt.addEventListener('click', function() {
            if (currentInput.style.display !== 'none' && currentStep !== 'choice') {
                currentInput.focus();
            }
        });

        function handleEnterPress() {
            const value = currentInput.value.trim();

            if (!value) {
                showNotification('Por favor, preencha o campo.');
                return;
            }

            switch (currentStep) {
                case 'name':
                    userData.name = value;
                    clearAll();
                    questionText.style.display = 'none';
                    inputPrompt.textContent = '';

                    // Mostrar o container dos botões primeiro
                    buttonContainer.style.display = 'flex';

                    // Aplicar efeito typewriter na pergunta
                    const choiceQuestion = document.getElementById('choice-question');
                    typeWriter(choiceQuestion, 'O que você quer fazer?', 100, function() {
                        // Adicionar efeito glitch após terminar de digitar
                        addGlitchEffect(choiceQuestion);

                        // Mostrar os botões com um pequeno delay após a pergunta
                        setTimeout(() => {
                            const buttonsWrapper = document.querySelector('.buttons-wrapper');
                            buttonsWrapper.style.opacity = '0';
                            buttonsWrapper.style.display = 'flex';

                            // Fade in dos botões
                            setTimeout(() => {
                                buttonsWrapper.style.transition = 'opacity 0.5s ease';
                                buttonsWrapper.style.opacity = '1';
                            }, 100);
                        }, 500);
                    });

                    currentStep = 'choice';
                    break;

                case 'reg-username':
                    userData.username = value;
                    clearAll();
                    typeWriter(questionText, 'Qual é o seu Email?', 100, function() {
                        showCursor();
                        showInput();
                        currentStep = 'reg-email';
                    });
                    break;

                case 'reg-email':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        showNotification('Por favor, digite um email válido.');
                        return;
                    }
                    userData.email = value;
                    clearAll();
                    typeWriter(questionText, 'Crie uma senha segura', 100, function() {
                        showCursor();
                        showInput();
                        currentInput.type = 'password';
                        currentStep = 'reg-password';
                    });
                    break;

                case 'reg-password':
                    if (value.length < 6) {
                        showNotification('A senha deve ter pelo menos 6 caracteres.');
                        return;
                    }
                    userData.password = value;
                    processRegistration();
                    break;

                case 'login-email':
                    const loginEmailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!loginEmailRegex.test(value)) {
                        showNotification('Por favor, digite um email válido.');
                        return;
                    }
                    userData.loginEmail = value;
                    clearAll();
                    typeWriter(questionText, 'Digite sua senha', 100, function() {
                        showCursor();
                        showInput();
                        currentInput.type = 'password';
                        currentStep = 'login-password';
                    });
                    break;

                case 'login-password':
                    userData.loginPassword = value;
                    processLogin();
                    break;
            }
        }

        function processRegistration() {
            clearAll();
            questionText.style.display = 'none';
            commandLine.style.display = 'block';
            typeWriter(commandLine, 'Registrando usuário...', 50, function() {
                setTimeout(() => {
                    commandLine.textContent = '';
                    typeWriter(commandLine, 'Criando perfil...', 30, function() {
                        setTimeout(() => {
                            commandLine.textContent = '';
                            typeWriter(commandLine, 'Carregando chunks...', 30, function() {
                                setTimeout(() => {
                                    commandLine.textContent = '';
                                    typeWriter(commandLine, 'Sucesso absoluto! Perfil completamente carregado.', 30, function() {
                                        commandLine.style.display = 'none';
                                        showNotification('Registro bem-sucedido! Redirecionando...');
                                        setTimeout(() => {
                                            window.location.href = 'user.php';
                                        }, 2000);
                                    });
                                }, 1000);
                            });
                        }, 1000);
                    });
                }, 1000);
            });
        }

        function processLogin() {
            clearAll();
            questionText.style.display = 'none';
            commandLine.style.display = 'block';
            typeWriter(commandLine, 'Verificando credenciais...', 50, function() {
                setTimeout(() => {
                    commandLine.textContent = '';
                    typeWriter(commandLine, 'Autenticando usuário...', 30, function() {
                        setTimeout(() => {
                            commandLine.textContent = '';
                            typeWriter(commandLine, 'Carregando perfil...', 30, function() {
                                setTimeout(() => {
                                    commandLine.textContent = '';
                                    typeWriter(commandLine, 'Sucesso absoluto! Autenticação bem-sucedida.', 30, function() {
                                        commandLine.style.display = 'none';
                                        showNotification('Login bem-sucedido! Redirecionando...');
                                        setTimeout(() => {
                                            window.location.href = 'user.php';
                                        }, 2000);
                                    });
                                }, 1000);
                            });
                        }, 1000);
                    });
                }, 1000);
            });
        }

        // Event listeners para botões
        registerButton.addEventListener('click', function() {
            clearAll();
            typeWriter(inputPrompt, 'Registro carregado com sucesso', 100, function() {
                setTimeout(() => {
                    inputPrompt.textContent = '';
                    animateLoadingDots(function() {
                        typeWriter(inputPrompt, 'Prossiga com o registro de usuário', 100, function() {
                            setTimeout(() => {
                                clearAll();
                                typeWriter(questionText, 'Qual nome prefere para seu Usuário?', 100, function() {
                                    showCursor();
                                    showInput();
                                    currentStep = 'reg-username';
                                });
                            }, 1000);
                        });
                    });
                }, 1000);
            });
        });

        loginButton.addEventListener('click', function() {
            clearAll();
            typeWriter(inputPrompt, 'Prepare-se para acessar sua conta existente', 100, function() {
                setTimeout(() => {
                    inputPrompt.textContent = '';
                    animateLoadingDots(function() {
                        typeWriter(inputPrompt, 'Bem-vindo de volta!', 100, function() {
                            setTimeout(() => {
                                clearAll();
                                typeWriter(questionText, 'Digite seu email', 100, function() {
                                    showCursor();
                                    showInput();
                                    currentStep = 'login-email';
                                });
                            }, 1000);
                        });
                    });
                }, 1000);
            });
        });

        // Iniciar a aplicação
        typeWriter(welcomeMessage, 'Olá, bem vindo ao TaskBoard preferido de muitos! Conhecido por N-project ou Nōdo', 50, function() {
            if (welcomeMessage) {
                addGlitchEffect(welcomeMessage);
            }

            setTimeout(() => {
                if (welcomeMessage) {
                    welcomeMessage.style.opacity = '0';
                }
                setTimeout(() => {
                    if (welcomeMessage) {
                        welcomeMessage.style.display = 'none';
                    }
                    if (questionText) {
                        typeWriter(questionText, 'Qual é o seu nome?', 100, function() {
                            addGlitchEffect(questionText);
                            showCursor();
                            showInput();
                            currentStep = 'name';
                        });
                    }
                }, 500);
            }, 2000);
        });
    });
</script>
</body>
</html>