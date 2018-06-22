            @foreach($cargos as $cargo)
                <tr>
                    <td class="text-center">{{$cargo->Nombre_Cargo}}</td> 
                    <td class="text-center botones">
                        <button data-toggle="modal" data-target="#Edit" class="btn btn-primary edit" value="{{$cargo->ID_Cargo}}">Editar</button>
                        
                        <button class="btn btn-danger delete" value="{{$cargo->ID_Cargo}}" >Eliminar</button>
                    </td>
                </tr>
            @endforeach