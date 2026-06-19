<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id_registro"];

	include("../../app/models/connect.php");
    mysqli_query($connect_endomarketing,"DELETE  FROM Banners WHERE id = '".$id."'  ");
?>

<script>
	window.location = "<?php echo $urlRedirect; ?>";
</script>