<?php
    $tipo_role = $_GET["t"];
    $_SESSION['role_plataforma'] = $tipo_role;
?>
<script>
    window.location = "?pg=home";
</script>