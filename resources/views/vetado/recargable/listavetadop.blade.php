
                @foreach($personal as $trabajador)
                    <tr>
                        <td>{{$trabajador->Cedula_Personal}}</td> 
                        <td>{{$trabajador->Nombre}}</td>    
                        <td>{{$trabajador->Apellido}}</td>
                        <td>
                            <button data-toggle="modal" data-target="#Edit" class="btn btn-danger delete" value="{{$trabajador->Cedula_Personal}}">Vetar</button>
                        </td>
                    </tr>
                @endforeach