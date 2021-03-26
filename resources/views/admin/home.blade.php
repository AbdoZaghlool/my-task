@extends('admin.layouts.master')

@section('title')
لوحة التحكم
@endsection

@section('styles')

@endsection

@section('content')

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin/home"> لوحة التحكم</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>الإحصائيات</span>
        </li>
    </ul>
</div>

<h1 class="page-title"> الإحصائيات
    <small>عرض الإحصائيات</small>
</h1>

<div class="row">

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light red" href="{{route('admins.index')}}">
            <div class="visual">
                <i class="fa fa-user-circle-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{\App\Models\Admin::count()}}</span>
                </div>
                <div class="desc"> المشرفين </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light green" href="{{route('users.index')}}">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{\App\Models\User::count()}}</span>
                </div>
                <div class="desc"> المستخدمبن </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light yellow" href="{{route('admin.projects.index')}}">
            <div class="visual">
                <i class="fa fa-sticky-note"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{\App\Models\Project::count()}}</span>
                </div>
                <div class="desc"> المشاريع </div>
            </div>
        </a>
    </div>




</div>

@endsection

@section('scripts')


@endsection
