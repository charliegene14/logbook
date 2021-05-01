<?php  $pageTitle = 'Versions - '.$PROJ['titleProject'].''; ?>
<?php  ob_start(); ?>

<section class="versions">

    <div class="header">
		<div class="icon">
			<img src="public/img/projects/<?=$PROJ['idProject']?>.png" alt="<?=$PROJ['titleProject']?>" />
		</div>

		<div class="info">
            <h2 style="color: <?=$PROJ['colorCat']?>"><b><?=$PROJ['titleProject']?></b></h2>
            <h3>Historique des versions</h3>
        </div>
    </div>

    <div class="articles">
        <?php while ($VERSION = $listVersions->fetch()) { ?>
            <article class="version" id="<?=$VERSION['theVersion']?>">

                <div class="line">

                    <div class="theVersion">
                        <p><?=$VERSION['theVersion']?></p>
                    </div>

                    <div class="download">
                        <p><a href="public/files/<?=$PROJ['titleProject']?>/versions/<?=$VERSION['theVersion']?>.zip">
                            Télécharger .zip
                        </a></p>
                    </div>

                    <div class="date">
                        <p><?= $regex->date($VERSION['dateVersion'])?></p>
                    </div>

                    <div class="targetChangelog">
                        <p><a href="#<?=$VERSION['theVersion']?>">Voir le changelog</a></p>
                    </div>
                </div>

                <div class="changelog">
                    <p><?=$VERSION['changeLog']?></p>
                </div>

            </article>
        <?php } ?>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>