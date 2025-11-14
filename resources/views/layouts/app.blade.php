<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .sidebar {
            width: 280px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            background: linear-gradient(180deg, #053b8c 0%, #085cd1 100%);
            border-right: 1px solid #30363d;
            z-index: 1000;
            padding-top: 60px;
            transition: transform 0.3s ease;
        }

        .main-content {
            margin-left: 280px;
            height: calc(100vh - 60px);
            margin-top: 60px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: margin-left 0.3s ease;
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
            position: relative;
            min-height: 0;
            background-color: #0c78ec;
        }

        .footer-area {
            flex-shrink: 0;
            background-color: transparent;
            margin-top: auto;
        }

        .sidebar-link {
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            color: #c9d1d9;
            text-decoration: none;
            border-left: 4px solid transparent;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: #ffffff0d;
            color: white;
            border-left-color: #2d7ff3;
        }

        .sidebar-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .top-navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: 60px;
            z-index: 1001;
            background: rgb(3, 50, 120);
            border-bottom: 1px solid #30363d;
            display: flex;
            align-items: center;
            padding: 0 20px;
            justify-content: space-between;
        }

        .dropdown-trigger {
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-menu-custom {
            background: #074a9e;
            border: 1px solid #30363d;
            border-radius: 0.375rem;
            margin-top: 0.25rem;
        }

        .dropdown-menu-custom a {
            padding: 0.5rem 1rem;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: background 0.2s;
        }

        .dropdown-menu-custom a:hover {
            background: #0d6efd;
        }

        /* Responsive para tablets */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-navbar {
                padding: 0 10px;
            }
        }

        /* Responsive para móviles */
        @media (max-width: 768px) {
            .top-navbar {
                flex-wrap: wrap;
                height: auto;
                min-height: 60px;
            }

            .top-navbar img {
                height: 40px !important;
            }

            .top-navbar form {
                font-size: 0.85rem;
            }

            .top-navbar .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.85rem;
            }

            .sidebar {
                width: 100%;
            }

            .content-area {
                padding: 0.5rem !important;
            }

            .card-body {
                padding: 1rem !important;
            }

            h1 {
                font-size: 1.5rem !important;
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            .btn-group-sm .btn {
                padding: 0.25rem 0.4rem;
                font-size: 0.75rem;
            }
        }

        /* Botón hamburguesa */
        .hamburger-menu {
            display: none;
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        @media (max-width: 992px) {
            .hamburger-menu {
                display: block;
            }
        }

        /* Overlay para cerrar sidebar en móvil */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>

    @livewireStyles
</head>

<body class="bg-dark text-white h-100">

    <!-- Overlay para cerrar sidebar en móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Top Navbar -->
    <div class="top-navbar">
        <!-- Botón hamburguesa -->
        <button class="hamburger-menu" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>

        <!-- Logo -->
        <div>
            <img src="{{ asset('img/logoCashDigital.jpg') }}" alt="Logo Cash Digital" style="height: 60px;">
        </div>

        <!-- Profile y cerrar sesión -->
        <form method="POST" action="{{ route('logout') }}" class="m-0 d-flex align-items-center gap-2 gap-md-3">
            @csrf
            <i class="bi bi-person-gear d-none d-md-inline"></i>
            <a href="{{ route('profile.edit') }}" class="text-white text-decoration-none d-none d-md-inline">
                {{ Auth::user()->name }}
            </a>
            <button type="submit" class="btn btn-sm btn-outline-danger text-white">
                <i class="bi bi-box-arrow-right me-1"></i>
                <span class="d-none d-md-inline">Cerrar sesión</span>
            </button>
        </form>
    </div>

    <!-- Sidebar -->
    <nav id="sidebarMenu" class="sidebar d-lg-block bg-dark text-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="{{ route('dashboard') }}">
                    <p class="text-center"
                        style="margin-top: 1rem; font-size: 1.5rem; font-weight: bold; color: #FFEB3B">
                        Menu Principal
                    </p>
                </a>
                <x-dropdown align="right" width="80">
                    <x-slot name="trigger">
                        <button type="button" class="sidebar-link dropdown-trigger">
                            <i class="bi bi-list-ul"></i>
                            <span class="flex-grow-1">Operaciones</span>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="dropdown-menu-custom">
                            <a href="{{ route('operaciones.index') }}">
                                <i class="bi bi-cash-coin"></i> Gestión de Operaciones
                            </a>
                            <a href="{{ route('operaciones.create') }}">
                                <i class="bi bi-plus-circle"></i> Nueva Operación
                            </a>
                        </div>
                    </x-slot>
                </x-dropdown>

                <!-- Menu Clientes -->
                <a href="{{ route('clientes.index') }}"
                    class="sidebar-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Clientes
                </a>

                @role('admin')
                    <a href="{{ route('parametros.index') }}"
                        class="sidebar-link {{ request()->routeIs('parametros.*') ? 'active' : '' }}">
                        <i class="bi bi-sliders"></i> Parámetros
                    </a>

                    <!-- Menu Expandible Roles y Usuarios -->
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button type="button" class="sidebar-link dropdown-trigger">
                                <i class="bi bi-people-fill"></i>
                                <span class="flex-grow-1">Roles y Usuarios</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="dropdown-menu-custom">
                                <a href="{{ route('roles.index') }}">
                                    <i class="bi bi-shield-lock"></i> Roles
                                </a>
                                <a href="{{ route('usuarios.index') }}">
                                    <i class="bi bi-person-badge"></i> Usuarios
                                </a>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endrole
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-area">
            {{ $slot }}
        </div>

        <!-- Footer fijo -->
        <div class="footer-area">
            <x-footer />
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarMenu');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Cerrar sidebar al hacer clic en un enlace (solo en móvil)
        if (window.innerWidth < 992) {
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.addEventListener('click', () => {
                    toggleSidebar();
                });
            });
        }
    </script>

    @livewireScripts
</body>

</html>
