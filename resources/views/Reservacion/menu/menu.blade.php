
        <div id="mensajemenu"></div>
        <table class="table table-hover table-dark datos" cellspacing="0" style="width:100%;">
            <thead>
                <th class="text-center" data-orderable="false">Imagen</th>
                <th class="text-center">Descripcion</th>
                <th class="text-center">Costo</th>
                <th class="text-center" >Cantidad</th>
                <th class="text-center" data-orderable="false" style="width:20%"></th>
            </thead>
            <tbody class="text-center"> 
                @foreach($menu as $comida)
                    <tr style="height:5em;">
                        <td><img src="https://s3.us-east-2.amazonaws.com/pruebakavv/Menu/{{$comida->path}}"  style="height:10em;border-radius: 40px;" value="{{$comida->path}}"></td> 
                        <td class="comidades">{{$comida->descripcion}}</td>    
                        <td class="comidacos">{{$comida->costo}}</td>  
                        <td class="comidacant"><input type="text" class"form-control" style="width:100%" id="menucant{{$comida->id}}"></td> 
                        <td class="botones">
                            <button class="btn btn-success menuadd" value="{{$comida->id}}">Añadir</button>
                        </td>
                    </tr>  
                @endforeach
            </tbody>
        </table>
