<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ auth()->user()?->isAdmin() ? route('admin.dashboard') : (auth()->user()?->isIrban() ? route('irban.dashboard') : route('opd.dashboard')) }}">
            @if (file_exists(public_path('assets/img/logo-ekonsul-ikon.png')))
                <img src="{{ asset('assets/img/logo-ekonsul-ikon.png') }}" alt="E-KONSUL" class="logo-navbar-ikon">
            @else
                <i class="bi bi-shield-check"></i>
            @endif
            E-KONSUL
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMobile">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="d-flex align-items-center ms-auto gap-2">

            <span class="text-white-50 small d-none d-md-inline me-2">
                {{ auth()->user()?->name }} &middot; {{ auth()->user()?->role->label() }}
            </span>

            {{-- Lonceng notifikasi --}}
            @include('layouts.partials.lonceng')

            {{-- Menu akun --}}
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('beranda') }}">
                            <i class="bi bi-house"></i> Beranda Situs
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
