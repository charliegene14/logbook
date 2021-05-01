<?php $pageTitle = 'Gestion du projet - '.$PROJ['titleProject']; ?>
<?php ob_start(); ?>

<section class="viewProjectUpdate">
    <p><a href="index.php?view=projects">Retourner au gestionnaire de projets</a></p>

    <img src="../public/img/projects/<?=$PROJ['idProject']?>.png" />
    <h1><?=$PROJ['titleProject']?></h1>
    <a href="index.php?view=projectupdate&id=<?=$PROJ['idProject']?>&token=<?=$_SESSION['token']?>&del">Supprimer (!)</a>
    
    <div class="project">
        <div class="infos">
            <h2>Infos:</h2>
            <form method="post" action="index.php?view=projectupdate&id=<?=$PROJ['idProject']?>&token=<?=$_SESSION['token']?>&update" enctype="multipart/form-data">
                <fieldset>
                    <legend>Icône (recommandé: 124x124)</legend>
                    <input type="file" name="icon" />
                </fieldset>

                <fieldset>
                    <legend>Une catégorie peut être associée (facultatif)</legend>
                    <select name="typeCat">
                        <option value="NULL">Aucune catégorie</option>
                        <?while ($CAT = $listCats->fetch()) {?>
                            <option value="<?=$CAT['Type']?>" <?if ($CAT['Type'] == $PROJ['typeCat']){echo'selected';}?>>
                                <?=$CAT['nameCat']?>
                            </option>
                        <?}?>
                    </select>
                </fieldset>

                <fieldset>
                    <legend>Titre</legend>
                        <input type="text" name="titleProject" value="<?=$PROJ['titleProject']?>" required />
                </fieldset>

                <fieldset>
                    <legend>Genre</legend>
                    <input type="text" name="kindProject" value="<?=$PROJ['kindProject']?>" required />
                </fieldset>

                <fieldset>
                    <legend>Plateforme</legend>
                    <input type="text" name="platformProject" value="<?=$PROJ['platformProject']?>" required />
                </fieldset>

                <fieldset>
                    <legend>Date</legend>
                    <input type="date" name="dateProject" value="<?=$PROJ['dateProject']?>" required />
                </fieldset>

                <fieldset>
                    <legend>Preview</legend>
                    <textarea name="previewProject" rows="7" cols="50"><?=$regex->toBBCode($PROJ['previewProject'])?></textarea>
                </fieldset>

                <fieldset>
                    <legend>Fiche</legend>
                    <textarea name="descProject" rows="20" cols="50"><?=$regex->toBBCode($PROJ['descProject'])?></textarea>
                </fieldset>
                
                <input type="hidden" name="oldTitle" value="<?=$PROJ['titleProject']?>" />
                <input type="submit" value="Modifier" />
            </form>
        </div>

        <div class="versions">
            <h2>Versions:</h2>
            <a href="index.php?view=versioninsert&project=<?=$PROJ['idProject']?>">Ajouter une version</a>
            <? while ($VERSION = $listVersions->fetch()) { ?>
                <p>
                    <a href="index.php?view=versionupdate&id=<?=$VERSION['idVersion']?>">
                        <?=$VERSION['theVersion']?>
                    </a>
                    (<?=$regex->date($VERSION['dateVersion'])?>)
                </p>
            <? } ?>
        </div>
    </div>
</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require('template.php'); ?>