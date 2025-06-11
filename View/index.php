<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nōdo - Task Board</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at center, #0f172a 0%, #000000 100%);
            color: white;
        }
        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        nav {
            border-bottom: 1px solid rgba(156, 163, 175, 0.3);
            background-color: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
        }
        .nav-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        .glitch-title-small {
            font-weight: 900;
            font-size: 1.5rem;
            text-transform: uppercase;
            position: relative;
            letter-spacing: 0.1em;
        }
        .glitch-title-small::before,
        .glitch-title-small::after {
            content: attr(data-text);
            position: absolute;
            width: 100%; height: 100%;
            top: 0; left: 0;
            opacity: 0.8;
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
            0%, 100% { clip-path: inset(0 0 70% 0); }
            50% { clip-path: inset(20% 0 40% 0); }
        }
        @keyframes glitch-anim2 {
            0%, 100% { clip-path: inset(60% 0 0 0); }
            50% { clip-path: inset(70% 0 10% 0); }
        }
        .hero {
            text-align: center;
            margin: 4rem 0 6rem 0;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
        }
        .hero p {
            font-size: 1.25rem;
            color: #cbd5e1;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        /* ========== TASK BOARD ========== */
        .task-board {
            max-width: 1120px;
            margin: 0 auto 6rem;
            padding: 0 1.5rem;
        }
        .board-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(1, 1fr);
        }
        @media(min-width: 768px) {
            .board-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        .column {
            border-radius: 0.75rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            min-height: 400px;
        }
        .column-header {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(156, 163, 175, 0.2);
            padding-bottom: 0.5rem;
        }
        .tasks-list {
            flex-grow: 1;
            min-height: 100px;
            overflow-y: auto;
        }
        .task-card {
            background: rgba(31, 41, 55, 0.9);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 0 4px #22d3ee;
            cursor: grab;
            position: relative;
        }
        .task-card.dragging {
            opacity: 0.5;
        }
        .task-actions {
            position: absolute;
            right: 0.5rem;
            top: 0.5rem;
            display: flex;
            gap: 0.25rem;
        }
        .task-action-btn {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(30, 41, 59, 0.7);
            border-radius: 4px;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 12px;
        }
        .task-action-btn:hover {
            background: rgba(30, 41, 59, 1);
        }
        .task-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            padding-right: 60px;
        }
        .task-description {
            font-size: 0.875rem;
            color: #cbd5e1;
            margin-bottom: 0.75rem;
        }
        .task-meta {
            display: flex flex-wrap;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        .task-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .task-badge.priority {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
        .task-badge.priority.low {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
        .task-badge.priority.medium {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }
        .task-badge.priority.high {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
            border: 1px solid rgba(249, 115, 22, 0.3);
        }
        .task-badge.priority.urgent {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .task-badge.category {
            background: rgba(147, 197, 253, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(147, 197, 253, 0.3);
        }
        .task-badge.due {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }
        .task-badge.due.overdue {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .subtasks {
            margin-top: 0.75rem;
            border-top: 1px solid rgba(156, 163, 175, 0.2);
            padding-top: 0.75rem;
        }
        .subtask {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        .subtask-checkbox {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .subtask-checkbox.checked {
            background: #22c55e;
            border-color: #22c55e;
        }
        .subtask-checkbox.checked::after {
            content: "✓";
            color: white;
            font-size: 12px;
        }
        .subtask-text {
            flex-grow: 1;
        }
        .subtask-text.completed {
            text-decoration: line-through;
            color: #94a3b8;
        }
        .add-subtask-btn {
            font-size: 0.75rem;
            color: #22d3ee;
            background: transparent;
            border: 1px dashed #22d3ee;
            border-radius: 4px;
            padding: 0.25rem 0.5rem;
            cursor: pointer;
            margin-top: 0.5rem;
            width: 100%;
            text-align: center;
        }
        .add-subtask-btn:hover {
            background: #22d3ee;
            color: black;
        }
        .add-task-btn {
            margin-top: auto;
            padding: 0.75rem;
            border: 1px dashed #22d3ee;
            border-radius: 0.5rem;
            color: #22d3ee;
            font-weight: 600;
            text-align: center;
            background: transparent;
            cursor: pointer;
        }
        .add-task-btn:hover {
            background-color: #22d3ee;
            color: black;
        }
        .red-column { background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; }
        .yellow-column { background: rgba(251, 191, 36, 0.1); border: 1px solid #fbbf24; }
        .green-column { background: rgba(34, 197, 94, 0.1); border: 1px solid #22c55e; }
        .drag-over {
            outline: 2px dashed #22d3ee;
            outline-offset: -4px;
        }
        .version-tag {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
            border-radius: 0.5rem;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            z-index: 100;
        }
        .version-tag .git-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }
        .version-tag .git-icon:hover {
            transform: scale(1.1);
        }
        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s linear 0.25s, opacity 0.25s linear;
        }
        .modal-overlay.active {
            visibility: visible;
            opacity: 1;
            transition-delay: 0s;
        }
        .modal {
            background: #1e293b;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 1.5rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
        }
        .modal-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1.5rem;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #cbd5e1;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.25rem;
            border: 1px solid #475569;
            background-color: #334155;
            color: white;
        }
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1.5em 1.5em;
        }
        .form-textarea {
            min-height: 80px;
            resize: vertical;
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: background-color 0.2s;
        }
        .btn-primary {
            background-color: #22d3ee;
            color: black;
        }
        .btn-primary:hover {
            background-color: #0ea5e9;
        }
        .btn-secondary {
            background-color: #475569;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #334155;
        }
        .toast {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 0.75rem 1.5rem;
            background: #22c55e;
            color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            opacity: 0;
            transform: translateY(-1rem);
            transition: opacity 0.3s, transform 0.3s;
        }
        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
        .toast-content {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .toast-icon {
            font-size: 1.25rem;
        }
        .toast-message {
            flex-grow: 1;
        }
        .filter-section {
            background: rgba(31, 41, 55, 0.9);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .filter-label {
            font-size: 0.875rem;
            color: #cbd5e1;
        }
        .filter-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1.5em 1.5em;
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.25rem;
            border: 1px solid #475569;
            background-color: #334155;
            color: white;
        }
        .filter-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 0.5rem;
        }
        .filter-btn {
            background: none;
            border: 1px solid #22d3ee;
            color: #22d3ee;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            font-weight: 600;
        }
        .filter-btn:hover {
            background-color #22d3ee;
            color: black;
        }
    </style>
</head>
<body>
<nav>
    <div class="container nav-inner">
        <div class="glitch-title-small" data-text="Nōdo">Nōdo</div>
    </div>
</nav>
<section class="hero">
    <h1>Organize suas Tarefas</h1>
    <p>Arraste tarefas entre colunas, clique para adicionar.</p>
</section>
<div class="container">
    <div class="filter-section">
        <div class="filter-grid">
            <div class="filter-group">
                <div class="filter-label">Pesquisar</div>
                <input type="text" id="searchInput" placeholder="Buscar tarefas..." class="form-input" />
            </div>
            <div class="filter-group">
                <div class="filter-label">Status</div>
                <select id="statusFilter" class="filter-select">
                    <option value="all">Todos</option>
                    <option value="todo">A Fazer</option>
                    <option value="progress">Em Progresso</option>
                    <option value="done">Concluído</option>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">Prioridade</div>
                <select id="priorityFilter" class="filter-select">
                    <option value="all">Todas</option>
                    <option value="low">Baixa</option>
                    <option value="medium">Média</option>
                    <option value="high">Alta</option>
                    <option value="urgent">Urgente</option>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">Categoria</div>
                <select id="categoryFilter" class="filter-select">
                    <option value="all">Todas</option>
                    <option value="Geral">Geral</option>
                    <option value="Trabalho">Trabalho</option>
                    <option value="Pessoal">Pessoal</option>
                    <option value="Projeto">Projeto</option>
                    <option value="Urgente">Urgente</option>
                    <option value="Estudos">Estudos</option>
                </select>
            </div>
            <div class="filter-group filter-actions">
                <button id="clearFilters" class="filter-btn">Limpar</button>
            </div>
        </div>
    </div>
</div>
<section class="task-board">
    <div class="board-grid">
        <div class="column red-column">
            <div class="column-header">A Fazer</div>
            <div class="tasks-list" data-status="todo"></div>
            <div class="add-task-btn" data-status="todo">+ Nova Tarefa</div>
        </div>
        <div class="column yellow-column">
            <div class="column-header">Em Progresso</div>
            <div class="tasks-list" data-status="progress"></div>
            <div class="add-task-btn" data-status="progress">+ Nova Tarefa</div>
        </div>
        <div class="column green-column">
            <div class="column-header">Concluído</div>
            <div class="tasks-list" data-status="done"></div>
            <div class="add-task-btn" data-status="done">+ Nova Tarefa</div>
        </div>
    </div>
</section>

<!-- Modal for creating/editing tasks -->
<div id="taskModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Nova Tarefa</h3>
            <button class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label" for="taskTitle">Título</label>
                <input type="text" id="taskTitle" class="form-input" placeholder="Digite o título da tarefa">
            </div>
            <div class="form-group">
                <label class="form-label" for="taskDescription">Descrição</label>
                <textarea id="taskDescription" class="form-textarea" placeholder="Descrição opcional"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="taskStatus">Status</label>
                <select id="taskStatus" class="form-select">
                    <option value="todo">A Fazer</option>
                    <option value="progress">Em Progresso</option>
                    <option value="done">Concluído</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="taskPriority">Prioridade</label>
                <select id="taskPriority" class="form-select">
                    <option value="low">Baixa</option>
                    <option value="medium">Média</option>
                    <option value="high">Alta</option>
                    <option value="urgent">Urgente</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="taskCategory">Categoria</label>
                <select id="taskCategory" class="form-select">
                    <option value="Geral">Geral</option>
                    <option value="Trabalho">Trabalho</option>
                    <option value="Pessoal">Pessoal</option>
                    <option value="Projeto">Projeto</option>
                    <option value="Urgente">Urgente</option>
                    <option value="Estudos">Estudos</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="taskDueDate">Data de Vencimento</label>
                <input type="date" id="taskDueDate" class="form-input">
            </div>
        </div>
        <div class="form-actions">
            <button id="cancelTaskBtn" class="btn btn-secondary">Cancelar</button>
            <button id="saveTaskBtn" class="btn btn-primary">Salvar Tarefa</button>
        </div>
    </div>
</div>

<!-- Toast notification -->
<div id="toast" class="toast">
    <div class="toast-content">
        <span class="toast-icon">✓</span>
        <span class="toast-message">Tarefa salva com sucesso!</span>
    </div>
</div>

<div class="version-tag">
    Versão [0.032..0] - Todos os Direitos Reservados
    <a href="https://github.com/Eric_Excrypt/N-do" target="_blank" class="git-icon" aria-label="GitHub">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="#cbd5e1">
            <path d="M12 .5C5.73.5.5 5.73.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.3.8-.6v-2.2c-3.2.7-3.8-1.4-3.8-1.4-.5-1.3-1.2-1.6-1.2-1.6-1-.6.1-.6.1-.6 1.1.1 1.7 1.1 1.7 1 .6 1 2.3.7 3.2.5.1-.5.3-1 .6-1.3-2.6-.3-5.4-1.3-5.4-5.9 0-1.3.5-2.3 1.2-3.2-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2.9-.3 1.9-.5 2.9-.5s2 .2 2.9.5c2.2-1.5 3.3-1.2 3.3-1.2.6 1.6.2 2.8.1 3.1.8.9 1.2 2 1.2 3.2 0 4.6-2.8 5.6-5.4 5.9.4.3.7.9.7 1.9v2.9c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.73 18.27.5 12 .5z"/>
        </svg>
    </a>
</div>

<script>
    // Task data structure
    let tasks = [];
    let currentTaskId = 1;
    let editingTaskId = null;

    // DOM Elements
    const taskLists = document.querySelectorAll('.tasks-list');
    const addTaskButtons = document.querySelectorAll('.add-task-btn');
    const taskModal = document.getElementById('taskModal');
    const modalClose = document.querySelector('.modal-close');
    const taskTitleInput = document.getElementById('taskTitle');
    const taskDescriptionInput = document.getElementById('taskDescription');
    const taskStatusSelect = document.getElementById('taskStatus');
    const taskPrioritySelect = document.getElementById('taskPriority');
    const taskCategorySelect = document.getElementById('taskCategory');
    const taskDueDateInput = document.getElementById('taskDueDate');
    const saveTaskBtn = document.getElementById('saveTaskBtn');
    const cancelTaskBtn = document.getElementById('cancelTaskBtn');
    const toast = document.getElementById('toast');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const priorityFilter = document.getElementById('priorityFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');

    // Initialize tasks from localStorage
    function initTasks() {
        const savedTasks = localStorage.getItem('nodo-tasks');
        if (savedTasks) {
            tasks = JSON.parse(savedTasks);
            currentTaskId = Math.max(...tasks.map(task => task.id), 0) + 1;
            renderTasks();
        } else {
            // Initial demo tasks
            tasks = [
                {
                    id: 1,
                    title: 'Revisar documentação do projeto',
                    description: 'Revisar e atualizar a documentação técnica',
                    status: 'todo',
                    priority: 'high',
                    category: 'Trabalho',
                    dueDate: '2025-06-15',
                    completed: false,
                    subtasks: [
                        { id: '1-1', title: 'Revisar API docs', completed: true },
                        { id: '1-2', title: 'Atualizar README', completed: false }
                    ],
                    expanded: false,
                    createdAt: new Date().toISOString()
                },
                {
                    id: 2,
                    title: 'Implementar nova funcionalidade',
                    description: 'Desenvolver sistema de notificações',
                    status: 'progress',
                    priority: 'medium',
                    category: 'Projeto',
                    dueDate: '2025-06-20',
                    completed: false,
                    subtasks: [],
                    expanded: false,
                    createdAt: new Date().toISOString()
                }
            ];
            saveTasks();
            renderTasks();
        }
    }

    // Save tasks to localStorage
    function saveTasks() {
        localStorage.setItem('nodo-tasks', JSON.stringify(tasks));
    }

    // Render all tasks based on filters
    function renderTasks() {
        // Clear all task lists
        taskLists.forEach(list => {
            list.innerHTML = '';
        });

        // Filter tasks
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const priorityValue = priorityFilter.value;
        const categoryValue = categoryFilter.value;

        const filteredTasks = tasks.filter(task => {
            const matchesSearch = task.title.toLowerCase().includes(searchTerm) ||
                task.description?.toLowerCase().includes(searchTerm);
            const matchesStatus = statusValue === 'all' || task.status === statusValue;
            const matchesPriority = priorityValue === 'all' || task.priority === priorityValue;
            const matchesCategory = categoryValue === 'all' || task.category === categoryValue;

            return matchesSearch && matchesStatus && matchesPriority && matchesCategory;
        });

        // Render each task in the appropriate column
        filteredTasks.forEach(task => {
            const taskElement = createTaskElement(task);
            const list = document.querySelector(`.tasks-list[data-status="${task.status}"]`);
            if (list) {
                list.appendChild(taskElement);
            }
        });
    }

    // Create a task element
    function createTaskElement(task) {
        const taskElement = document.createElement('div');
        taskElement.className = 'task-card';
        taskElement.setAttribute('draggable', 'true');
        taskElement.setAttribute('data-task-id', task.id);
        taskElement.setAttribute('data-status', task.status);

        // Task actions
        const actionsDiv = document.createElement('div');
        actionsDiv.className = 'task-actions';

        const editBtn = document.createElement('button');
        editBtn.className = 'task-action-btn';
        editBtn.innerHTML = '<span>✏️</span>';
        editBtn.addEventListener('click', () => openEditTaskModal(task.id));

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'task-action-btn';
        deleteBtn.innerHTML = '<span>🗑️</span>';
        deleteBtn.addEventListener('click', () => deleteTask(task.id));

        actionsDiv.appendChild(editBtn);
        actionsDiv.appendChild(deleteBtn);
        taskElement.appendChild(actionsDiv);

        // Task title
        const titleElement = document.createElement('div');
        titleElement.className = 'task-title';
        titleElement.textContent = task.title;
        taskElement.appendChild(titleElement);

        // Task description
        if (task.description) {
            const descriptionElement = document.createElement('div');
            descriptionElement.className = 'task-description';
            descriptionElement.textContent = task.description;
            taskElement.appendChild(descriptionElement);
        }

        // Task meta (priority, category, due date)
        const metaDiv = document.createElement('div');
        metaDiv.className = 'task-meta';

        // Priority badge
        const priorityBadge = document.createElement('span');
        priorityBadge.className = `task-badge priority priority-${task.priority}`;
        priorityBadge.innerHTML = `<span>${task.priority === 'low' ? 'Baixa' :
            task.priority === 'medium' ? 'Média' :
                task.priority === 'high' ? 'Alta' : 'Urgente'}</span>`;
        metaDiv.appendChild(priorityBadge);

        // Category badge
        const categoryBadge = document.createElement('span');
        categoryBadge.className = 'task-badge category';
        categoryBadge.textContent = task.category;
        metaDiv.appendChild(categoryBadge);

        // Due date badge
        if (task.dueDate) {
            const isOverdue = new Date(task.dueDate) < new Date() && task.status !== 'done';
            const dueBadge = document.createElement('span');
            dueBadge.className = `task-badge due ${isOverdue ? 'overdue' : ''}`;
            dueBadge.textContent = new Date(task.dueDate).toLocaleDateString('pt-BR');
            metaDiv.appendChild(dueBadge);
        }

        taskElement.appendChild(metaDiv);

        // Subtasks section
        if (task.subtasks.length > 0) {
            const subtasksDiv = document.createElement('div');
            subtasksDiv.className = 'subtasks';

            const subtasksHeader = document.createElement('div');
            subtasksHeader.className = 'subtasks-header';

            const completedCount = task.subtasks.filter(subtask => subtask.completed).length;
            const totalCount = task.subtasks.length;

            const subtasksTitle = document.createElement('button');
            subtasksTitle.className = 'subtasks-title';
            subtasksTitle.innerHTML = `
                <span>${completedCount}/${totalCount} subtarefas</span>
                <span>${task.expanded ? '▼' : '▶'}</span>
            `;
            subtasksTitle.addEventListener('click', () => toggleSubtasks(task.id));
            subtasksHeader.appendChild(subtasksTitle);
            subtasksDiv.appendChild(subtasksHeader);

            if (task.expanded) {
                task.subtasks.forEach(subtask => {
                    const subtaskElement = document.createElement('div');
                    subtaskElement.className = 'subtask';
                    subtaskElement.setAttribute('data-subtask-id', subtask.id);

                    const checkbox = document.createElement('button');
                    checkbox.className = `subtask-checkbox ${subtask.completed ? 'checked' : ''}`;
                    checkbox.addEventListener('click', () => toggleSubtask(task.id, subtask.id));

                    const text = document.createElement('span');
                    text.className = `subtask-text ${subtask.completed ? 'completed' : ''}`;
                    text.textContent = subtask.title;

                    subtaskElement.appendChild(checkbox);
                    subtaskElement.appendChild(text);
                    subtasksDiv.appendChild(subtasksElement);
                });

                const addSubtaskBtn = document.createElement('button');
                addSubtaskBtn.className = 'add-subtask-btn';
                addSubtaskBtn.textContent = 'Adicionar subtarefa';
                addSubtaskBtn.addEventListener('click', () => addSubtask(task.id));
                subtasksDiv.appendChild(addSubtaskBtn);
            }

            taskElement.appendChild(subtasksDiv);
        } else {
            const addSubtaskBtn = document.createElement('button');
            addSubtaskBtn.className = 'add-subtask-btn';
            addSubtaskBtn.textContent = 'Adicionar subtarefa';
            addSubtaskBtn.addEventListener('click', () => addSubtask(task.id));
            taskElement.appendChild(addSubtaskBtn);
        }

        // Setup drag events
        taskElement.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', task.id);
            taskElement.classList.add('dragging');
        });

        taskElement.addEventListener('dragend', () => {
            taskElement.classList.remove('dragging');
        });

        return taskElement;
    }

    // Toggle subtasks visibility
    function toggleSubtasks(taskId) {
        const task = tasks.find(t => t.id === taskId);
        if (task) {
            task.expanded = !task.expanded;
            renderTasks();
        }
    }

    // Toggle subtask completion
    function toggleSubtask(taskId, subtaskId) {
        const task = tasks.find(t => t.id === taskId);
        if (task) {
            const subtask = task.subtasks.find(st => st.id === subtaskId);
            if (subtask) {
                subtask.completed = !subtask.completed;
                renderTasks            }
        }
    }

    // Add a new subtask to a task
    function addSubtask(taskId) {
        const task = tasks.find(t => t.id === taskId);
        if (task) {
            const subtaskTitle = prompt('Digite o título da subtarefa:');
            if (subtaskTitle && subtaskTitle.trim()) {
                task.subtasks.push({
                    id: `${taskId}-${Date.now()}`,
                    title: subtaskTitle.trim(),
                    completed: false
                });
                task.expanded = true;
                saveTasks();
                renderTasks();
            }
        }
    }

    // Delete a task
    function deleteTask(taskId) {
        if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
            tasks = tasks.filter(t => t.id !== taskId);
            saveTasks();
            renderTasks();
            showToast('Tarefa excluída com sucesso!');
        }
    }

    // Open the task modal for creating a new task
    function openTaskModal() {
        editingTaskId = null;
        document.querySelector('.modal-title').textContent = 'Nova Tarefa';
        taskTitleInput.value = '';
        taskDescriptionInput.value = '';
        taskStatusSelect.value = 'todo';
        taskPrioritySelect.value = 'medium';
        taskCategorySelect.value = 'Geral';
        taskDueDateInput.value = '';
        taskModal.classList.add('active');
    }

    // Open the task modal for editing an existing task
    function openEditTaskModal(taskId) {
        const task = tasks.find(t => t.id === taskId);
        if (task) {
            editingTaskId = taskId;
            document.querySelector('.modal-title').textContent = 'Editar Tarefa';
            taskTitleInput.value = task.title;
            taskDescriptionInput.value = task.description || '';
            taskStatusSelect.value = task.status;
            taskPrioritySelect.value = task.priority;
            taskCategorySelect.value = task.category;
            taskDueDateInput.value = task.dueDate || '';
            taskModal.classList.add('active');
        }
    }

    // Close the task modal
    function closeTaskModal() {
        taskModal.classList.remove('active');
    }

    // Save a task (create or update)
    function saveTask() {
        const title = taskTitleInput.value.trim();
        if (!title) {
            alert('Por favor, digite um título para a tarefa.');
            return;
        }

        const taskData = {
            title,
            description: taskDescriptionInput.value.trim(),
            status: taskStatusSelect.value,
            priority: taskPrioritySelect.value,
            category: taskCategorySelect.value,
            dueDate: taskDueDateInput.value || null
        };

        if (editingTaskId) {
            // Update existing task
            const taskIndex = tasks.findIndex(t => t.id === editingTaskId);
            if (taskIndex !== -1) {
                tasks[taskIndex] = {
                    ...tasks[taskIndex],
                    ...taskData
                };
                showToast('Tarefa atualizada com sucesso!');
            }
        } else {
            // Create new task
            const newTask = {
                id: currentTaskId++,
                ...taskData,
                completed: false,
                subtasks: [],
                expanded: false,
                createdAt: new Date().toISOString()
            };
            tasks.push(newTask);
            showToast('Nova tarefa criada com sucesso!');
        }

        saveTasks();
        closeTaskModal();
        renderTasks();
    }

    // Show toast notification
    function showToast(message) {
        const toastMessage = document.querySelector('.toast-message');
        toastMessage.textContent = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    // Initialize drag and drop for columns
    function initDragAndDrop() {
        const columns = document.querySelectorAll('.column');

        columns.forEach(column => {
            column.addEventListener('dragover', (e) => {
                e.preventDefault();
                column.classList.add('drag-over');
            });

            column.addEventListener('dragleave', () => {
                column.classList.remove('drag-over');
            });

            column.addEventListener('drop', (e) => {
                e.preventDefault();
                const taskId = e.dataTransfer.getData('text/plain');
                const newStatus = column.querySelector('.tasks-list').getAttribute('data-status');

                const taskIndex = tasks.findIndex(t => t.id.toString() === taskId);
                if (taskIndex !== -1) {
                    tasks[taskIndex].status = newStatus;
                    tasks[taskIndex].completed = newStatus === 'done';
                    saveTasks();
                    renderTasks();
                    showToast('Status da tarefa atualizado!');
                }

                column.classList.remove('drag-over');
            });
        });
    }

    // Initialize filter functionality
    function initFilters() {
        const filterInputs = [searchInput, statusFilter, priorityFilter, categoryFilter];

        filterInputs.forEach(input => {
            input.addEventListener('input', renderTasks);
            input.addEventListener('change', renderTasks);
        });

        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            statusFilter.value = 'all';
            priorityFilter.value = 'all';
            categoryFilter.value = 'all';
            renderTasks();
        });
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', () => {
        initTasks();
        initDragAndDrop();
        initFilters();

        // Add task buttons
        addTaskButtons.forEach(button => {
            button.addEventListener('click', () => {
                const status = button.getAttribute('data-status');
                taskStatusSelect.value = status;
                openTaskModal();
            });
        });

        // Modal events
        modalClose.addEventListener('click', closeTaskModal);
        cancelTaskBtn.addEventListener('click', closeTaskModal);
        saveTaskBtn.addEventListener('click', saveTask);

        // Click outside modal to close
        taskModal.addEventListener('click', (e) => {
            if (e.target === taskModal) {
                closeTaskModal();
            }
        });
    });
</script>
</body>
</html>