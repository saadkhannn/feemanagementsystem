@extends('layouts.index')

@section('content')
<script src="{{ asset('lte') }}/plugins/jquery/jquery.min.js"></script>
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
            <strong>Create User</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
        @csrf

            <div class="form-group row">
                <div class="col-md-2">
                    <label for="first_name"><strong>First Name <span class="text-danger">*</span></strong></label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="last_name"><strong>Last Name <span class="text-danger">*</span></strong></label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="username"><strong>User Name <span class="text-danger">*</span></strong></label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="email"><strong>Email <span class="text-danger">*</span></strong></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="password"><strong>Password <span class="text-danger">*</span></strong></label>
                    <input type="text" name="password" id="password" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="gender"><strong>Gender <span class="text-danger">*</span></strong></label>
                    <br>
                    @foreach(genders() as $key => $gender)
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="gender-radio-{{ $key }}" name="gender" value="{{ $key }}}" {{ ((1 == $key) ? 'checked' : '') }}>
                        <label for="gender-radio-{{ $key }}" class="text-primary">
                          {{ $gender }}&nbsp;&nbsp;
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="roles"><strong>Choose Roles <span class="text-danger">*</span></strong></label>
                <select name="roles[]" class="form-control select2bs4" id="roles" multiple>
                  @if(isset($roles[0]))
                  @foreach ($roles as $key => $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                  @endforeach
                  @endif
                </select>
            </div>

            <div class="form-group row mt-3">
                @php
                    $c = 0;
                @endphp
                @if(isset($modules[0]))
                @foreach($modules as $key => $module)
                    @foreach($permissions->where('module', $module)->chunk(10) as $key => $chunk)
                    @php
                        $c++;
                    @endphp
                        <div class="col-md-2 mb-3">
                            <h4 class="mb-0">
                                <div class="icheck-info d-inline">
                                    <input type="checkbox" id="chunk-{{ $c }}" class="chunk" data-key="{{ $c }}">
                                    <label for="chunk-{{ $c }}" class="text-info">
                                      {{ $module }}
                                    </label>
                                </div>
                            </h4>
                            <hr class="mt-1 pt-0">
                            @foreach($chunk as $key => $permission)
                                <p class="mb-0">
                                    <div class="icheck-dark d-inline">
                                        <input type="checkbox" id="permission-{{ $permission->id }}" class="permission-{{ $c }}" name="permissions[]" value="{{ $permission->id }}">
                                        <label for="permission-{{ $permission->id }}" class="text-dark">
                                          {{ $permission->name }}
                                        </label>
                                    </div>
                                </p>
                            @endforeach
                        </div>
                    @endforeach
                @endforeach
                @endif
            </div>
            <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Create User</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $.each($('.chunk'), function(index, val) {
            var ch = $(this);
            ch.click(function(event) {
                $('.permission-'+ch.attr('data-key')).prop('checked', ch.is(':checked'));
            });
        });
    });
</script>
@endsection