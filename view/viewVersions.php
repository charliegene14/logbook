<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/controller/viewVersions.php'; ?>

<section id="versions">

    <div class="title-section">
		<img src="public/img/projects/<?=$PROJ['idProject']?>.png" alt="<?=$PROJ['titleProject']?>" />
        <h1 style="color: <?=$PROJ['colorCat']?>"><?=$PROJ['titleProject']?>.</h1>
    </div>

    <div id="list-versions" class="content-section">
        <h2>Historique des versions.</h2>
        <?php while ($VERSION = $listVersions->fetch()): ?>
            <article class="version" id="<?=$VERSION['theVersion']?>">

                <div class="line">

                    <div class="cel theVersion">
                        <p><?=$VERSION['theVersion']?></p>
                    </div>

                    <div class="cel download">
                        <p><a class="button" href="public/files/<?=$PROJ['titleProject']?>/versions/<?=$VERSION['theVersion']?>.zip">
                            Télécharger.
                        </a></p>
                    </div>

                    <div class="cel date">
                        <p><?= $regex->date($VERSION['dateVersion'])?></p>
                    </div>

                    <div class="cel targetChangelog">
                        <p class="button">Changelog.</p>
                    </div>
                </div>

                <div class="changelog">
                    <div class="changelog-content"><?=$VERSION['changeLog']?></p>
                </div>

            </article>
        <?php endwhile; ?>
</section>

<script>
    document.title = 'Versions: <?= $PROJ['titleProject']?>.';
</script>
<script type="text/javascript" src="/public/js/viewVersions.js"></script>