@if(session()->has('success'))
<script type="text/javascript">
  $(document).ready(function() {
    notify('{{session()->get('success')}}','success');
    playTone('success');
  });
</script>
@endif

@if(session()->has('danger'))
<script type="text/javascript">
  $(document).ready(function() {
    notify('{{session()->get('danger')}}','danger');
    playTone('danger');
  });
</script>
@endif

@if($errors->any())
<script type="text/javascript">
  $(document).ready(function() {
    playTone('danger');
    var errors=<?php echo json_encode($errors->all()); ?>;
    $.each(errors, function(index, val) {
      notify(val,'danger');
    });
  });
</script>
@endif

<script type="text/javascript">
    var base_url = "{{ url('/') }}";

    $(document).ready(function() {
      var links = "{{ this_url() }}";
      links = links.split('/');
      $.each($('.modules'), function(index, val) {
        if($(this).attr('data-route') == links[0]){
          $(this).addClass('menu-open');
        }
      });

      $.each($('.menus'), function(index, val) {
        if($(this).attr('data-route') == links[1]){
          $(this).addClass('bg-white text-bold');
        }
      });

      $.each($('.submenus'), function(index, val) {
        if($(this).attr('data-route') == links[1]){
          $(this).addClass('bg-white text-bold');
          $(this).parent().parent().addClass('menu-open');
        }
      });

      $('.datatable').DataTable({
        lengthMenu: [
            [ 5,10, 25, 50, 100, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]
        ],
        iDisplayLength: 100,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
          'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

      $('.buttons-copy').removeClass('btn-secondary').addClass('btn-warning').html('<i class="fas fa-copy"></i>');
      $('.buttons-csv').removeClass('btn-secondary').addClass('btn-success').html('<i class="fas fa-file-csv"></i>');
      $('.buttons-excel').removeClass('btn-secondary').addClass('btn-primary').html('<i class="far fa-file-excel"></i>');
      $('.buttons-pdf').removeClass('btn-secondary').addClass('btn-info').html('<i class="fas fa-file-pdf"></i>');
      $('.buttons-print').removeClass('btn-secondary').addClass('btn-dark').html('<i class="fas fa-print"></i>');

      $('.summernote').summernote();

      $(".select2").each(function() {
        $(this).select2({
          dropdownParent: $(this).parent()
        });
      });

      $(".select2bs4").each(function() {
        $(this).select2({
          theme: "bootstrap4",
          dropdownParent: $(this).parent()
        });
      });

      $(".select2bs4-tags").each(function() {
        $(this).select2({
          tags: true,
          theme: "bootstrap4",
          dropdownParent: $(this).parent()
        });
      });

      $('.datetimepicker').datetimepicker();
      
      $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD',
      });

      $('.timepicker').datetimepicker({
        format: 'LT'
      });

      $('.checkbox-parent').change(function() {
        if($(this).is(':checked')){
          $('.checkbox-child').prop('checked',true);
        }else{
          $('.checkbox-child').prop('checked',false);
        }
      });

    });

    function Show(title,link,style = '') {
        $('#modal').modal();
        $('#modal-title').html(title);
        $('#modal-body').html('<h1 class="text-center"><strong>Please wait...</strong></h1>');
        $('#modal-dialog').attr('style',style);
        $.ajax({
            url: link,
            type: 'GET',
            data: {},
        })
        .done(function(response) {
            $('#modal-body').html(response);
        });
    }

    function Popup(title,link) {
      $.dialog({
          title: title,
          content: 'url:'+link,
          animation: 'scale',
          columnClass: 'large',
          closeAnimation: 'scale',
          backgroundDismiss: true,
      });
    }
    
    function Delete(id,link) {
        $.confirm({
            title: 'Confirm!',
            content: '<hr><div class="alert alert-danger">Are you sure to delete ?</div><hr>',
            buttons: {
                yes: {
                    text: 'Yes',
                    btnClass: 'btn-danger',
                    action: function(){
                        $.ajax({
                            url: link+"/"+id,
                            type: 'DELETE',
                            data: {_token:"{{ csrf_token() }}"},
                        })
                        .done(function(response) {
                            if(response.success){
                              if($('.datatable-serverside').attr('class')){
                                reloadDatatable();
                              }else{
                                $('#crud-delete-button-'+id).parent().parent().parent().fadeOut();
                              }

                              notify(response.message != undefined ? response.message : 'Data has been deleted', 'success');
                              playTone('success');
                            }else{
                              notify('Something went wrong!','danger');
                              playTone('danger');
                            }
                        })
                        .fail(function(response){
                          notify('Something went wrong!','danger');
                          playTone('danger');
                        });
                    }
                },
                no: {
                    text: 'No',
                    btnClass: 'btn-default',
                    action: function(){
                        
                    }
                }
            }
        });
    }

    function notify(message,type) {
      $.wnoty({
          message: '<strong class="text-'+(type)+'">'+(message)+'</strong>',
          type: type,
          autohideDelay: 3000
      });
    }

    function playTone(which) {
      var obj = document.createElement("audio");
      obj.src = "{{ asset('lte/tones') }}/"+(which)+".mp3"; 
      obj.play(); 
    }

    function openLink(link,type='_parent'){
      window.open(link,type);
    }
</script>
@include('yajra.js')