<div class="list-group " id="list-tab" role="tablist" style="height:30em; overflow:scroll;">
          <table class="table table-hover table-dark"  >
            <thead>
              <tr>
                <th class="text-center">Cargo</th>
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
        </div>