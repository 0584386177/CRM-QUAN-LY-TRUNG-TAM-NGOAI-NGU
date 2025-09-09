<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="" class="brand-link p-0" style="display:block">
            <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/09/Logo-Anh-Ngu-Yola-Text.png" alt="Logo"
                style="width:100%; height:auto; display:block;" />
        </a>
    </div>

    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Trang chủ
                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{route('user.index')}}" class="nav-link">
                        <i class="bi bi-person"></i>
                        <p>
                            Quản lý giáo viên
                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{route('student.index')}}" class="nav-link">
                        <i class="bi bi-people"></i>
                        <p>
                            Quản lý học viên
                        </p>
                    </a>

                </li>

                <li class="nav-item">
                    <a href="{{route('subject.index')}}" class="nav-link">
                        <i class="bi bi-journal-text"></i>
                        <p>
                            Quản lý khóa học
                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{route('classroom.index')}}" class="nav-link">
                        <i class="bi bi-layout-text-window-reverse"></i>
                        <p>
                            Quản lý lớp học
                        </p>
                    </a>

                </li>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>