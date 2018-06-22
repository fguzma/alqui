            @foreach($servicios as $servicio)
                <tr>
                    <td class="text-center">{{$servicio->Nombre}}</td> 
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#Edit" class="btn btn-primary edit" value="{{$servicio->ID_Servicio}}">Editar</button>
                        <button class="btn btn-danger delete" value="{{$servicio->ID_Servicio}}" >Eliminar</button>
                    </td>
                </tr>
            @endforeach