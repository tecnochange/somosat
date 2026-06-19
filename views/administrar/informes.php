<?php
    $queryColaboradores = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ");
    $queryAreas = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id_empresa = '".$_SESSION['id_empresa']."' ");
    $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empresa = '".$_SESSION['id_empresa']."' ");
?>
<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <h2 align="center">Informes administrativos</h2>
        </div>
        
        <div class="col-md-4">
            <div class="card" align="center">
                <div class="card-body">
                    Colaboradores<br>
                    <h2><?php echo $queryColaboradores->num_rows; ?></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card" align="center">
                <div class="card-body">
                    Áreas<br>
                    <h2><?php echo $queryAreas->num_rows; ?></h2>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-4">
            <div class="card" align="center">
                <div class="card-body">
                    Cargos<br>
                    <h2><?php echo $queryCargos->num_rows; ?></h2>
                </div>
            </div>
        </div>
        
    
    </div>
</div>


<script>
    $("#bt_adm_informes").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>



