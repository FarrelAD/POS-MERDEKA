<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block">Admin</a>
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
  <nav class="mt-2">
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
  <!-- /.sidebar-menu -->
</div>