@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">projects</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <a href="{{route('projects.create')}}" class="btn btn-info">New Project</a>
                    @forelse ($projects as $project)

                    <div class="col-lg-4 col-xs-12 text-center">
                        <div class="box">
                            <i class="fa fa-behance fa-3x" aria-hidden="true"></i>
                            <div class="box-title">
                                <h3>
                                    <a href="{{route('projects.show',$project->id)}}">{{$project->name}}</a>
                                </h3>
                            </div>
                            <div class="box-text">
                                <span>
                                    <span><strong>Project Starts At:</strong> </span>{{$project->start_at->format('Y-m-d H:i')}}
                                    <br>
                                    <span><strong>Project Ends At:</strong> </span>{{$project->end_at->format('Y-m-d H:i')}}
                                </span>
                            </div>
                            <div class="box-btn">
                                {{-- <a class="btn btn-primary" href="{{route('projects.edit',$project->id)}}">Edit</a> --}}
                                <a class="btn btn-danger delete_project" data-id="{{$project->id}}" data-name="{{$project->name}}">Delete</a>
                            </div>
                        </div>
                    </div>

                    @empty
                    no projects yet
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');
        $('body').on('click', '.delete_project', function() {
            var id = $(this).attr('data-id');
            var swal_text = 'حذف ' + $(this).attr('data_name') + '؟';
            var swal_title = 'هل أنت متأكد من الحذف ؟';
            swal({
                title: swal_title
                , text: swal_text
                , type: "warning"
                , showCancelButton: true
                , confirmButtonClass: "btn-warning"
                , confirmButtonText: "تأكيد"
                , cancelButtonText: "إغلاق"
                , closeOnConfirm: false
            }, function() {
                window.location.href = "{{ url('/') }}" + "/projects/" + id + "/delete";
            });
        });
    });

</script>
@endsection
