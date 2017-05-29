<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<title>Tri bulle</title>
		<link rel="stylesheet" href="css/bubblesort.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="js/jquery.js" ></script>
		<script type="text/javascript" src="js/jquery.backgroundpos.js"></script>
		<script type="text/javascript" src="js/bubblesort.js" ></script>
		<script type="text/javascript" src="js/jquery-ui-1.9.0.custom.js" ></script>

		<link rel="stylesheet" type="text/css" media="screen" href="css/jquery/jquery.ui.all.css"/>					<!-- JQUERY -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/sunny/jquery-ui-1.8.19.custom.css" />		<!-- THEME JQUERY -->
	</head>
	<body>
        <div class="container">
			<header>
				<h1>Algorithmique & développement PHP5</h1>
				<h1>Tri bulle</h1>
			</header>
			<section>
                <div id="container_buttons">
					<h2 id="initTab">Initialisation du tableau</h2>
					<a class="alea_btn" href="#">Tirage</a> <span id="alea_nb" class="alea_nb">&nbsp;</span> 
                </div>
			</section>
			<section id="presentation" style="display:none">
				<div id="pres_bloc">
					<div id="pres_prev" style="display:none"></div>
					<div id="pres_next"></div>
				</div>
			</section>
			<section id="stepExpli" style="display:none">
				<div class="stepExpli stepExpli1" style="display:none">
					<div class="expli1">
						<h2>Pour cette première étape :</h2>
						<ul>
							<li>3 fois le test de comparaison</li>
							<li>Autrement dit, une boucle qui tourne 3 fois</li>
							<li>Une boucle pour effecteur un test de comparaison entre deux valeurs adjacentes du tableau</li>
							<li>3 est le nombre moins 1 d'éléments à trier</li>
							<li>Le dernier élément est bien le plus grand</li>
						<ul>
					</div>
				</div>
				<div class="stepExpli stepExpli2" style="display:none">
					<div class="expli1">
						<h2>Pour cette deuxième étape :</h2>
						<ul>
							<li>Je fais encore une fois boucle</li>
							<li>Cette fois-ci, elle itère que 2 fois le test de comparaison</li>
							<li>Autrement dit, la boucle tourne une fois de moins que l'étape précédente</li>
							<li>Le dernier élément est bien le plus grand</li>
						<ul>
					</div>
				</div>
				<div class="stepExpli stepExpli3" style="display:none">
					<div class="expli1">
						<h2>Pour cette troisième étape :</h2>
						<ul>
							<li>Je fais encore une fois la boucle</li>
							<li>Elle effectue qu'une seul fois le test de comparaison</li>
							<li>Autrement dit, la boucle tourne une fois de moins que l'étape précédente</li>
							<li>Au final, j'ai 3 fois une boucle <em>dont la limite décroit au fur et à mesure de mon avancement</em></li>
							<li>Il y a donc deux boucles : l'une imbriquée dans l'autre</li>
							<li>l'une croît pendant que l'autre décroit</li>
						<ul>
					</div>
				</div>
			</section>
			
		</div>
		<div id="ask_add_message" title="Le test est-il vrai ?" style="display:none; cursor: default"></div>
	</body>
</html>