<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>@yield('title', 'Home')</title>
  <!--begin::Primary Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="AdminLTE v4 | Dashboard" />
  <meta name="author" content="ColorlibHQ" />
  <meta name="description"
    content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
  <meta name="keywords"
    content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />







  <!--end::Primary Meta Tags-->
  <!--begin::Fonts-->
  @include('partials.style')
  <!--css-->

  <!-- Alpine.js -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <!-- Custom UI styles -->
  <style>
    .fade-enter-active,
    .fade-leave-active {
      transition: opacity 0.3s;
    }

    .fade-enter,
    .fade-leave-to {
      opacity: 0;
    }

    /* Loading spinner overlay */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }

    /* Form feedback styles */
    .form-feedback {
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      transition: all 0.3s ease;
    }
  </style>

  @stack('style')
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary  ">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">

    <!--begin::Header-->
    @include('partials.home-header')
    <!--end::Header-->

    <!--begin::Sidebar-->

    <!--end::Sidebar-->


    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content Header-->

      <!--end::App Content Header-->
      <!--begin::App Content-->
      <div class="app-content">
        <!-- Flash Messages -->
        @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

        @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

        @if(session('info'))
      <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

        @yield('content')
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->



    <!--begin::Footer-->
    @include('partials.footer')
    <!--end::Footer-->

  </div>
  <!--end::App Wrapper-->

  <!-- script-->
  @include('partials.script')

  @stack('script')

</body>
<!--end::Body-->

</html>