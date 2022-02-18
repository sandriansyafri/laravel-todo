
    <!-- jQuery -->
    <script src="{{ asset('template/admin-lte') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('template/admin-lte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    @stack('js-auth-vendor')
    <script src="{{ asset('template/admin-lte') }}/dist/js/adminlte.min.js"></script>
    @stack('js-auth')