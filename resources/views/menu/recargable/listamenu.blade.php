                @foreach($menu as $comida)
                    <tr style="height:5em;">
                        <td><img src="https://s3.us-east-2.amazonaws.com/pruebakavv/Menu/{{$comida->path}}"  style="height:10em;border-radius: 40px;" value="{{$comida->path}}"></td> 
                        <td>{{$comida->descripcion}}</td>    
                        <td>{{$comida->costo}}</td> 
                        <td class="botones">
                            <button data-toggle="modal" data-target="#Edit" class="btn btn-primary edit" value="{{$comida->id}}">Editar</button>
                            <button class="btn btn-danger delete" value="{{$comida->id}}">Eliminar</button>
                        </td>
                    </tr>  
                @endforeach