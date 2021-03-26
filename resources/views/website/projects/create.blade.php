@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">projects</div>

                <div class="card-body">
                    @include('layouts.partials.status')

                    <form action="{{route('projects.store')}}" method="POST">@csrf

                        <div class="from-group">
                            <label class="control-label" for="name">Name</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                            @error('name')
                            <span class="status-error">{{ $errors->first('name') }}</span>
                            @enderror
                        </div>

                        <div class="from-group">
                            <label class="control-label" for="start_at">Start At</label>
                            <input class="form-control" type="datetime-local" name="start_at" id="start_at" value="{{old('start_at')}}">
                            @error('start_at')
                            <span class="status-error">{{ $errors->first('start_at') }}</span>
                            @enderror
                        </div>

                        <div class="from-group">
                            <label class="control-label" for="end_at">End At</label>
                            <input class="form-control" type="datetime-local" name="end_at" id="end_at" value="{{old('end_at')}}">
                            @error('end_at')
                            <span class="status-error">{{ $errors->first('end_at') }}</span>
                            @enderror
                        </div>

                        <hr>
                        <div class="form-group">
                            <label class="control-label" for="end_at">Tasks</label>

                            <button type="button" onclick="add()">Add</button>
                            <button type="button" onclick="remove()">remove</button>
                            <input type='text' placeholder='الاسم' class='form-control' name='tasks[]'>
                            <div id="new_chq"></div>
                            <input type="hidden" value="1" id="total_chq">
                        </div>


                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    function add() {
        var new_chq_no = parseInt($('#total_chq').val()) + 1;
        var new_input = "<br><input type='text' placeholder='الاسم' class='form-control' name='tasks[]' id='new_w_" + new_chq_no + "'>";
        $('#new_chq').append(new_input);
        $('#total_chq').val(new_chq_no)
    }

    function remove() {
        var last_chq_no = $('#total_chq').val();
        if (last_chq_no > 1) {
            $('#new_w_' + last_chq_no).remove();
            $('#new_l_' + last_chq_no).remove();
            $('#total_chq').val(last_chq_no - 1);
        }
    }

</script>
@endsection
