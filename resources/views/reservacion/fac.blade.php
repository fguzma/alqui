<html>
    <head>
        <style>
            table{border-radius:7px;-moz-border-radius: 7px;width:28%;border-collapse:separate}
            table,th,td{border: 1px solid dodgerblue;}
            h2{text-align: center;}
            h2,h3,th,td{color:dodgerblue;}
            p{line-height: 70%;font-size: 12px; text-align: center; color: dodgerblue;}
        </style>
    </head>

    <body>
        <br>

        <div style="width: 100%">
            <h2> Alquileres Santana.</h2>
            <p> Yenssy Smyrna Santana.<!--Martha Janett Varela--> </p>
            <p> Alquiler de sillas, mesas, manteles, trajes para sillas, utensilios para Buffet, servicio de Buffet, recordatorios, centros de mesas, </p>
            <p>arreglos con cortinaje, globos , flores naturales, toldos, sonido,tarimas, todo para su evento especial. </p>
            <p>Bo. La Fuente frente al portón principal de la Escuela Normal, casa no.26</p>
            <p>2289 4289</p>
            <p> RUC xxxxxxxxxxxxxx</p>
<!--        <p> Servicio de Buffet, Sillas(niñas y adultos), Mesas de 4 y 10 personas, Manteles y Chaffing</p>
            <p> De donde fue la Sandak 3 c. arriba, 1 c. al lago, Reparto Lopez</p>
            <p> Telefono: 2280-1262/Cel: 8813-7624 Managua, Nic</p>
            <p> RUC 2810201640011M</p>-->
            <h3 style="text-align: left"><?php echo $Arreglo[count($Arreglo)-1] ?></h3>
            <h3 style="text-align: left">Cliente: {{$NC}} / {{$CC}}</h3>
            <h3 style="text-align: left">Direccion: {{$DL}}</h3>
        </div>

        <br>

        <div style="width:100%">
        <table style="width:100%">
            <thead>
                <tr>
                    <th style="width:10%">Cant.</th>
                    <th style="width:70%">Descripcion</th>
                    <th style="width:10%">P/Unitario</th>
                    <th style="width:10%">TOTAL</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                    $pos=0;
                    for($i=0;$i<(count($Arreglo)-4)/5;$i++)
                    {
                        echo "<tr>";
                        for ($j=0; $j < 4; $j++) 
                        { 
                            if($j==0)
                                echo '<td style="text-align: center">'.$Arreglo[$pos+1].'</td>';
                            if($j==1)
                                echo '<td>'.$Arreglo[$pos-1].'</td>';
                            if($j==2)
                                echo '<td style="text-align: center">'.$Arreglo[$pos].'</td>';
                            if($j==3){
                                echo '<td style="text-align: center">'.$Arreglo[$pos+1].'</td>';
                                $pos++;
                            }
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
                    </tr>';
                ?>
                <!--
                    <tr>
                        <td colspan="3" style="text-align: right"> <b>GranTotal</b></td>
                        <td style="text-align: center">'.$Arreglo[$pos+2].'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right"> <b>IVA</b></td>
                        <td style="text-align: center">'.$Arreglo[$pos+1].'</td>
                    </tr>-->
            </tfoot>
        </table>
        </div>
    </body>
</html>