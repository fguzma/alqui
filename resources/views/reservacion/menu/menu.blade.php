
        <div id="mensajemenu"></div>
        <table class="table table-hover table-dark" id="tablamenu" cellspacing="0" style="width:100%;">
            <thead>
                <th class="text-center" data-orderable="false">Imagen</th>
                <th class="text-center">Descripcion</th>
                <th class="text-center">Costo</th>
                <th class="text-center" >Cantidad</th>
                <th class="text-center" data-orderable="false" style="width:20%"></th>
            </thead>
            <tbody class="text-center"> 
                @foreach($menu as $comida)
                    <tr style="height:5em;" id="menucant{{$comida->id}}">
                        <td><img src="https://s3.us-east-2.amazonaws.com/pruebakavv/Menu/{{$comida->path}}"  style="height:10em;border-radius: 40px;" value="{{$comida->path}}"></td> 
                        <td>{{$comida->descripcion}}</td>    
                        <td>{{$comida->costo}}</td>  
                        <td><input type="text" onkeypress="return valida(event);" class="form-control" style="width:100%" id="c_menucant{{$comida->id}}"></td> 
                        <td>
                            <button class="btn btn-success" onclick="AddToListMenu(this)" value="{{$comida->id}}">Añadir</button>
                        </td>
                    </tr>  
                @endforeach
            </tbody>
        </table>
