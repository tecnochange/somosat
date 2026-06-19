<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicaciones</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#bt_endoMark_banner").addClass("active_item");
            $("#endomark_menu").addClass("active");
            $('#endomark_menu .collapse').collapse();

            // Inicializar DataTable
            var table = $('.table').DataTable({
                "paging": true,
                "pageLength": 100,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "order": [[4, "desc"]], // Ordenar por la fecha de publicación (columna índice 4)
                "info": true,
                "autoWidth": false,
                "language": {
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de _MAX_ entradas totales)"
                }
            });

            // Filtro de búsqueda global
            $("#buscador").on("keyup", function () {
                table.search($(this).val()).draw();
            });
        });

        var api = '<?php echo $url; ?>/api/endomarketing/';

        function Eliminar_Banner(id_registro) {
            jQuery.ajax({
                url: api + "eliminar_banner.php",
                type: 'post',
                data: {id_registro: id_registro, url: "<?php echo $url; ?>?pg=endomarketing/banners"},
            }).done(function (resp) {
                $("#xscript").html(resp);
            })
                .fail(function (resp) {
                    console.log(resp);
                })
                .always(function (resp) {
                });
        }
    </script>
</head>
<body>
<div class="container">
    <div align="left" class="cabecera_interna">
        <table width="100%">
            <tr>
                <td><h2>Publicaciones</h2></td>
                <td align="right" width="200" style="display: none">
                    <input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador"/>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-responsive">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" width="15">#</th>
                        <th scope="col">Archivo</th>
                        <th scope="col">Publicación</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Fecha de Publicación</th>
                        <th scope="col">Estado</th>
                    </tr>
                    </thead>
                    <tbody class="tabla_lista">
                    <?php
                    $tipo_nombres = [
                        8 => "Calidad de Vida",
                        9 => "Noticias",
                        7 => "Celebraciones",
                        5 => "Nuestra Gente",
                        4 => "Clasificados",
                        3 => "Reconocimiento"
                    ];

                    $count = 1;
                    $query = mysqli_query($connect_endomarketing, "
                        SELECT Publicaciones.descripcion, Publicaciones.script, Publicaciones.tipo, Publicaciones.fecha_publicacion, Publicaciones.estado, Multimedia.imagen 
                        FROM Publicaciones 
                        LEFT JOIN Multimedia ON Publicaciones.id = Multimedia.id_publicacion 
                        WHERE Publicaciones.id_empresa = '".$_SESSION["id_empresa"]."'
                        ORDER BY Publicaciones.fecha_publicacion DESC
                    ");

                    while ($data = mysqli_fetch_array($query)) {

                        $txt_estado = '';
                        foreach ($Array_Estado as $nivel) {
                            if ($nivel[0] == $data["estado"]) {
                                $txt_estado = $nivel[1];
                            }
                        }

                        $tipo_nombre = isset($tipo_nombres[$data["tipo"]]) ? $tipo_nombres[$data["tipo"]] : "Tipo desconocido";

                        $archivo = $data["imagen"];
                        $extension = pathinfo($archivo, PATHINFO_EXTENSION);

                        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            $archivo_html = '<img src="' . $url . '/resources/muro/' . $archivo . '" width="150">';
                        } elseif ($extension == 'pdf') {
                            $archivo_html = '<a href="' . $url . '/resources/muro/' . $archivo . '" target="_blank">Ver PDF</a>';
                        } elseif (in_array($extension, ['mp4', 'webm', 'ogg'])) {
                            $archivo_html = '<video width="150" controls><source src="' . $url . '/resources/muro/' . $archivo . '" type="video/' . $extension . '">Tu navegador no soporta la etiqueta de video.</video>';
                        } elseif ($extension == 'pptx') {
                            $archivo_html = '<a href="' . $url . '/resources/muro/' . $archivo . '" target="_blank">Ver presentación PPTX</a>';
                        } elseif ($extension == 'docx') {
                            $archivo_html = '<a href="' . $url . '/resources/muro/' . $archivo . '" target="_blank">Ver documento DOCX</a>';
                        } else {
                            $archivo_html = 'Formato no soportado';
                        }

                        echo '
                        <tr>
                            <td>' . $count . '</td>
                            <td>' . $archivo_html . '</td>
                            <td>' . $data["descripcion"] . '</td>
                            <td>' . $tipo_nombre . '</td>
                            <td>' . $data["fecha_publicacion"] . '</td>
                            <td>' . $txt_estado . '</td>
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
$( document ).ready(function() {
	$('#menuEndomarketing').collapse();
    $("#bt_endo_tools").addClass("active");
});
</script>

</body>
</html>
