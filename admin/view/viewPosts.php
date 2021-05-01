<?php  $pageTitle='Gestion des Articles'; ?>
<?php  ob_start(); ?>

<section class="viewPosts">
	<p><a href="index.php">Retourner au panneau principal</a></p>
	<p><a href="index.php?view=postinsert">Ajouter un article</a></p>
	<aside class="sort">
		<form method="post" action="index.php?view=posts">
			<fieldset>

				<select name="type" onChange="this.form.submit()">
					<option value="">Toute catégorie</option>
					<?php 
						while ($CAT = $categories->fetch())
						{
							echo '<option value="'.$CAT['Type'].'"';
							if (!empty($_POST['type']) && $_POST['type'] == $CAT['Type'] OR !empty($_GET['type']) && $_GET['type'] == $CAT['Type'])
							{
								echo 'selected';
							}
							echo '>'.$CAT['nameCat'].'</option>';
						}
					?>
				</select>

				<select name="work" onChange="this.form.submit()">
					<option value="">Toute partie de travail</option>
					<?php 
						while ($WORK = $workParts->fetch())
						{
							echo '<option value="'.$WORK['idWork'].'"';
							if (!empty($_POST['work']) && $_POST['work'] == $WORK['idWork'] OR !empty($_GET['work']) && $_GET['work'] == $WORK['idWork'])
							{
								echo 'selected';
							}
							echo '>'.$WORK['nameWork'].'</option>';
						}
					?>
				</select>

				<select name="tool" onChange="this.form.submit()">
					<option value="">Tous les outils</option>
					<?php 
						while ($TOOL = $tools->fetch())
						{
							echo '<option value="'.$TOOL['idTool'].'"';
							if (!empty($_POST['tool']) AND $_POST['tool'] == $TOOL['idTool'] OR !empty($_GET['tool']) && $_GET['tool'] == $TOOL['idTool'])
							{
								echo 'selected';
							}
							echo '>'.$TOOL['nameTool'].'</option>';
						}
					?>
				</select>

			</fieldset>
		</form>
	</aside>

	<?php 
	while ($POST = $REQ_POSTS->fetch())
	{
		echo '<p style="background-color: '.$POST['colorCat'].';">
				<a href="index.php?view=postupdate&id='.$POST['idPost'].'">
					le '.$regex->date($POST['datePost']).': 
					<b>'.$POST['titlePost'].'</b> ('.$POST['nameCat'].' - ';

						if ($POST['Work'] != NULL)
						{
							echo $POST['nameWork'];
						}
						else
						{
							echo 'Aucune partie';
						}

				echo ' - avec ';

						if ($POST['Tool'] != NULL)
						{
							echo $POST['nameTool'];
						}
						else
						{
							echo 'aucun outil';
						}
				echo ')
				</a>
			</p>
		';
	}
	?>

	<p class="pages">
		<?php 
			for($PAGE=1; $PAGE <= $TOTAL_PAGE; $PAGE++)
			{
				if ($PAGE == $PAGE_NOW)
				{
				echo ' <strong> '.$PAGE.' </strong> ';
				}
				else
				{
					echo ' <a href="index.php?view=posts';
						if (!empty($_GET['type']))
						{
							echo '&amp;type='.$_GET['type'].'';
						}

						if (!empty($_GET['work']))
						{
							echo '&amp;work='.$_GET['work'].'';
						}

						if (!empty($_GET['tool']))
						{
							echo '&amp;tool='.$_GET['tool'].'';
						}

						echo '&amp;pg='.$PAGE.'"> '.$PAGE.' </a>';
				}
			}
		?>
	</p>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require 'template.php' ?>