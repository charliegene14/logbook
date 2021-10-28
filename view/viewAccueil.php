<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/controller/viewAccueil.php'; ?>

<section id="viewAccueil">
	<h1 class="title-section">Bienvenue.</h1>

	<div class="content-section">

			<article id="tools-with-hours">
				<h2>Ce que j'utilise et le temps passé...</h2>
				<h3>...uniquement via les projets ici présents...</h3>

				<div class="swiper-hours">

					<div class="swiper-wrapper">
					<?php foreach ($tools as $tool): ?>
						<div class="swiper-slide">
							<img src="/public/img/tools/<?= $tool['idTool']?>.svg" alt="<?= $tool['nameTool'] ?>"></img>
							<p><?= $regex->digitTime($dbTools->getHoursInTool($tool['idTool'])); ?>.</p>
							<p class='name'><?= $tool['nameTool'] ?>.</p>
						</div>
					<?php endforeach; ?>
					</div>

					<div class="swiper-button-prev-hours swiper-button-prev"></div>
					<div class="swiper-button-next-hours swiper-button-next"></div>
				</div>

				<p style="font-weight: bold; text-indent: 2rem;">( pour comprendre comment je calcule, c'est <a href="/#!/page/presentation/">par ici</a>. )</p>
			</article>
			
			<article id="tools-no-hours">
				<h2>...et bien d'autres !</h2>
				<h3>...sans compter les cours, lectures, vidéos, et activités annexes.</h3>

				<div class="swiper-toolsno">

					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<img src="/public/img/tools/svg-logos/sass.svg" alt="sass"></img>
							<p class='name'>SASS.</p>
						</div>

						<div class="swiper-slide">
							<img src="/public/img/tools/svg-logos/jquery.svg" alt="jquery"></img>
							<p class='name'>jQuery.</p>
						</div>
							
						<div class="swiper-slide">
							<img src="/public/img/tools/svg-logos/wordpress.svg" alt="wordpress"></img>
							<p class='name'>Wordpress.</p>
						</div>

						<div class="swiper-slide">
							<img src="/public/img/tools/svg-logos/woocommerce.svg" alt="woocommerce"></img>
							<p class='name'>WooCommerce.</p>
						</div>

						<div class="swiper-slide">
							<img src="/public/img/tools/svg-logos/chartjs.svg" alt="chartjs"></img>
							<p class='name'>ChartJS.</p>
						</div>

						<div class="swiper-slide">
							<img src="/public/img/tools/svg-logos/swiper.svg" alt="swiper"></img>
							<p class='name'>Swiper.</p>
						</div>

						<div class="swiper-slide">
							<img src="/public/img/tools/svg-logos/github.svg" alt="github"></img>
							<p class='name'>GitHub.</p>
						</div>

						<div class="swiper-slide">
							<img src="/public/img/tools/svg-logos/ubuntu.svg" alt="ubuntu"></img>
							<p class='name'>Ubuntu.</p>
						</div>

						<div class="swiper-slide">
							<img src="/public/img/tools/svg-logos/gimp.svg" alt="gimp"></img>
							<p class='name'>GIMP.</p>
						</div>

					</div>

					<div class="swiper-button-prev-toolsno swiper-button-prev"></div>
					<div class="swiper-button-next-toolsno swiper-button-next"></div>
				</div>
			</article>

			<article id="trusted">
				<h2>Ils m'ont fait confiance.</h2>

				<div class="swiper-trusted">

					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<img class="trusted-icon" src="/public/img/tools/svg-logos/msv2.png" alt="MSV"></img>
						</div>
						<div class="swiper-slide">
							<img class="trusted-icon" src="/public/img/tools/svg-logos/msv2.png" alt="MSV"></img>
						</div>
					</div>

					<div class="swiper-button-prev-trusted swiper-button-prev"></div>
					<div class="swiper-button-next-trusted swiper-button-next"></div>
				</div>

			</article>

	</div>

</section>