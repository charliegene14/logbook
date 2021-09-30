<header id="menu">

<div id="menu-content">

    <h1><a href="#!"><?= $info->getContent('Head') ?></a></h1>

    <nav>
        <ul>

        <?php while ($MENU = $navigation->fetch()): ?>

            <li><a href="<?=$MENU['linkNav']?>"><?=$MENU['nameNav']?></a>

            <?php if ($MENU['nameNav'] == 'Articles'): ?>

                <ul>

                <?php while($MENU_CAT = $categories->fetch()): ?>
                    <li><a href="index.php?view=posts&amp;type=<?=$MENU_CAT['Type']?>"><?=$MENU_CAT['nameCat']?></a></li>
                <?php endwhile; ?>

                </ul>
            <?php endif; ?>

            <?php if ($MENU['nameNav'] == 'Projets' || $MENU['nameNav'] == 'Portfolio' || $MENU['nameNav'] == 'Folio'): ?>

                <ul>

                <?php while($MENU_PROJ = $projects->fetch()): ?>
                    <li><a href="index.php?view=fullproject&amp;id=<?=$MENU_PROJ['idProject']?>"><?=$MENU_PROJ['titleProject']?></a></li>
                <?php endwhile; ?>

                </ul>
            <?php endif; ?>
                                        
            </li>

        <?php endwhile; ?>

        </ul>	
    </nav>

    <div id="footer-menu"><?= $info->getContent('Foot') ?></div>
</div>

<div id="menu-opener">
    <div id="menu-image"></div>
</div>

</header>