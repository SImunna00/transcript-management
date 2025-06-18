<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title','Home')</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />




  


    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
   @include('partials.style')
   <!--css-->

   @stack('style')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary ">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
         
     <!--begin::Header-->
  @include('partials.admin-header')
      <!--end::Header-->

      <!--begin::Sidebar-->
      @include('partials.admin-sidebar')
      <!--end::Sidebar-->


      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
       
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">

        @yield('content')

        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->



      <!--begin::Footer-->
    @include('partials.footer-2')
      <!--end::Footer-->

    </div>
    <!--end::App Wrapper-->
  
<!-- script-->
 @include('partials.script')

 @stack('script')

  </body>
  <!--end::Body-->
</html>
