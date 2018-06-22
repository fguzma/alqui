                @foreach($personal as $trabajador)
                    <tr >
                        <td>{{$trabajador->Cedula_Personal}}</td> 
                        <td>{{$trabajador->Nombre}}</td>    
                        <td>{{$trabajador->Apellido}}</td>  
                        <td>{{$trabajador->Direccion}}</td>  
                        <td>{{$trabajador->Fecha_Nac}}</td>  
                        <td class="botones">
                            <input type="button" data-toggle="modal" data-target="#Edit" class="btn btn-primary edit" value="Editar">
                            
                            <input  type="button" class="btn btn-danger delete" onclick="erase('{{$trabajador->Cedula_Personal}}');" value="Eliminar" >
                        </td>
                    </tr>
                @endforeach