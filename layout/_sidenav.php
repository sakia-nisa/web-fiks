<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.php">
        <img src="../assets/img/logo.jpg" alt="logo" width="100">
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.php">NL</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header mt-4">Menu Utama</li>

      <?php if ($_SESSION['role'] == 'admin') : ?>
        <li><a class="nav-link" href="../admin/dashboard_admin.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>

        <li class="menu-header">Menu Penjualan</li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-bookmark"></i> <span>Belum Selesai</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../belum_selesai/index.php">List Data</a></li>
          </ul>
        </li>
        <?php if ($_SESSION['role'] != 'admin') : ?>
          <li class="nav-item">
            <a href="../kasir/index.php" class="nav-link">
              <i class="fas fa-cash-register"></i> <span>Kasir</span>
            </a>
          </li>
          <?php endif; ?>

        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-credit-card"></i> <span>Penjualan</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../penjualan/index.php">List</a></li>
          </ul>
        </li>

        <li class="menu-header">Akuntansi</li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-money-bill"></i> <span>Pengeluaran</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../pengeluaran/index.php">List Pengeluaran</a></li>
          </ul>
        </li>

      <?php else : ?>
        <li><a class="nav-link" href="../index.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>

        <li class="menu-header">Menu Penjualan</li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-bookmark"></i> <span>Belum Selesai</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../belum_selesai/index.php">List Data</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-calculator"></i> <span>Kasir</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../kasir/index.php">Input Data</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-credit-card"></i> <span>Penjualan</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../penjualan/index.php">List</a></li>
          </ul>
        </li>
      <?php endif; ?>
    </ul>
  </aside>
</div>
