
                @foreach($clientes as $cli)
                    <tr>
                        <td>{{$cli->Cedula_Cliente}}</td> 
                        <td>{{$cli->Nombre}}</td>    
                        <td>{{$cli->Apellido}}</td>
                        <td>
                            <button data-toggle="modal" data-target="#Add" class="btn btn-danger delete" value="{{$cli->Cedula_Cliente}}">Vetar</button>
                        </td>
                    </tr>
                @endforeach 