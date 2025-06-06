<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nōdo - Task Board</title>
    <style>
        /* Reset básico */
        *, *::before, *::after {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at center, #0f172a 0%, #000000 100%);
            color: white;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        button {
            cursor: pointer;
            font-family: inherit;
        }

        /* Container max width */
        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Navbar */
        nav {
            position: relative;
            border-bottom: 1px solid rgba(156, 163, 175, 0.3);
            background-color: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
        }
        nav .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
        }
        .glitch-title-small {
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: 0.1em;
            position: relative;
            color: #fff;
            text-transform: uppercase;
            user-select: none;
        }

        /* Glitch effect - simples */
        .glitch-title-small::before,
        .glitch-title-small::after {
            content: attr(data-text);
            position: absolute;
            left: 0; top: 0;
            width: 100%; height: 100%;
            opacity: 0.8;
            clip-path: polygon(0 2%, 100% 2%, 100% 30%, 0 30%);
        }
        .glitch-title-small::before {
            left: 2px;
            text-shadow: -2px 0 red;
            animation: glitch-anim 2s infinite linear alternate-reverse;
        }
        .glitch-title-small::after {
            left: -2px;
            text-shadow: -2px 0 blue;
            animation: glitch-anim2 2s infinite linear alternate-reverse;
        }
        @keyframes glitch-anim {
            0% { clip-path: polygon(0 2%, 100% 2%, 100% 30%, 0 30%);}
            50% { clip-path: polygon(0 25%, 100% 25%, 100% 45%, 0 45%);}
            100% { clip-path: polygon(0 2%, 100% 2%, 100% 30%, 0 30%);}
        }
        @keyframes glitch-anim2 {
            0% { clip-path: polygon(0 60%, 100% 60%, 100% 85%, 0 85%);}
            50% { clip-path: polygon(0 70%, 100% 70%, 100% 90%, 0 90%);}
            100% { clip-path: polygon(0 60%, 100% 60%, 100% 85%, 0 85%);}
        }

        /* Button básico */
        .btn {
            background-color: white;
            color: black;
            padding: 0.5rem 1rem;
            font-weight: 600;
            border: none;
            border-radius: 0.375rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #e5e7eb;
        }
        .btn-lg {
            font-size: 1.125rem;
            padding: 1rem 2rem;
        }
        .btn-outline {
            background: none;
            border: 1px solid rgba(156, 163, 175, 0.6);
            color: #9ca3af;
        }
        .btn-outline:hover {
            background-color: rgba(156, 163, 175, 0.2);
            color: white;
        }

        /* Icons with inline SVG or emoji */
        .icon {
            width: 1rem;
            height: 1rem;
            fill: cyan;
            flex-shrink: 0;
        }
        .icon-lg {
            width: 2rem;
            height: 2rem;
        }

        /* Hero Section */
        .hero {
            text-align: center;
            margin: 4rem 0 6rem 0;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 900;
            letter-spacing: 0.1em;
            margin-bottom: 1.5rem;
            position: relative;
        }
        .hero p {
            font-size: 1.25rem;
            color: #cbd5e1;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Grid geral */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        @media(min-width: 1024px) {
            .grid-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Card estilo */
        .card {
            background-color: rgba(17, 24, 39, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 0.75rem;
            padding: 2rem;
            border: 1px solid rgba(156, 163, 175, 0.2);
            transition: background-color 0.3s ease;
        }
        .card:hover {
            background-color: rgba(17, 24, 39, 0.4);
        }
        .card .card-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .card .card-header .emoji {
            font-size: 2.5rem;
            user-select: none;
        }
        .card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 1rem 0;
            color: white;
        }
        .card p {
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }

        /* Grid dentro do card */
        .tech-list, .feature-list {
            display: grid;
            gap: 1rem;
        }
        .tech-list {
            grid-template-columns: repeat(2, 1fr);
        }
        .tech-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #94a3b8;
        }
        .tech-item .icon {
            fill: #22d3ee; /* cyan-400 */
        }

        /* Feature items */
        .feature-list {
            grid-template-columns: 1fr;
        }
        @media(min-width: 768px) {
            .feature-list {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        .feature-item {
            background-color: rgba(55, 65, 81, 0.3);
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: 1px solid rgba(107, 114, 128, 0.3);
            color: #94a3b8;
        }
        .feature-item svg {
            width: 2rem;
            height: 2rem;
            fill: #22d3ee;
            margin-bottom: 0.75rem;
        }
        .feature-item h4 {
            color: white;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 1.125rem;
        }

        /* CTA */
        .cta {
            text-align: center;
            margin-bottom: 4rem;
        }

        /* Task Board */
        .task-board {
            max-width: 1120px;
            margin: 0 auto 6rem auto;
            padding: 0 1.5rem;
        }
        .board-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        @media(min-width: 768px) {
            .board-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        .column {
            background: rgba(17, 24, 39, 0.4);
            border-radius: 0.75rem;
            padding: 1rem;
            border: 1px solid rgba(156, 163, 175, 0.3);
            display: flex;
            flex-direction: column;
            max-height: 80vh;
        }
        .column-header {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(156, 163, 175, 0.2);
            padding-bottom: 0.5rem;
            color: white;
            user-select: none;
        }
        .tasks-list {
            flex-grow: 1;
            overflow-y: auto;
        }
        .task-card {
            background: rgba(31, 41, 55, 0.8);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 0 4px #22d3ee;
            cursor: grab;
            user-select: none;
            color: white;
            transition: background-color 0.2s ease;
        }
        .task-card:hover {
            background-color: rgba(31, 41, 55, 1);
        }

        /* Add task button */
        .add-task-btn {
            background-color: transparent;
            border: 1px dashed #22d3ee;
            color: #22d3ee;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-top: auto;
            text-align: center;
            user-select: none;
        }
        .add-task-btn:hover {
            background-color: #22d3ee;
            color: black;
        }

        /* Add Task Form */
        .add-task-form {
            margin-top: 0.75rem;
            display: flex;
            flex-direction: column;
        }
        .add-task-form textarea {
            resize: none;
            min-height: 60px;
            border-radius: 0.375rem;
            border: 1px solid #22d3ee;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.5rem;
            font-family: inherit;
            font-size: 1rem;
        }
        .form-actions {
            margin-top: 0.5rem;
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }
        .form-actions button {
            padding: 0.4rem 1rem;
            border-radius: 0.375rem;
            border: none;
            font-weight: 600;
            user-select: none;
        }
        .btn-cancel {
            background-color: #ef4444;
            color: white;
        }
        .btn-cancel:hover {
            background-color: #dc2626;
        }
        .btn-add {
            background-color: #22d3ee;
            color: black;
        }
        .btn-add:hover {
            background-color: #06b6d4;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="container nav-inner">
        <a href="#" class="glitch-title-small" data-text="Nōdo">Nōdo</a>
        <a href="#task-board" class="btn btn-outline">Task Board</a>
    </div>
</nav>

<!-- Hero -->
<section class="hero container" id="hero">
    <h1>Nōdo</h1>
    <p>Figma design, componentizado e pronto para ser usado. Interface simples e intuitiva com cards para projetos e board para tarefas em React + Tailwind CSS. Aqui convertido para HTML e CSS puros.</p>
</section>

<!-- Cards principais -->
<section class="container grid-2" aria-label="Cards principais">
    <!-- Card Tecnologias -->
    <article class="card">
        <div class="card-header">
            <div class="emoji" aria-hidden="true">💻</div>
            <h3>Tecnologias</h3>
        </div>
        <div class="tech-list" role="list">
            <div class="tech-item" role="listitem">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/></svg> React
            </div>
            <div class="tech-item" role="listitem">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/></svg> Tailwind CSS
            </div>
            <div class="tech-item" role="listitem">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/></svg> TypeScript
            </div>
            <div class="tech-item" role="listitem">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/></svg> Lucide Icons
            </div>
            <div class="tech-item" role="listitem">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/></svg> React Router DOM
            </div>
        </div>
    </article>

    <!-- Card Features -->
    <article class="card">
        <div class="card-header">
            <div class="emoji" aria-hidden="true">⚡</div>
            <h3>Funcionalidades</h3>
        </div>
        <div class="feature-list">
            <div class="feature-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13 17h8M13 12h6M13 7h3"/></svg>
                <h4>Filtros</h4>
                <p>Filtre projetos por categoria.</p>
            </div>
            <div class="feature-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/></svg>
                <h4>Modal</h4>
                <p>Visualização detalhada em modal fullscreen.</p>
            </div>
            <div class="feature-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><line x1="16" y1="3" x2="16" y2="7"/><line x1="8" y1="3" x2="8" y2="7"/></svg>
                <h4>CRUD</h4>
                <p>Criar, editar e excluir projetos.</p>
            </div>
        </div>
    </article>
</section>

<!-- CTA -->
<section class="container cta">
    <button class="btn btn-lg" onclick="alert('Navegar para Task Board!')">
        Explore o Task Board
        <svg class="icon icon-lg" viewBox="0 0 24 24" fill="none" stroke="cyan" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
        </svg>
    </button>
</section>

<!-- Task Board -->
<section id="task-board" class="task-board" aria-label="Task Board">
    <h2 style="text-align:center; margin-bottom:1rem;">Task Board</h2>
    <div class="board-grid">
        <div class="column" data-status="todo">
            <div class="column-header">To Do</div>
            <div class="tasks-list" id="todo-list">
                <div class="task-card">Criar wireframe do projeto</div>
                <div class="task-card">Implementar layout base</div>
            </div>
            <button class="add-task-btn" aria-expanded="false" aria-controls="todo-form" aria-haspopup="true">+ Adicionar tarefa</button>
            <form class="add-task-form" id="todo-form" hidden>
                <textarea placeholder="Descrição da tarefa..." aria-label="Nova tarefa To Do"></textarea>
                <div class="form-actions">
                    <button type="button" class="btn-cancel">Cancelar</button>
                    <button type="submit" class="btn-add">Adicionar</button>
                </div>
            </form>
        </div>

        <div class="column" data-status="inprogress">
            <div class="column-header">In Progress</div>
            <div class="tasks-list" id="inprogress-list">
                <div class="task-card">Desenvolver funcionalidade de filtro</div>
            </div>
            <button class="add-task-btn" aria-expanded="false" aria-controls="inprogress-form" aria-haspopup="true">+ Adicionar tarefa</button>
            <form class="add-task-form" id="inprogress-form" hidden>
                <textarea placeholder="Descrição da tarefa..." aria-label="Nova tarefa In Progress"></textarea>
                <div class="form-actions">
                    <button type="button" class="btn-cancel">Cancelar</button>
                    <button type="submit" class="btn-add">Adicionar</button>
                </div>
            </form>
        </div>

        <div class="column" data-status="done">
            <div class="column-header">Done</div>
            <div class="tasks-list" id="done-list">
                <div class="task-card">Setup inicial do projeto</div>
            </div>
            <button class="add-task-btn" aria-expanded="false" aria-controls="done-form" aria-haspopup="true">+ Adicionar tarefa</button>
            <form class="add-task-form" id="done-form" hidden>
                <textarea placeholder="Descrição da tarefa..." aria-label="Nova tarefa Done"></textarea>
                <div class="form-actions">
                    <button type="button" class="btn-cancel">Cancelar</button>
                    <button type="submit" class="btn-add">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Função para mostrar/esconder form de adicionar tarefa
    document.querySelectorAll('.add-task-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const form = btn.nextElementSibling;
            const expanded = btn.getAttribute('aria-expanded') === 'true';
            if (expanded) {
                form.hidden = true;
                btn.setAttribute('aria-expanded', 'false');
            } else {
                form.hidden = false;
                btn.setAttribute('aria-expanded', 'true');
                form.querySelector('textarea').focus();
            }
        });
    });

    // Cancelar adicionar tarefa
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', () => {
            const form = btn.closest('form');
            const btnAddTask = form.previousElementSibling;
            form.hidden = true;
            btnAddTask.setAttribute('aria-expanded', 'false');
            form.querySelector('textarea').value = '';
        });
    });

    // Submeter nova tarefa
    document.querySelectorAll('.add-task-form').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            const textarea = form.querySelector('textarea');
            const text = textarea.value.trim();
            if (text) {
                const tasksList = form.previousElementSibling; // botão
                // encontrar lista de tarefas (div.tasks-list) no mesmo container
                const column = form.closest('.column');
                const list = column.querySelector('.tasks-list');
                const taskCard = document.createElement('div');
                taskCard.className = 'task-card';
                taskCard.textContent = text;
                list.appendChild(taskCard);
                textarea.value = '';
                form.hidden = true;
                column.querySelector('.add-task-btn').setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>

</body>
</html>
