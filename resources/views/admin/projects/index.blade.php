@extends('admin.layouts.master')

@section('title')
المشاريع
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.bootstrap-rtl.css') }}">
@toastr_css()
@endsection

@section('page_header')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin/home">لوحة التحكم</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="/admin/projects">المشاريع</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>عرض المشاريع</span>
        </li>
    </ul>
</div>

<h1 class="page-title">عرض المشاريع
    <small>عرض جميع المشاريع</small>
</h1>
@endsection

@section('content')


<div class="row">
    <div class="col-lg-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered table-responsive">
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> ID</th>
                            <th> الاسم</th>
                            <th> يبدا في</th>
                            <th> ينتهي عند</th>
                            <th> صاحب لمشروع</th>
                            <th> التاسكات </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0 ?>
                        @foreach($projects as $project)
                        <tr class="odd gradeX">
                            <td> {{$project->id}} </td>
                            <td> {{$project->name}} </td>
                            <td> {{$project->start_at->format('Y-m-d H:i')}} </td>
                            <td> {{$project->end_at->format('Y-m-d H:i')}} </td>
                            <td> {{$project->creator->name}} </td>
                            <td>
                                @forelse ($project->tasks as $task)
                                <li>{{$task->name}} - {{$task->status}}</li>
                                @empty
                                @endforelse
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ URL::asset('admin/js/datatable.js') }}"></script>
<script src="{{ URL::asset('admin/js/datatables.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/datatables.bootstrap.js') }}"></script>
<script src="{{ URL::asset('admin/js/table-datatables-managed.min.js') }}"></script>
@endsection
