<?php $pageTitle='Gestion des Catégories'; ?>
<?php ob_start(); ?>

<section class="viewCats">
	<p><a href="index.php">Retourner au panneau principal</a></p>

	<div class="tools">
		<p>
			<form method="post" action="index.php?view=cats&works=<?=$_GET['works'] ?>&insertTools&token=<?=$_SESSION['token']?>">
				<fieldset>
						<input type="text" name="nameTool" size="6" placeholder="Nom de l'outil" required /><br />
						<input type="submit" value="Ajouter" />
				</fieldset>
			</form>
		</p>

		<?php
		while($TOOL = $listTools->fetch())
		{
			echo '
				<p>
					<form method="post" action="index.php?view=cats&works='.$_GET['works'].'&updateTools='.$TOOL['idTool'].'&token='.$_SESSION['token'].'">
						<fieldset>
								<input type="text" size="6" name="name'.$TOOL['idTool'].'" value="'.$TOOL['nameTool'].'" required /><br />
								<input type="submit" value="Modifier" />
								<a href="index.php?view=cats&works='.$_GET['works'].'&delTools='.$TOOL['idTool'].'&token='.$_SESSION['token'].'">(X)</a>
						</fieldset>
					</form>
				</p>
			';
		}
		?>
	</div>

	<div class="cats">
		<p><h1>Catégories:</h1></p>

		<p>
			<form method="post" action="index.php?view=cats&works=<?= $_GET['works'] ?>&insertCats&token=<?=$_SESSION['token']?>">
				<fieldset>
					Type: <input type="text" size="1" name="typeCat" placeholder="Type" required /><br />
					Nom: <input type="text" name="nameCat" placeholder="Nom de la cat." required /><br />
					Couleur: <input type="color" name="colorCat" placeholder="Couleur d'identification" required /><br />
					<input type="submit" value="Ajouter" />
				</fieldset>
			</form>
		</p>

		<?php
		while($CAT = $listCats->fetch())
		{
			echo'
				<p>
					<form style="background-color: '.$CAT['colorCat'].';" method="post" action="index.php?view=cats&works='.$_GET['works'].'&updateCats='.$CAT['Type'].'&token='.$_SESSION['token'].'">
						Type: '.$CAT['Type'].'<br />
						Nom: <input type="text" name="name'.$CAT['Type'].'" value="'.$CAT['nameCat'].'" required /><br />
						Couleur: <input type="color" name="clr'.$CAT['Type'].'" value="'.$CAT['colorCat'].'" required /><br />
						<input type="submit" value="Modifier" />
						<a href="index.php?view=cats&works='.$_GET['works'].'&upCats='.$CAT['Type'].'&token='.$_SESSION['token'].'">UP</a> / <a href="index.php?view=cats&works='.$_GET['works'].'&downCats='.$CAT['Type'].'&token='.$_SESSION['token'].'">DOWN</a>, <a href="index.php?view=cats&delCats='.$CAT['Type'].'&token='.$_SESSION['token'].'"> SUPPRIMER (!)</a><br />
						<a href="index.php?view=cats&works='.$CAT['Type'].'">Gestion des différentes parties de travail</a>
					</form>
				</p>
			';
		}
		?>

	</div>

	<div class="works">
		<h1>Parties de travail:</h1>

		<?php
		echo'
			<p>
				<form method="post" action="index.php?view=cats&works='.$_GET['works'].'&insertWorks&token='.$_SESSION['token'].'">
					<fieldset>
						ID: <input type="text" size="1" name="idWork" placeholder="ID" required />
						Nom: <input type="text" name="nameWork" placeholder="Nom de la partie" required />
						<input type="submit" value="Ajouter" />
					</fieldset>
				</form>
			</p>
		';

		while ($WORK = $listWorks->fetch())
		{
			echo'
				<p>
					<form style="background-color: '.$WORK['colorCat'].';" method="post" action="index.php?view=cats&works='.$_GET['works'].'&updateWorks='.$WORK['idWork'].'&token='.$_SESSION['token'].'">
						ID: '.$WORK['idWork'].', 
						Nom: <input type="text" name="name'.$WORK['idWork'].'" value="'.$WORK['nameWork'].'" />
						<input type="submit" value="Modifier" />
						<a href="index.php?view=cats&works='.$_GET['works'].'&upWorks='.$WORK['idWork'].'&token='.$_SESSION['token'].'">UP</a> / <a href="index.php?view=cats&works='.$_GET['works'].'&downWorks='.$WORK['idWork'].'&token='.$_SESSION['token'].'">DOWN</a>, <a href="index.php?view=cats&works='.$_GET['works'].'&delWorks='.$WORK['idWork'].'&token='.$_SESSION['token'].'">Supprimer (!)</a>
					</form>
				</p>
			';
		}
		?>
	</div>

</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require 'template.php' ?>