<?php  $pageTitle = 'Modifier la version - version - projet'; ?>
<?php  ob_start(); ?>

<section class="viewVersionUpdate">
    <p><a href="index.php">Retourner au panneau principal</a></p>

    <h2>Modifier la version <?=$VERSION['theVersion']?> de <?=$VERSION['titleProject']?>:</h2>
    <a href="index.php?view=versionupdate&id=<?=$VERSION['idVersion']?>&token=<?=$_SESSION['token']?>&del">Supprimer (!)</a>
    <form method="post" action="index.php?view=versionupdate&id=<?=$VERSION['idVersion']?>&token=<?=$_SESSION['token']?>&update" enctype="multipart/form-data">
        <fieldset>
            <legend>Remplacer l'archive ZIP</legend>
            <input type="file" name="zip" />
        </fieldset>

        <fieldset>
            <legend>Date</legend>
            <input type="date" name="dateVersion" value="<?=$VERSION['dateVersion']?>" required />
        </fieldset>

        <fieldset>
            <legend>Version</legend>
            <input type="text" name="theVersion" value="<?=$VERSION['theVersion']?>" required />
        </fieldset>

        <fieldset>
            <legend>Changelog</legend>
            <textarea name="changeLog" rows="30" cols="50" required><?=$regex->toBBCode($VERSION['changeLog'])?></textarea>
        </fieldset>

        <input type="hidden" name="oldVersion" value="<?=$VERSION['theVersion']?>" />
        <input type="submit" value="Modifier" />
    </form>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>