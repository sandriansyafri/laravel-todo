  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button onclick="return confirm('LOGOUT ?')" type="submit" class="btn" role="button" class="nav-link">Logout</button>
            </form>
          </li>
      </ul>
  </nav>
  <!-- /.navbar -->