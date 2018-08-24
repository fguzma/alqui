
          <table class="table table-hover table-dark" id="tablacargos" cellspacing="0" style="width:105%;" >
            <thead>
              <tr>
                <th class="text-center" >Cargo</th>
                <th class="text-center" data-orderable="false" ></th>
              </tr>
            </thead>
            <tbody>
              @foreach($Cargos as $cargo)
                <tr>
                  <td >{!!$cargo->Nombre_Cargo!!}</td>
                  <td class="btn-primary text-center">
                    <input type="checkbox" OnClick='addcargo(this,"{!!$cargo->Nombre_Cargo!!}","{!!$cargo->ID_Cargo!!}")'>
                  </td>
                </tr>  
              @endforeach
            </tbody>
          </table>
