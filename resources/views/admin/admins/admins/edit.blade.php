@extends('admin.layouts.master')

@section('title')
المشرفين
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

<h1 class="page-title">عرض المشرفين
    <small>تعديل مشرف</small>
</h1>
@endsection

@section('content')

@if(session()->has('msg'))
<p class="alert alert-success" style="width: 100%">
    {{ session()->get('msg') }}
</p>
@endif

<form class="form-horizontal" method="post" action="{{ url('/admin/admins/'. $data->id) }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PATCH">

    <div class="row">
        <div class="col-lg-8">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"> البيانات الرئيسية</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="btn-group"></div>



                    <div class="form-group">
                        <label for="username" class="col-lg-3 control-label">الاسم</label>
                        <div class="col-lg-9">
                            <input id="username" name="name" type="text" value="{{ $data->name }}" class="form-control" placeholder="الاسم">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-lg-3 control-label">الايميل</label>
                        <div class="col-lg-9">
                            <input id="email" name="email" type="email" value="{{ $data->email }}" class="form-control" placeholder="الايميل">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>


                    <div style="clear: both"></div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-lg-2 col-lg-offset-10">
                                {{--<button type="submit" class="btn green btn-block">حفظ</button>--}}
                                <input class="btn green btn-block" type="submit" value="حفظ" onclick="this.disabled=true;this.value='تم الارسال, انتظر...';this.form.submit();" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection
