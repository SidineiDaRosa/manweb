<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manutenção Fapolpa</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/template.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="{{ asset('js/date_time.js') }}"></script><!--Update data time-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/my_css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my_css/card.css') }}">

    <style>
        /* Sidebar */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: rgb(54, 84, 148);
            padding: 10px;
            box-sizing: border-box;
            overflow-y: auto;
            transition: transform 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 999;
        }

        .sidebar.active {
            transform: translateX(-260px);
        }

        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-list li {
            margin-bottom: 5px;
        }

        .nav-list a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #b1b7caff;
            padding: 8px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .nav-list a:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .nav-list i {
            margin-right: 8px;
        }

        .submenu {
            display: none;
            padding-left: 20px;
        }

        .submenu a {
            font-size: 14px;
            padding: 6px 8px;
            display: block;
        }

        .submenu.show {
            display: block;
        }

        .divider {
            border-bottom: 1px solid #ccc;
            margin: 5px 0;
        }

        .arrow {
            margin-left: auto;
            display: inline-block;
            transition: transform 0.3s ease;
            font-size: 16px;
        }

        .arrow.down {
            transform: rotate(90deg);
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 998;
            height: 60px;
        }

        .menu-toggle {
            cursor: pointer;
        }

        .logo {
            margin-left: 20px;
            display: flex;
            align-items: center;
            font-size: 18px;
        }

        .spacer {
            flex: 1;
        }

        /* Notifications */
        .notifications {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .notification {
            position: relative;
            cursor: pointer;
        }

        .badge {
            display: inline-block;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            color: white;
            text-align: center;
            line-height: 25px;
            font-size: 14px;
            font-weight: bold;
            position: absolute;
            top: -5px;
            right: -10px;
            z-index: 1000;
        }

        .badge.zero {
            background-color: green;
        }

        .badge.non-zero {
            background-color: red;
        }

        .badge.warning {
            background-color: orange;
        }

        .badge.yellow {
            background-color: gold;
        }

        /* Dropdown do usuário */
        .dropdown {
            position: relative;
        }

        .dropdown-button {
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 40px;
            background-color: #f5f5f5;
            min-width: 160px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 4px;
            z-index: 100;
        }

        .dropdown-content ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .dropdown-content ul li {
            padding: 10px;
        }

        .dropdown-content ul li a {
            text-decoration: none;
            color: #333;
            display: block;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Conteúdo principal */
        .main-content {
            margin-left: 250px;
            padding: 80px 20px 20px 20px;
            transition: margin-left 0.3s ease;
        }

        .main-content.sidebar-collapsed {
            margin-left: 0;
        }

        @media(max-width: 768px) {
            .sidebar {
                transform: translateX(-260px);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.sidebar-collapsed {
                margin-left: 0;
            }
        }
    </style>
</head>

<!-- Header -->
<header class="header">

    <div class="menu-toggle mx-3">
        <i class="icofont-navigation-menu"></i>
    </div>

    <div class="spacer"></div>

    <!-- Notifications -->
    <!-- Oculta icones -->
    @if (auth()->check() && auth()->user()->level <= 2)
        <div class="notifications">

            @if (auth()->check() && auth()->user()->id == 3)
                <div class="notification">
                    <a href="{{ route('notificacoes.index') }}">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span class="badge-mini" id="alarms-badge">0</span>
                    </a>
                </div>
            @endif

            <div class="notification">
                <a href="{{ route('lubrificacao.index') }}">
                    <i class="bi bi-droplet-half"></i>
                    <span class="badge-mini" id="lubrificacao-badge">0</span>
                </a>
            </div>

            <div class="notification">
                <a href="/check-list-index">
                    <i class="bi bi-card-checklist"></i>
                    <span class="badge-mini" id="checklist-badge">0</span>
                </a>
            </div>

            <div class="notification">
                <a href="/solicitacoes-os">
                    <i class="bi bi-card-text"></i>
                    <span class="badge-mini" id="solicitacoes-badge">0</span>
                </a>
            </div>

            <div class="notification">
                <a href="{{ route('groups.index') }}">
                    <i class="bi bi-chat-dots-fill"></i>
                    <span class="badge-mini" id="messages-badge">0</span>
                </a>
            </div>

        </div>
    @endif
    <!-- Usuário -->
    <div class="user-menu ml-3">
        <div class="user-menu-btn" id="userMenuBtn">
            {{ Auth::user()->name }}
            <i class="icofont-simple-down mx-2"></i>
        </div>

        <div class="user-menu-box" id="userMenuBox">
            <ul>
                <li>
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <style>
        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .user-menu-btn {
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .user-menu-btn:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .user-menu-box {
            display: none;
            position: absolute;
            right: 0;
            top: 110%;
            background: #ffffff;
            min-width: 160px;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
            z-index: 9999;
            padding: 6px 0;
        }

        .user-menu-box.active {
            display: block;
        }

        /* lista */
        .user-menu-box ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .user-menu-box li a {
            display: block;
            padding: 10px 16px;
            color: #333;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }

        .user-menu-box li a:hover {
            background: #f5f5f5;
            color: #000;
        }

        .notifications {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .notification {
            position: relative;
        }

        .notification a {
            color: white;
            font-size: 22px;
            position: relative;
            transition: transform 0.2s ease;
        }

        .notification a:hover {
            transform: scale(1.1);
        }

        /* Badge estilo Facebook */
        .badge-mini {
            position: absolute;
            top: -6px;
            right: -8px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 50px;
            background: #e41e3f;
            color: white;
            font-size: 11px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #343a40;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
        }

        /* Quando for zero */
        .badge-mini.zero {
            background: #28a745;
        }

        /* Aviso */
        .badge-mini.warning {
            background: #ffc107;
            color: #000;
        }

        /* Notificação pulsando */
        .badge-mini.non-zero {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
    <script>
        document.getElementById('userMenuBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('userMenuBox').classList.toggle('active');
        });

        document.addEventListener('click', function() {
            document.getElementById('userMenuBox').classList.remove('active');
        });
    </script>



</header>
@include('app.layouts.left') <!-- Sidebar -->
<script>
    // Toggle sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.querySelector('.menu-toggle');
        const sidebar = document.getElementById('sidebarleft');
        const mainContent = document.querySelector('.main-content');

        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('sidebar-collapsed');
        });
    });

    // Submenu toggle
    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        submenu.classList.toggle('show');
        const arrow = submenu.previousElementSibling.querySelector('.arrow');
        if (arrow) arrow.classList.toggle('down');
    }

    // Função para atualizar badges
    function atualizarBadge(idBadge, url, classZero = 'zero', classNonZero = 'non-zero', classWarning = null) {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById(idBadge);
                badge.innerText = data.pendentes;
                badge.classList.remove(classZero, classNonZero, classWarning);
                if (data.pendentes > 0) {
                    badge.classList.add(classWarning || classNonZero);
                } else {
                    badge.classList.add(classZero);
                }
            })
            .catch(err => console.error(err));
    }

    setInterval(() => {
        atualizarBadge('solicitacoes-badge', '/solicitacoes-pendentes');
        atualizarBadge('checklist-badge', '/check-list-pendentes', 'zero', 'non-zero', 'warning');
        atualizarBadge('alarms-badge', '/alarms-count', 'zero', 'non-zero', 'yellow');
        atualizarBadge('messages-badge', '/messages-count', 'zero', 'non-zero', 'yellow');
        atualizarBadge('lubrificacao-badge', '/lubrificacao-count', 'zero', 'non-zero', 'yellow');
    }, 30000);

    // Atualiza imediatamente
    atualizarBadge('solicitacoes-badge', '/solicitacoes-pendentes');
    atualizarBadge('checklist-badge', '/check-list-pendentes', 'zero', 'non-zero', 'warning');
    atualizarBadge('alarms-badge', '/alarms-count', 'zero', 'non-zero', 'yellow');
    atualizarBadge('messages-badge', '/messages-count', 'zero', 'non-zero', 'yellow');
    atualizarBadge('lubrificacao-badge', '/lubrificacao-count', 'zero', 'non-zero', 'yellow');
</script>

</html>
