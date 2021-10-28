<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/controller/viewPosts.php';?>

<section id="posts">

	<div class="title-section">
		<h1>Articles.</h1>

		<aside class="sort">
			<form id="posts-sorting">

				<select onchange="posts_submit()" name="type" id="type">
					<option value="">Toute catégorie</option>

					<?php
					if ($queryTypes != null) {
						while ($CAT = $queryTypes->fetch()) {
							echo '<option value='.$CAT['Type'];

							if ($type == $CAT['Type']) {
								echo ' selected';
							}

							echo '>'.$CAT['nameCat'].'</option>';
						}
					}
					?>
				</select>

				<select onchange="posts_submit()" name="work" id="work">
					<option value="">Toute partie de travail</option>

					<?php
					if ($queryWorks != null) {
						while ($WORK = $queryWorks->fetch()) {
							echo '<option value='.$WORK['idWork'].'';

							if ($work == $WORK['idWork']){
								echo ' selected';
							}
							echo '>'.$WORK['nameWork'].'</option>';
						}
					}
					?>
				</select>

				<select onchange="posts_submit()" name="tool" id="tool">
					<option value="">Tous les outils</option>

					<?php
					if ($queryTools != null) {
						while ($TOOL = $queryTools->fetch()) {
							echo '<option value='.$TOOL['idTool'];

							if ($tool == $TOOL['idTool']) {
								echo ' selected';
							}
							echo '>'.$TOOL['nameTool'].'</option>';
						}
					}
					?>
				</select>
			</form>
		</aside>

	</div>
	

	<div class="content-section">
		<?php foreach ($posts as $POST) : ?>
			<article id="<?=$POST['idPost']?>">
				<div class="blur-bg"></div>
				<h2 class="titlePost"><a href="/#!/posts/<?=$POST['idPost']?>"><?=$POST['titlePost']?></a></h2>

				<aside class="infoPost">
					<p>
						Dans <a style="color: <?=$POST['colorCat']?>" href="/#!/posts?type=<?=$POST['Type']?>"><b><?=$POST['nameCat']?></b></a>
					</p>
						
					<div class="svg-calendar"></div>

					<p>
						<?=$regex->date($POST['datePost'])?>
					</p>
				</aside>

				<div class="previewPost">
					<p>
						<?php if (strlen($regex->previewPost($POST['contentPost'])) > $MAX_LENGTH): ?>
							<?php echo substr($regex->previewPost($POST['contentPost']), 0, $MAX_LENGTH); ?>
							[...].
					</p>
							<a class="button" href="/#!/posts/<?= $POST['idPost']; ?>">Lire la suite</a>
						<?php else: ?>
							<?php echo ($regex->previewPost($POST['contentPost'])); ?>
					</p>
							<a class="button" href="/#!/posts/<?= $POST['idPost']; ?>">Voir l'article</a>
						<?php endif;?>
				</div>
			</article>
		<?php endforeach; ?>

		<div class="pagination">
			<?php $filteredPosts->getPagination($_GET['pg']); ?>
		</div>
	</div>
</section>

<script type='text/javascript'>
	document.title = 'Articles.'
</script>
<script type="text/javascript" src="/public/js/viewPosts.js"></script>