<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item start active open">
                <a href="/admin/home" class="nav-link nav-toggle">
                    <i class="icon-home" style="color: aqua;"></i>
                    <span class="title">الرئيسية</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="heading">
                <h3 class="uppercase">القائمة الجانبية</h3>
            </li>


            <li class="nav-item {{ strpos(URL::current(), 'admins') !== false ? 'active' : '' }}">
                <a href="{{ url('/admin/admins') }}" class="nav-link ">
                    <i class="fa fa-user" style="color: aqua;"></i>
                    <span class="title">المشرفين</span>
                    <span class="pull-right-container"></span>
                    <span class="badge badge-success">{!! \App\Models\Admin::count() !!}</span>
                </a>
            </li>

            <li class="nav-item {{ strpos(URL::current(), 'users') !== false ? 'active' : '' }}">
                <a href="{{route('users.index')}}" class="nav-link nav-toggle">
                    <i class="icon-users" style="color: aqua;"></i>
                    <span class="title">المستخدمين</span>
                    <span class="badge badge-success">{!! \App\Models\User::count() !!}</span>
                </a>
            </li>

            <li class="nav-item {{ strpos(URL::current(), 'projects') !== false ? 'active' : '' }}">
                <a href="{{url('admin/projects')}}" class="nav-link nav-toggle">
                    <i class="fa fa-sticky-note" style="color: aqua;"></i>
                    <span class="title">المشاريع</span>
                    <span class="badge badge-success">{!! \App\Models\Project::count() !!}</span>
                </a>
            </li>



        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
