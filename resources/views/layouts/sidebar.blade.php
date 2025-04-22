<div class="sidebar d-flex flex-column" style="height: 100vh;">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ asset((auth()->user()->photo_profile == null) ? 'storage/unknown-profile-pict.jpg' : 'storage/img/' .auth()->user()->photo_profile) }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="{{ route('user.profile.show') }}" class="d-block">{{ auth()->user()->nama }}</a>
    </div>
  </div>

  <!-- SidebarSearch Form -->
  <div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
      <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-sidebar">
          <i class="fas fa-search fa-fw"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2 flex-grow-1">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item menu-open">
        <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      </li>
      <li class="nav-header">Data Pengguna</li>
      <li class="nav-item">
        <a href="{{ route('level.index') }}" class="nav-link {{ $activeMenu == 'level' ? 'active' : '' }}">
          <i class="nav-icon fas fa-layer-group"></i>
          <p>Level User</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('user.index') }}" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">
          <i class="nav-icon far fa-user"></i>
          <p>Data User</p>
        </a>
      </li>
      <li class="nav-header">Data Barang</li>
      <li class="nav-item">
        <a href="{{ route('kategori.index') }}" class="nav-link {{ $activeMenu == 'kategori' ? 'active' : '' }}">
          <i class="nav-icon far fa-bookmark"></i>
          <p>Kategori Barang</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('barang.index') }}" class="nav-link {{ $activeMenu == 'barang' ? 'active' : '' }}">
          <i class="nav-icon fas fa-cubes"></i>
          <p>Data Barang</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('supplier.index') }}" class="nav-link {{ $activeMenu == 'supplier' ? 'active' : '' }}">
          <i class="nav-icon fas fa-truck"></i>
          <p>Data Supplier</p>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Logout menu -->
  <div class="mt-auto p-3">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-danger btn-block">
        <i class="fas fa-sign-out-alt"></i> Logout
      </button>
    </form>
  </div>
</div>
