<html>
    <head>
        <style>
            table{border-radius:50%;width:28%;border-collapse:collapse}
            table,th,td{border: 1px solid black;}
            h1{text-align: center;}
        </style>
        
    </head>

    <body>
        <div style="width: 28%">
            <h1> Factura N ####</h1>
            <h3 style="text-align: center" id='F'>Fecha __ de ________ de ____</h3>
            <h3 style="text-align: center" id='NC'>Cliente: {{$NC}}</h3>
            <h3 style="text-align: center" id='D'>Direccion: {{$DL}}  </h3>
            <h3 style="text-align: center" id='FI'>Fecha Inicio: {{$FI}}</h3>
            <h3 style="text-align: center" id='FF'>Fecha Fin: {{$FF}} </h3>
        </div>

        <br>


        <table class="">
            <thead>
                <tr>
                    <th width="10%">Cant.</th>
                    <th>Descripcion</th>
                    <th width="18%">P/Unitario</th>
                    <th width="10%">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $pos=0;
                    for($i=0;$i<(count($Arreglo)-3)/4;$i++)
                    {
                        echo "<tr>";
                        for ($j=0; $j < 4; $j++) 
                        { 
                            echo "<td>".$Arreglo[$pos]."</td>";
                            $pos++;
                        }
                        echo "</tr>";
                    }
                ?>
                
            </tbody>
            <tfoot>
                <?php
                   echo ' <tr>
                        <td colspan="3" style="text-align: right"> <b>Sub-Total</b></td>
                        <td style="text-align: center">'.$Arreglo[$pos].'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right"> <b>Transporte</b></td>
                        <td style="text-align: center">'.$Arreglo[$pos+1].'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right"> <b>Envio</b></td>
                        <td style="text-align: center">'.$Arreglo[$pos+2].'</td>
                    </tr>';
                ?>
            </tfoot>
        </table>
    </body>
</html>