<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="VM Tech Logo"
                    style="max-width: 180px; max-height: 50px; width: auto; height: auto;">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Home</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('history.*') ? 'active' : '' }}">
            <a href="{{ route('history.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div data-i18n="Analytics">Historial</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
            <a href="{{ route('payments.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dollar"></i>
                <div data-i18n="Analytics">Gastos</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('extras.*') ? 'active' : '' }}">
            <a href="{{ route('extras.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div data-i18n="Analytics">Extras</div>
            </a>
        </li>
            <!-- Layouts -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Admin</span>
        </li>
        <li class="menu-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
            <a href="{{ route('clients.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Account Settings">Clientes</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
            <a href="{{ route('expenses.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wallet"></i>
                <div data-i18n="Authentications">Gastos</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Users">Usuarios</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <a href="{{ route('settings.templates.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div data-i18n="Misc">Recordatorios</div>
            </a>
        </li>
</aside>
