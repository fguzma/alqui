@foreach($vetados as $vetado)
    <tr>
        <td class="text-center">{{$vetado->Cedula_Cliente}}</td> 
        <td>{{$vetado->Nombre}}</td>    
        <td>{{$vetado->Apellido}}</td>  
        <td>{{$vetado->descripcion}}</td>  
        <td>
            <button data-toggle="modal" data-target="#Edit" class="btn btn-primary edit" value="{{$vetado->Cedula_Cliente}}" >Editar</button>
            
            <button class="btn btn-danger delete" value="{{$vetado->Cedula_Cliente}}" >Eliminar</button>
        </td>
    </tr>
@endforeach