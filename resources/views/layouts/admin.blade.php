<!doctype html>
<html lang="en">
<!--begin::Head-->

@include('backend.dashboard.components.head')
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        @include('backend.dashboard.components.navbar')
        <!--end::Header-->
        <!--begin::Sidebar-->
        @include('backend.dashboard.components.sidebar')
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
          
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    @include($template)
                    <!--end::Row-->

                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        @include('backend.dashboard.components.footer')
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    @include('backend.dashboard.components.script')
    <!--end::Script-->
</body>
<!--end::Body-->

</html>