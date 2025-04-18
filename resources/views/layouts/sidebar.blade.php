<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

      <!-- Dashboard -->
      <li class="nav-item">
        <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard</p>
        </a>
      </li>

      <!-- Data Pengguna -->
      <li class="nav-header">Data </li>
      <li class="nav-item">
        <a href="{{ url('/jenis') }}" class="nav-link {{ ($activeMenu == 'jenis') ? 'active' : '' }}">
          <i class="nav-icon fas fa-layer-group"></i>
          <p>Jenis Kendaraan</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/mobil') }}" class="nav-link {{ ($activeMenu == 'mobil') ? 'active' : '' }}">
          <i class="nav-icon far fa-list-alt"></i>
          <p>Data Kendaraan</p>
        </a>
      </li>

    </ul>
  </nav>
</div>