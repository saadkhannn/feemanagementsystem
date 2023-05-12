@extends('layouts.index')

@section('content')
<script src="{{ asset('lte') }}/plugins/jquery/jquery.min.js"></script>
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Send Notification</strong>
        </h4>
    </div>
    <div class="card-body">
        @include('yajra.datatable')
    </div>
</div>

<script type="text/javascript">
    function sendNotification(user_bill_id, element) {
        $.confirm({
            title: 'Confirm!',
            content: '<h5>Are you sure to send notification?</h5>',
            buttons: {
                yes: {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    action: function(){
                        element.html('<i class="fa fa-spinner fa-spin"></i>&nbsp;Processing').prop('disabled', true);

                        $.ajax({
                            url: "{{ route('notifications.store') }}",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                _token: "{{ csrf_token() }}",
                                user_bill_id: user_bill_id
                            },
                        })
                        .done(function(response) {
                            if(response.success){
                                notify(response.message, 'success');
                            }else{
                                notify(response.message, 'danger');
                            }
                            
                            element.html('Send Notification').prop('disabled', true);
                        })
                        .fail(function() {
                            var errors = '<ul class="pl-3">';
                            $.each(response.responseJSON.errors, function(index, val) {
                                errors += '<li>'+val[0]+'</li>';
                            });
                            errors += '</ul>';
                            notify(errors, 'danger');

                            element.html('Send Notification').prop('disabled', true);
                        });
                    }
                },
                no: {
                    text: 'No',
                    btnClass: 'btn-red',
                    action: function(){
                        //
                    }
                }
            }
        });
    }
</script>
@endsection