        @foreach($reservas as $reserva)
            <tr>
                <td>{{$reserva->created_at}}</td> 
                <td>{{$reserva->Fecha_Inicio}}</td> 
                <td>{{$reserva->Fecha_Fin}}</td> 
                <td>{{$reserva->Nombre_Contacto}}</td>    
                <td>{{$reserva->Cedula_Cliente}}</td>  
                <td style="height:2em;">{{$reserva->Direccion_Local}}</td> 
                {!!Form::open(['route'=>['personal.destroy',$reserva->ID_Reservacion],'method'=>'DELETE'])!!}
                    <td>
                        {!!link_to_route('reserva.edit', $title = 'Ver', $parameters = $reserva->ID_Reservacion, $attributes = ['class'=>'btn btn-primary'])!!}
                    </td>
                    <td>
                        {!!Form::submit('Eliminar',['class'=>'btn btn-danger'])!!}
                    </td>
                {!!Form::close()!!}
            </tr>
        @endforeach