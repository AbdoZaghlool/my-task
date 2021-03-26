@extends('admin.layouts.master')

@section('title')
المشرفين
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.bootstrap-rtl.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
@toastr_css()
@endsection

@section('page_header')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('admin/home') }}">لوحة التحكم</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('admins.index') }}">المشرفين</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>عرض المشرفين</span>
        </li>
    </ul>
</div>

<h1 class="page-title"> المشرفين
</h1>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="btn-group">
                                <a class="btn sbold green" href="{{ url('/admin/admins/create') }}"> إضافة جديد
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> الإسم </th>
                            <th> الإيميل </th>
                            <th> تاريخ الإضافة </th>
                            <th> العمليات </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $array = []; ?>
                        @foreach( $data as $value )
                        <tr class="odd gradeX">

                            <td class="no_dec">{{ $value->name }}</td>
                            <td><a href="mailto:{{ $value->email }}"> {{ $value->email }} </a></td>
                            <td> {{ $value->created_at->format('Y-m-d g:i A') }} </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> العمليات
                                        <i class="fa fa-angle-down"></i>
                                    </button>

                                    <ul class="dropdown-menu pull-left" role="menu">
                                        <li>
                                            <a href="{{ url('/admin/admins/' . $value->id . '/edit') }}">
                                                <i class="icon-pencil"></i> تعديل
                                            </a>
                                        </li>
                                        @if( auth()->guard('admin')->user()->id != $value->id )
                                        <li>
                                            <a class="delete_data" data="{{ $value->id }}" data_name="{{ $value->name }}">
                                                <i class="fa fa-times"></i> حذف
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>

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
<script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('body').on('click', '.delete_data', function() {
            var id = $(this).attr('data');
            var swal_text = 'حذف ' + $(this).attr('data_name');
            var swal_title = 'هل أنت متأكد من الحذف ؟';

            swal({
                title: swal_title
                , text: swal_text
                , type: "warning"
                , showCancelButton: true
                , confirmButtonClass: "btn-warning"
                , confirmButtonText: "تأكيد"
                , cancelButtonText: "إغلاق"
            }, function() {

                window.location.href = "{{ url('/') }}" + "/admin/admin_delete/" + id;

            });

        });
    });

</script>
@endsection
