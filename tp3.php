<?php

define('BORNE_INF', 1);
define('BORNE_SUP', 10);


$tables_de_multiplications = [];
$tm = &$tables_de_multiplications;

for($i = BORNE_INF; $i <= BORNE_SUP; $i++) {
	for ($j = BORNE_INF; $j <= BORNE_SUP; $j++) {		
		$tm[$i][$j] = $i * $j;
	} 	
}

//setcookie('pseudo','',time() - 3600);

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Table de multiplications</title>
	<link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>

<table class="table table-stripped table-bordered">
	<thead class="thead-dark">	
	<tr>
		<th>*</th>
	<?php foreach($tables_de_multiplications as $chiffre => $table) {?>
		<th><?php echo $chiffre; ?></th>
	<?php } ?>
	</tr>
	</thead>
	<?php foreach($tables_de_multiplications as $chiffre => $resultats) {?>
	<tr>
		<th><?php echo $chiffre; ?></th>
		<?php foreach($resultats as $resultat) { ?>
			<td><?php echo $resultat; ?></td>
		<?php } ?>			
	</tr>
	<?php } ?>
</table>
	
</body>
</html>
