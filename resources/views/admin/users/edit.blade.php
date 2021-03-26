@extends('admin.layouts.master')

@section('title')
تعديل عميل
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">

@endsection

@section('page_header')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin/home">لوحة التحكم</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="/admin/users">العملاء</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>تعديل عميل</span>
        </li>
    </ul>
</div>

<h1 class="page-title"> العملاء
    <small>تعديل عميل</small>
</h1>
@endsection


<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
@section('content')

<div class="row">
    <div class="col-md-12">

        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">حساب الملف الشخصي</span>
                            </div>
                        </div>
                        <form role="form" action="{{route('users.update',$user->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">

                                        {{-- <!-- name -->  --}}
                                        <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                            <label class="control-label">الاسم</label>
                                            <input type="text" name="name" placeholder="الاسم" class="form-control" value="{{$user->name}}" />
                                            @error('name')
                                            <span class="status-error">{{ $errors->first('name') }}</span>
                                            @enderror
                                        </div>

                                        {{-- <!-- phone -->  --}}
                                        <div class="form-group {{$errors->has('phone_number')?'has-error':''}}">
                                            <label class="control-label">رقم الهاتف</label>
                                            <input type="text" name="phone_number" placeholder="رقم الهاتف" class="form-control" value="{{$user->phone_number}}" />
                                            @error('phone_number')
                                            <span class="status-error">{{ $errors->first('phone_number') }}</span>
                                            @enderror
                                        </div>

                                        {{-- <!-- email -->  --}}
                                        <div class="form-group {{$errors->has('email')?'has-error':''}}">
                                            <label class="control-label">البريد الالكتروني</label>
                                            <input type="email" name="email" placeholder="البريد الالكتروني" class="form-control" value="{{$user->email}}" />
                                            @error('email')
                                            <span class="status-error">{{ $errors->first('email') }}</span>
                                            @enderror
                                        </div>


                                        {{-- <!-- password -->  --}}
                                        <div class="form-group {{$errors->has('password')?'has-error':''}}">
                                            <label class="control-label">كلمة المرور</label>
                                            <input type="password" name="password" class="form-control" />
                                            @error('password')
                                            <span class="status-error">{{ $errors->first('password') }}</span>
                                            @enderror
                                        </div>

                                        {{-- <!-- pass_confirm -->  --}}
                                        <div class="form-group {{$errors->has('password_confirmation')?'has-error':''}}">
                                            <label class="control-label">إعادة كلمة المرور</label>
                                            <input type="password" name="password_confirmation" class="form-control" />
                                            @error('password_confirmation')
                                            <span class="status-error">{{ $errors->first('password_confirmation') }}</span>
                                            @enderror
                                        </div>

                                        {{-- <!-- image -->  --}}
                                        <div class="form-body">
                                            <div class="form-group {{$errors->has('image')?'has-error':''}} ">
                                                <label class="control-label col-md-3">الصورة الشخصية</label>
                                                <div class="col-md-9">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                            <img src="{{asset($user->image)}}" alt="">
                                                        </div>
                                                        <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new"> اختر الصورة </span>
                                                                <span class="fileinput-exists"> تغيير </span>
                                                                <input type="file" name="image"> </span>
                                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> إزالة </a>
                                                        </div>
                                                    </div>
                                                    @error('image')
                                                    <span class="status-error">{{ $errors->first('image') }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <div class="form-actions">
                                    <button type="submit" class="btn green" value="حفظ" onclick="this.disabled=true;this.value='تم الارسال, انتظر...';this.form.submit();">حفظ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>

@endsection
