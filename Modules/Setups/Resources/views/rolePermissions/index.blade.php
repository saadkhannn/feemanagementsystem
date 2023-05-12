@extends('layouts.index')

@section('content')
<script src="{{ asset('lte') }}/plugins/jquery/jquery.min.js"></script>
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Role Permissions</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('role-permissions.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label for="role_id"><strong>Choose Role :</strong></label>
                <select name="role_id" class="form-control select2bs4" id="role_id" onchange="window.open('{{ url('setups/role-permissions') }}?role_id='+$('#role_id').val(), '_parent')">
                  <option value="0">Choose Role</option>
                  @if(isset($roles[0]))
                  @foreach ($roles as $key => $role)
                    <option value="{{$role->id}}" {{ request()->get('role_id') == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                  @endforeach
                  @endif
                </select>
            </div>

            @if(request()->get('role_id') > 0)
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
                                    <input type="checkbox" id="chunk-{{ $c }}" class="chunk" data-key="{{ $c }}" {{ ($chunk->count() == $chunk->whereIn('id', $existingPermissions)->count()) ? 'checked' : '' }}>
                                    <label for="chunk-{{ $c }}" class="text-info">
                                      {{ $module }}
                                    </label>
                                </div>
                            </h4>
                            <hr class="mt-1 pt-0">
                            @foreach($chunk as $key => $permission)
                                <p class="mb-0">
                                    <div class="icheck-dark d-inline">
                                        <input type="checkbox" id="permission-{{ $permission->id }}" class="permission-{{ $c }}" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $existingPermissions) ? 'checked' : '' }}>
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
            <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update Role Permissions</button>
            @endif
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