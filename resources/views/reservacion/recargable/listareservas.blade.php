        @foreach($reservas as $reserva)
            <tr>
                <td>{{$reserva->Nombre_Contacto}}</td>    
                <td>{{$reserva->Cedula_Cliente}}</td>
                <td>{{$reserva->created_at}}</td> 
                
                <td class="botones">
                    <button  data-toggle="modal" data-target="#infore" class="btn btn-primary detalle" value="{!!$reserva->ID_Reservacion!!}">Detalle</button>
                    <button   class="btn btn-danger delete" onclick="" value="Eliminar" >Eliminar</button>
                </td>
            </tr>
        @endforeach