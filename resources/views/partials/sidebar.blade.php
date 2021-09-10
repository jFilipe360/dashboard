<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.home') }}" class="brand-link">
        <img src="/img/logo/mripta-128.png" alt="MRIPTA" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">MRIPTA</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard.home') }}" class="nav-link {{ (Request::is('/') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ (Request::is('pontos*') || Request::is('raw*') || Request::is('charts*') || Request::is('table*') ? 'menu-open' : '') }}">
                    <a href="#" class="nav-link {{ (Request::is('pontos*') || Request::is('raw*') || Request::is('charts*') || Request::is('table*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-broadcast-tower"></i>
                        <p>Pontos de Recolha
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">{{count(Auth::user()->teams)}}</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('pontos.create') }}" class="nav-link {{ (Request::is('pontos/create') ? 'active' : '') }}">
                                <i class="fas fa-plus-square nav-icon"></i>
                                <p>Criar Ponto</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pontos.index') }}" class="nav-link {{ (Request::is('pontos') ? 'active' : '') }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Listar Pontos</p>
                            </a>
                        </li>
                        @foreach(Auth::user()->teams as $team)
                        <li class="nav-item">
                            <a href="{{ route('pontos.info', ['pontoid' => $team->id]) }}" class="nav-link {{ (Request::is('pontos/'.$team->id) || Request::is('raw/'.$team->id) || Request::is('table/'.$team->id) || Request::is('charts/'.$team->id.'*') ? 'active' : '') }}">
                                <i class="fas fa-satellite-dish nav-icon @if($team->connected) text-success @endif"></i>
                                <p>{{$team->name}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>

                @if (Auth::user()->isAdmin())
                <li class="nav-header">Administração</li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ (Request::is('invite') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>Convidar Utilizador</p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ (Request::is('admin/user*') ? 'menu-open' : '') }}">
                    <a href="#" class="nav-link {{ (Request::is('admin/user*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Utilizadores <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}"
                               class="nav-link {{ (Request::is('admin/user') ? 'active' : '') }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Listar Utilizadores</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.create') }}"
                               class="nav-link {{ (Request::is('admin/user/create') ? 'active' : '') }}">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Adicionar Utilizador</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ (Request::is('admin/team*') ? 'menu-open' : '') }}">
                    <a href="#" class="nav-link {{ (Request::is('admin/team*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>Equipas <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('team.index') }}"
                               class="nav-link {{ (Request::is('admin/team') ? 'active' : '') }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Listar Equipas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('team.create') }}"
                               class="nav-link {{ (Request::is('admin/cargos/create') ? 'active' : '') }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Adicionar Equipa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
