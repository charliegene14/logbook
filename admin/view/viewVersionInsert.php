<?php $pageTitle = 'Ajouter une version - projet '; ?>
<?php ob_start(); ?>

<section class="viewVersionInsert">
    <p><a href="index.php">Retourner au panneau principal</a></p>
    <h1>Ajout d'une version à <?= $PROJ['titleProject']?></h1>

    <form method="post" action="index.php?view=versioninsert&project=<?=$PROJ['idProject']?>&token=<?=$_SESSION['token']?>&insert" enctype="multipart/form-data">
        <fieldset>
            <legend>Archive ZIP</legend>
            <input type="file" name="zip" required/>
        </fieldset>

        <fieldset>
            <legend>Date</legend>
            <input type="date" name="dateVersion" required />
        </fieldset>

        <fieldset>
            <legend>Version</legend>
            <input type="text" name="theVersion" required />
        </fieldset>

        <fieldset>
            <legend>Changelog</legend>
            <textarea name="changeLog" rows="30" cols="50" required></textarea>
        </fieldset>
        
        <input type="submit" value="Modifier" />
    </form>
</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require('template.php'); ?>