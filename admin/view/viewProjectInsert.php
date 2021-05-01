<?php  $pageTitle = 'Ajouter un projet'; ?>
<?php  ob_start(); ?>

<section class="viewProjectInsert">
    <p><a href="index.php?view=projects">Retourner au gestionnaire de projets</a></p>

    <h1>Ajouter un projet (id: <?=$nextID?>)</h1>

        <form method="post" action="index.php?view=projectinsert&token=<?=$_SESSION['token']?>&insert" enctype="multipart/form-data">
            <fieldset>
                <legend>Icône (recommandé: 124x124)</legend>
                <input type="file" name="icon" required/>
            </fieldset>

            <fieldset>
                <legend>Une catégorie peut être associée (facultatif)</legend>
                <select name="typeCat">
                    <option value=NULL>Aucune catégorie</option>
                    <?while ($CAT = $listCats->fetch()) {?>
                        <option value="<?=$CAT['Type']?>">
                            <?=$CAT['nameCat']?>
                        </option>
                    <?}?>
                </select>
            </fieldset>

            <fieldset>
                <legend>Titre</legend>
                    <input type="text" name="titleProject" required />
            </fieldset>

            <fieldset>
                <legend>Genre</legend>
                <input type="text" name="kindProject" required />
            </fieldset>

            <fieldset>
                <legend>Plateforme</legend>
                <input type="text" name="platformProject" required />
            </fieldset>

            <fieldset>
                <legend>Date</legend>
                <input type="date" name="dateProject" required />
            </fieldset>

            <fieldset>
                <legend>Preview (facultatif)</legend>
                <textarea name="previewProject" rows="7" cols="50"></textarea>
            </fieldset>

            <fieldset>
                <legend>Fiche (facultatif)</legend>
                <textarea name="descProject" rows="20" cols="50"></textarea>
            </fieldset>

            <input type="submit" value="Valider" />
        </form>

</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>