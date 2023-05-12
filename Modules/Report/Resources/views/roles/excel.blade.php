<table>
   @include('report::excel-header', [
      'columns' => 3,
   ])

   <tr>
      <td><strong>SL</strong></td>
      <td><strong>Name</strong></td>
      <td><strong>Guard</strong></td>
   </tr>
   
   @if(isset($roles[0]))
   @foreach($roles as $key => $role)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $role->name }}</td>
        <td>{{ $role->guard_name }}</td>
      </tr>
   @endforeach
   @endif

   @include('report::excel-footer', [
      'columns' => 3,
   ])
</table>