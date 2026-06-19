<script>
    $(document).ready(function() {
        $('#menuEndomarketing').collapse();
        $("#bt_endo_banners").addClass("active");
    });
</script>


<div align="left" class="cabecera_interna">
    <table width="100%">
        <tr>
            <td>
                <h2>Banners</h2>
            </td>
            <td align="right" width="200">
                <input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />

            </td>
        </tr>
    </table>
</div>


<div class="table-responsive">
    <table id="tabla_maestra" class="table table-striped table-hover align-middle" style="font-size:12px">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col">Imagen</th>
                <th scope="col">Título</th>
                <th scope="col">Link</th>
                <th scope="col">Orden</th>
                <th scope="col">Estado</th>
                <th scope="col" width="100" align="center">
                    
                        <a href="<?php echo $url; ?>?pg=endomarketing/banner/detalle">
                            <button type="button" class="btn btn-warning btn-sm">
                                <i class="fas fa-plus"></i> Nuevo
                            </button>
                        </a>
                   
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
            $count = 1;
            $query = mysqli_query($connect_endomarketing, "SELECT * FROM Banners ORDER BY titulo ASC ");
            while ($data = mysqli_fetch_array($query)) {

                $txt_estado = '';
                foreach ($Array_Estado as $nivel) {
                    if ($nivel[0] == $data["estado"]) {
                        $txt_estado = $nivel[1];
                    }
                }

                
                    $bt_editar = '
                            <a href="' . $url . '?pg=endomarketing/banner/detalle&id=' . $data["id"] . '">
                                <button type="button" class="btn btn-outline-success btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </a>
                   ';
              

               
                    $bt_eliminar = '
						<button type="button" class="btn btn-danger btn-sm" title="eliminar" onclick="Eliminar_Banner(' . $data["id"] . ')" >
							<i class="fas fa-times"></i>
						</button>
                   ';
               

                echo '
                        <tr>
                            <td>' . $count . '</td>
                            <td><img src="resources/' . $data["archivo"] . '" width="150"></td>
                            <td>' . $data["titulo"] . '</td>
                            <td>' . $data["link"] . '</td>
							<td>' . $data["orden"] . '</td>
                            <td>' . $txt_estado . '</td>
                            <td  align="center">
                                ' . $bt_editar . '
								' . $bt_eliminar . '
                            </td>
                        </tr>
                        
                    ';
                $count++;
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#buscador").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".tabla_lista tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    var api = '<?php echo $url; ?>/api/endomarketing/';

    function Eliminar_Banner(id_registro) {


        jQuery.ajax({
                url: api + "eliminar_banner.php",
                type: 'post',
                data: {
                    id_registro: id_registro,
                    url: "<?php echo $url; ?>?pg=endomarketing/banners"
                },
            }).done(function(resp) {
                $("#xscript").html(resp);
            })
            .fail(function(resp) {
                console.log(resp);
            })
            .always(function(resp) {});

    }
    
    $('#tabla_maestra').DataTable({
        pagingType: 'simple_numbers',
        pageLength: 50,
        lengthMenu: [[50, 100, 200, 500, -1], [50, 100, 200, 500, "TODOS"]],
        language: {
            lengthMenu: 'Mostrar <i class="fa fa-th-list me-1"></i> <span>_MENU_</span>',
            zeroRecords: "No se encontraron registros",
            info: 'Mostrando <span><i class="fa fa-eye me-1"></i> _START_ a _END_ de _TOTAL_</span>',
            infoEmpty: 'Mostrando <span><i class="fa fa-eye-slash me-1"></i> 0 a 0 de 0</span>',
            infoFiltered: "(filtrado de _MAX_ registros)",
            search: '<i class="fa fa-search me-1"></i> Buscar:',
            paginate: {
                first: '<i class="fa fa-angle-double-left me-1"></i> Primero',
                last: 'Último <i class="fa fa-angle-double-right ms-1"></i>',
                next: 'Siguiente <i class="fa fa-angle-right ms-1"></i>',
                previous: '<i class="fa fa-angle-left me-1"></i> Anterior'
            }
        },
        responsive: true
    });

</script>