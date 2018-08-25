                  <table class="table table-hover" cellspacing="0" id="tablaarti" style="width:100%;">  
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Costo Alquiler</th>
                        <th class="text-center" data-orderable="false" style="width:10%"></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="tablaarticulos">
                      @foreach($inventario as $item)
                        <tr id="artiCant{!!$item->ID_Objeto!!}">
                          <td class="itemname">{!!$item->Nombre!!}</td>
                          <!-- ACA SERIA EL IF -->
                          @if(array_key_exists($item->ID_Objeto, $ir))
                            <td id="c_artiCant{!!$item->ID_Objeto!!}"><?php echo $item->Cantidad - $ir[$item->ID_Objeto] ?></td>
                          @else
                            <td id="c_artiCant{!!$item->ID_Objeto!!}">{!!$item->Cantidad!!}</td>
                          @endif
                          <td class="cost">{!!$item->Costo_Alquiler!!}</td>
                          <td>
                            <button  value="{!!$item->ID_Objeto!!}" type="button" class="btn btn-primary" onclick="mostrar(this);" data-toggle="modal" data-target="#Add"  >Reservar</button>
                          </td>
                          <td>{!!$item->ID_Servicio!!}Servicio</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>