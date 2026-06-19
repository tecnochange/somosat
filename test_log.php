<script>  
	window.onload=function(){
	  url = window.location.href;
	  i=url.indexOf("#");
	  if(i>0) {
	  url=url.replace("#","?");
	  window.location.href=url;}
	}
</script>

<?php
	session_start();
	$_SESSION['token'] = md5(uniqid(mt_rand(), true));
	$_SESSION['state'] = session_id();
	//echo "</br>";
	$_SESSION['msatg'];
	//echo "</br>";
	//echo "el token es:";
	$_GET['access_token'];
	//echo "</br>";
	//echo "se acabo el token";

	if (array_key_exists ('access_token', $_GET)){
		
 		$_SESSION['t'] = $_GET['access_token'];
		$t = $_SESSION['t'];

		$ch = curl_init ();
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array ('Authorization: Bearer '.$t,'Content-type: application/json'));
		curl_setopt ($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me/");
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$rez = json_decode (curl_exec ($ch), 1);

		if (array_key_exists ('error', $rez)){  
 			var_dump ($rez['error']);    
 			die();
		}

		else{
			$_SESSION['msatg'] = 1;  //auth and verified
			$_SESSION['uname'] = $rez["displayName"];
			$_SESSION['id'] = $rez["id"];
			$_SESSION['mail']= $rez["mail"] ;
			//echo '<br>';
			$_SESSION["user"]=$rez["userPrincipalName"];
			$user = $rez["userPrincipalName"];
		}

		//echo '<br>El usuario es:<br>'.$user;
		curl_close ($ch);
?>
		<form name='envia' method='POST' action='https://somosat.hr-suite.app/index.php'>
			<input type=hidden name=user value=<?php echo $user ?>>
			<input type="hidden" name="csrf" value="<?php echo $_SESSION['token_crf']; ?>">
		</form>
		<script language="JavaScript">
			document.envia.submit()
		</script>";
<?php
   //header ('Location: https://somosat.hr-suite.app/index.php?user='.$user.'');
	}

	if ($_GET['action'] == 'logout'){
	   unset ($_SESSION['msatg']);
	 //  header ('Location: https://msdemo1.freecluster.eu/');
	}

?>