<script>
	$(document).ready(function () {
		$('#menuAgente').collapse();
		$("#bt_agente_preguntas").addClass("active");
	});
</script>

<script>
function exportarReporte(){
	$("#datos_a_enviar").val( $("<div>").append( $("#tabla_maestra").eq(0).clone()).html());
	$("#FormularioExportacion").submit();
   }
</script>


<div class="container mb-4">

    <div class="d-flex justify-content-between ">
        <div class="mb-1">
            <h2>Asistente</h2>
        </div>

        <div class="mb-1 d-flex gap-1" align="right">
            
            <button type="button"class="btn btn-primary btn-sm" onclick="exportarReporte()" style="margin-bottom: 18px">Reporte</button>

            <a href="<?= $url; ?>?pg=asistentes/respuesta/detalle">
                <button type="button" class="btn btn-primary btn-sm" style="margin-bottom: 6px">Crear Nuevo</button>
            </a>

        </div>
    </div>
    
    <form action="app/models/exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"  />
    </form>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="tabla_maestra" border="1">
                    <thead class="">
                        <tr>
                            <th scope="col" width="15">#</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Link</th>
                            <th scope="col">Roles</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="tabla_lista">
                        <?php
                        $hoy = date("Y-m-d H:i:s");
                        $count = 1;

                        $query = mysqli_query($connect_valentina, " SELECT * FROM Ayudas ORDER BY id ASC");
                        while ($data = mysqli_fetch_array($query)) {
                           

                            $lista_role = "";
                            $obj_roles = explode(",", $data["roles"]);
                            foreach ($obj_roles as $role) {

                                $queryRoles = mysqli_query($connect_valentina, " SELECT * FROM Roles WHERE id = '".$role."' ");
                                $dataRoles = mysqli_fetch_array($queryRoles);

                                $lista_role .= $dataRoles["nombre"]."<br>";

                            }




                            echo '
                                <tr>
                                    <td>' . $count . '</td>
                                    <td>'.$data["categoria"].'</td>
                                    <td>'.$data["descripcion"].'</td>
                                    <td>'.$data["link"].'</td>
                                    <td>'.$lista_role.'</td>
                                    <td>
                                        <a href="'.$url.'?pg=asistentes/respuesta/detalle&id='.$data["id"].'">
                                            <button type="button" class="btn btn-primary btn-sm" style="margin-bottom: 6px">Editar</button>
                                        </a>
                                    </td>
                                </tr>
                            ';

                            $count++;
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    
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

    var api = '<?php echo $url; ?>/api/estructura/';

    var activar = false;

    function Elimimar_Jefe(id) {

        if (activar == false) {
            $("#modal_generall").modal("show");
            $("#cont_modal_generall").html('Está a punto de eliminar un jefe, esta acción es irreversible ¿está seguro?<br><br>');
            $("#cont_modal_generall").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Jefe(' + id + ')"> Confirmar </button>');
        } else {

            jQuery.ajax({
                    url: api + "eliminar_jefe.php",
                    type: 'post',
                    data: {
                        id: id,
                        url: "?pg=administrar/jefes"
                    },
                }).done(function(resp) {
                    $("#xscript").html(resp);
                })
                .fail(function(resp) {
                    console.log(resp);
                })
                .always(function(resp) {});

        }
    }
</script>


<script>
    $(document).ready(function() {
        $("#buscador").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".tabla_lista tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>