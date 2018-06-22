@if(count($errores)>0)
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <ul>
  @foreach($errores as $error)
    <li>{!!$error!!}</li>
  @endforeach
  </ul>
</div>
@endif