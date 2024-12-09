<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('admin.home') }}" class="nav-link">Home</a>
    </li>
  </ul>


  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('admin.logout') }}" class="nav-link">
        <i class="fas fa-power-off text-danger"></i>
        Logout
      </a>
    </li>
  </ul>
</nav>
