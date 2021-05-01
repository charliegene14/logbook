<?php  $pageTitle = 'Gestion des projets'; ?>
<?php  ob_start(); ?>

<section class="viewProjects">
    <p><a href="index.php">Retourner au panneau principal</a></p>
    <p><a href="index.php?view=projectinsert">Ajouter un projet</a></p>
    
    <?while ($PROJ = $listProj->fetch()) {?>

        <p>
            <b><?=$PROJ['titleProject']?>:</b>
            <a href="index.php?view=projectupdate&id=<?=$PROJ['idProject']?>">Gérer le projet</a>
        </p>

    <?}?>
    
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>