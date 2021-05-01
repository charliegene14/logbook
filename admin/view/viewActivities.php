<?php $pageTitle = 'Activités du site'; ?>
<?php ob_start(); ?>

<section class="viewConnected">

	<div class="lastConnexion">
		<p><a href="index.php">Retourner au panneau principal</a></p>
		<p><i>(<?= $totalVisits ?> visiteurs au total)</i></p>
		<fieldset>
		<?php

		while ($IP = $listIP->fetch())
		{
			if ($IP['ipAddr'] == $_GET['ip'])
			{
				echo '<p>-->><span style="background-color: purple; color: white; border-radius: 5px"><b>'.$IP['ipAddr'].'</b> : last at '.$regex->date($IP['lastVisit']).' ('.$IP['totalViews'].' views)</span> >> </p>';
			}
			else
			{
				echo '<p><a style="background-color: darkgrey; color: black; border-radius: 5px" href="index.php?view=activities&ip='.$IP['ipAddr'].'&date='.$IP['lastVisit'].'">'.$IP['ipAddr'].'</a> : last at '.$regex->date($IP['lastVisit']).' ('.$IP['totalViews'].' views)</p>';
			}
		}
		?>
		</fieldset>
	</div>

	<div class="viewConnectedDate">
		<fieldset>
			<?php
			while ($DATE = $listDates->fetch())
			{
				if ($DATE['dateVisit'] == $_GET['date'])
				{
					echo '<p>-->><span style="background-color: purple; color: white; border-radius: 5px"><b>'.$regex->date($DATE['dateVisit']).'</b> ('.$DATE['viewsDate'].' views)</span> >></p>';
				}
				else
				{
					echo '<p><a style="background-color: darkgrey; color: black; border-radius: 5px" href="index.php?view=activities&ip='.$_GET['ip'].'&date='.$DATE['dateVisit'].'">'.$regex->date($DATE['dateVisit']).' ('.$DATE['viewsDate'].' views)</a></p>';
				}
			}
			?>
		</fieldset>
	</div>

	<div class="viewConnectedDetails">
			<?php
			while ($DETAIL = $listDetails->fetch())
			{?>

				<fieldset>
					<p>
						<b><?=$DETAIL['timeVisit']?></b>: (<i><?=$DETAIL['ipHost']?></i>)<br /><?=$DETAIL['view'] ?><br /> <b>METHOD:</b> <?= $DETAIL['method'] ?><br />
						<b>AGENT:</b> <?=$DETAIL['userAgent']?><br />
						<b>LANG:</b> <?=$DETAIL['accptLang']?>
					</p>
				</fieldset>

			<?}
			?>
	</div>
	
</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require('template.php'); ?>