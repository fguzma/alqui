            
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->email}}</td> 
                        <td>{{$usuario->name}}</td>    
                        <td>{{$usuario->identificacion}}</td>  
                        <td>
                            <button data-toggle="modal" data-target="#Edit" class="btn btn-primary edit" value="{{$usuario->id}}">Editar</button>
                            <button class="btn btn-danger delete" value="{{$usuario->id}}">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
                