  @if(session('message'))
   <div class="alert alert-{!!session('tipo')!!} alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <ul>
      <li>{!!session('message')!!}</li>
     </ul>
    </div>
    @endif
  {!!$message=""!!}