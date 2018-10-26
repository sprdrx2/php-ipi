<?php 

if(!isset($_SESSION)) { session_start(); }

define('NOM_FILLER_VALUE','Nom');
define('PRENOM_FILLER_VALUE','Prénom');

function error($msg) {
	$_SESSION['error'] = $msg;
	header('Location: crud.php');
	exit;
}

function debug($msg) {
	if(empty($msg)) { $msg .= print_r($_POST,$return = true); }
	$_SESSION['debug'] .= $msg;
}

function success() {
		sleep(1); // on s'assure juste que le cache sql sera invalide avant le réaffichage de la page
		header('Location: crud.php');
}

if (!empty($_SESSION['debug'])) { 
	$debug = $_SESSION['debug'];
	$_SESSION['debug'] = null;
}

if (!empty($_SESSION['error'])) { 
	$error = $_SESSION['error'];
	$_SESSION['error'] = null;
}

$cnx = mysqli_connect('localhost','saami','toto','saami');
if (!$cnx) {
	error('Problème de connexion à la base de données.');
}
$query 	= 'SELECT * FROM luserz ORDER BY nom,prenom;';
$luserz = mysqli_query($link_identifier = $cnx, $query = $query);

// delete
if (isset($_GET['delete'])) {
	if (empty($_GET['delete'])) {
		error('delete: id non fourni');
	} else {	
		$targetID = $_GET['delete'];	

		if(!is_numeric($targetID)) {
			error('delete: id invalide.');
		}
	
		$query = sprintf("SELECT id FROM luserz WHERE id=%d;", $targetID);
		$select = mysqli_query($link_identifier = $cnx, $query = $query);


		if ($select->num_rows < 1) {
			error('delete: luser inconnu.');
		} else if ($select->num_rows > 1) {
			error('delete: id not unique wtf.');
		}
	
		$query = sprintf("DELETE FROM luserz WHERE id = %d;", $targetID);
		$delete = mysqli_query($link_identifier = $cnx, $query = $query);

		if(!$delete) {
			error('delete: operation impossible dsl.');
		} else {
			success();
		}
	}
}



// INSERT (si demandé)

if(!empty($_POST['method'])) { 
	$method = $_POST['method'];
	debug(print_r($_POST, true));

	if ($method == 'insert' || $method == 'update') {

		if ($method == 'update') {
			if (empty($_POST['targetId'])) 			{ error('update: id non fourni'); } 
			if (!is_numeric($_POST['targetId'])) 	{ error('update: id invalide'); } 
			$targetId = $_POST['targetId'];
		}

		/// validation des données
	 	if( (empty($_POST['nom'])) || (empty($_POST['prenom'])) || (empty($_POST['ddn'])) ) {
			error("$method: veuillez remplir tous les champs.");
		}          

		$nom	= $_POST['nom'];
		$prenom = $_POST['prenom'];

		// verifier que la date est une date
		// et date n'est pas dans le futur
		$ddn = strtotime($_POST['ddn']);
		if (!$ddn) 			{ error('update/insert: date invalide.'); }
		if ($ddn >= time()) { error('update/insert: date incohérente.'); } 

		// nom et prenom ne sont pas des chiffres
		if ( (is_numeric($nom)) || (is_numeric($prenom)) ) {
			error("$method: nom/prénom (chiffre)");
		}
		$regex = "/^[a-zA-Zéèàü\-\s']{2,}$/";
		if ( (!preg_match($regex, $nom)) || (!preg_match($regex, $prenom)) ) {
			error("$method: nom/prénom (caractères invalides)");
		}
		if ( ($nom == NOM_FILLER_VALUE) || ($prenom == PRENOM_FILLER_VALUE) ) {
			error("$method: veuillez rentrer un nom/prénom.");
		}

		// unifier noms et prenoms
		$nom	= ucwords(strtolower(trim($nom)),	 " -'");
		$prenom	= ucwords(strtolower(trim($prenom)), " -'");

		//// verification doublon
		// construction du select	
		switch ($method) {
			case 'insert':
				$query = sprintf("SELECT id FROM luserz WHERE nom = '%s' and prenom = '%s';", addslashes($nom), addslashes($prenom));
				break;
		 	case 'update':
				$query = sprintf("SELECT id FROM luserz WHERE id = '%s';", $targetId);
				break;
		}
		$select = mysqli_query($link_identifier = $cnx, $query = $query);

		// TODO: à tester avec curl
		// si insert l'user ne doit pas exister, si update il doit exister	
		if ($select->num_rows > 1 )							{ error("$method: id not unique wtf."); }
		if ($select->num_rows > 0 && $method == 'insert') 	{ error("$method: utilisateur existant."); }
		if ($select->num_rows < 1 && $method == 'update') 	{ error("$method: utilisateur inexistant"); }

		/// insertion or updation
		// construction requete
		$ddn_fmtd = strftime('%Y-%m-%d', $ddn);
		switch ($method) {
			case 'insert':
				$query 	= sprintf("INSERT INTO luserz (nom, prenom, ddn) VALUES ('%s', '%s', '%s');", addslashes($nom), addslashes($prenom), $ddn_fmtd);
				break;
		 	case 'update':
				$query = sprintf("UPDATE luserz SET nom = '%s', prenom = '%s', ddn = '%s' WHERE id = '%s';", addslashes($nom), addslashes($prenom), $ddn_fmtd, $targetId);
				break;
		}
		debug($query);
		$response = mysqli_query($link_identifier = $cnx, $query = $query);

		if (!$response) {
			error("$method: insertion dans la bdd impossible.");
		} else {
			success();
		}
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Inscription</title>
	<link rel="stylesheet" href="bootstrap.min.css">
	<style>
	#error { border: 1px solid black; background-color:red; color:black; text-align: center; font-weight: bold; }
	#debug { border: 1px solid black; background-color:green; color:black; text-align: center; font-weight: bold; font-variant:italic;}
	body { margin: auto; padding-left:20%; padding-right:20%; }
	form { margin-bottom: 2px; }
	h1 { text-align: center; }
	</style>
</head>
<body>
	<h1>le CRUD</h1>

	<?php if(!empty($error)) { ?>
	<p id="error">erreur: <?php echo $error; ?></p>
	<?php } ?>

	<?php if(!empty($debug)) { ?>
	<p id="debug">debug: <?php echo $debug; ?></p>
	<?php } ?>

	<form method="post" action="crud.php">
		<input type="hidden" 	name="method"	value="insert"/>
		<input type="text" 		name="nom" 		value="<?php echo NOM_FILLER_VALUE; ?>" />
		<input type="text"		name="prenom" 	value="<?php echo PRENOM_FILLER_VALUE; ?>" />
		<input type="date" 		name="ddn" 		value="1985-12-21" />
		<input type="submit" 	value="submit" />
	</form>
	
	<?php if($luserz) {?>
		<?php while($row = mysqli_fetch_assoc($luserz)) { ?>
	<form method="post" action="crud.php">
		<input name="nom" 		type="text" 	value="<?php echo $row['nom']; ?>" />
		<input name="prenom" 	type="text" 	value="<?php echo $row['prenom']; ?>" />	
		<input name="ddn"	 	type="date" 	value="<?php echo $row['ddn']; ?>" />
		<input type="hidden" 	name="targetId"	value="<?php echo $row['id']; ?>"/>
		<input type="hidden" 	name="method"	value="update"/>
		<input type="submit" 	value="update" />
		<a class="btn" href="crud.php?delete=<?php echo $row['id']; ?>">delete</a>
	</form>

		<?php } ?>
	<?php } ?>

</body>
</html>
