<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Buat WO -->
                @if(auth()->check() && (auth()->user()->role == 'user' || auth()->user()->role == 'executor' || auth()->user()->role == 'admin'))
                <li class="nav-item">
                    <a href="{{ route('workorder.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Buat WO</p>
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Buat WO</p>
                    </a>
                </li>
                @endif

                <!-- Update WO -->
                @if(auth()->check() && (auth()->user()->role == 'executor' || auth()->user()->role == 'admin'))
                <li class="nav-item">
                    <a href="{{ route('workorder.update') }}" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Update WO</p>
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Update WO</p>
                    </a>
                </li>
                @endif

                <!-- Status WO -->
                @if(auth()->check() && (auth()->user()->role == 'user' || auth()->user()->role == 'executor' || auth()->user()->role == 'admin'))
                <li class="nav-item">
                    <a href="{{ route('workorder.status') }}" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Status WO</p>
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Status WO</p>
                    </a>
                </li>
                @endif

                @if(auth()->check()) 
                    <!-- Menu Setting hanya muncul jika user sudah login -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Setting
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Semua user yang login bisa akses Setting Profil -->
                            <li class="nav-item">
                                <a href="{{ route('setting.profil') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Setting Profil</p>
                                </a>
                            </li>

                            <!-- Hanya admin yang bisa akses Setting Akun & Setting Form -->
                            @if(auth()->user()->role == 'admin')
                            <li class="nav-item">
                                <a href="{{ route('setting.akun') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Setting Akun</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="{{ route('setting.form') }}" class="nav-link">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>Setting Form</p>
                                </a>
                            </li> -->
                            @endif
                        </ul>
                    </li>
                    @endif


                <!-- Login/Logout -->
                @if(auth()->check())
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
                @else
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-in-alt"></i>
                        <p>Login</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">
                    @if(auth()->check() && auth()->user()->role != 'admin')
                        Eitts, kamu tidak bisa!
                    @else
                        Kamu belum login!
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(auth()->check() && auth()->user()->role != 'admin')
                    Kamu hanya {{ auth()->user()->role }} bukannya admin.
                @else
                    Yuk login dulu untuk mengakses fitur ini.
                @endif
            </div>
            <div class="modal-footer">
                @if(auth()->check() && auth()->user()->role != 'admin')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endif
            </div>
        </div>
    </div>
</div>