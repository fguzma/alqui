@foreach($vetados as $vetado)
    <tr>
        <td class="text-center">{{$vetado->Cedula_Personal}}</td> 
        <td>{{$vetado->Nombre}}</td>    
        <td>{{$vetado->Apellido}}</td>  
        <td>{{$vetado->descripcion}}</td>  
        <td>
            <button data-toggle="modal" data-target="#Edit" class="btn btn-primary edit" value="{{$vetado->Cedula_Personal}}" >Editar</button>
            
            <button class="btn btn-danger delete" value="{{$vetado->Cedula_Personal}}" >Eliminar</button>
        </td>
    </tr>
@endforeach