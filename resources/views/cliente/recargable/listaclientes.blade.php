
  @foreach($clientes as $cliente)
    <tr >
      <td >{{$cliente->Cedula_Cliente}}</td> 
      <td >{{$cliente->Nombre}}</td>    
      <td>{{$cliente->Apellido}}</td>  
      <td>{{$cliente->Edad}}</td>  
      <td>{{$cliente->Sexo}}</td>  
      <td>{{$cliente->Direccion}}</td>  
      <td class="botones">
        <input type="button" data-toggle="modal" data-target="#Edit" class="btn btn-primary edit" value="Editar">
        
        <input  type="button" class="btn btn-danger delete" onclick="erase('{{$cliente->Cedula_Cliente}}');" value="Eliminar" >
      </td>
    </tr>
  @endforeach