                @foreach($inventario as $item)
                    <tr>
                        <td>{{$item->servicio}}</td> 
                        <td >{{$item->Nombre}}</td>    
                        <td>{{$item->Cantidad}}</td>  
                        <td>{{$item->Estado}}</td>  
                        <td>{{$item->Costo_Alquiler}}</td>  
                        <td>{{$item->Costo_Objeto}}</td>  
                        <td>{{$item->Disponibilidad}}</td>
                        <td class="botones">
                            <button data-toggle="modal" data-target="#Edit" class="btn btn-primary edit" value="{{$item->ID_Objeto}}">Editar</button>
                            <button class="btn btn-danger delete" value="{{$item->ID_Objeto}}">Eliminar</button>
                        </td>
                    </tr>
                @endforeach

