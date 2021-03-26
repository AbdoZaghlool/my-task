@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">projects</div>

                <div class="card-body margin-auto">
                    @include('layouts.partials.status')


                    <div class="col-lg-6 col-xs-12 text-center">
                        <div class="box">
                            <div class="box-title">
                                <h3>project name : {{$project->name}}</h3>
                            </div>
                            <div class="box-text">
                                <span>
                                    <span>Project Starts At: </span>{{$project->start_at->format('Y-m-d H:i')}} <br>
                                    <span>Project Ends At: </span>{{$project->end_at->format('Y-m-d H:i')}}
                                </span>
                            </div>
                            <h5>project tasks</h5>
                            @forelse ($project->tasks as $task)
                            <li>{{$task->name}} - <span style="color: orangered;">{{$task->status}}</span></li>
                            @empty

                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
