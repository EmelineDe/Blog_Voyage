<?php
require 'connect.php';
require 'function.php';
?>



<section id='extraitArticle' class="ftco-section">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-2">
			<div class="col-md-7 heading-section text-center ftco-animate">
				<h2 class="mb-4">Articles</h2>
			</div>
		</div>
		<div class="row">

			<?php

			$extrait = getExtrait($db);

			foreach ($extrait as $article) { ?>

				<div class="col-md-4">
					<div class="blog-entry ftco-animate">
						<a href="#" class="img" style="background-image: url(<?= $article['imageName'] ?>);"></a>
						<div class="text text-2">
							<span class="big"><?php echo $article['nom_fr_fr'] ?></span>
							<h3 class="mb-4"><a href="#"><?php echo $article['titre']; ?></a></h3>
							<p class="mb-4"><?php

												$ext = substr($article['contenu'], 0, 80);
												$space = strrpos($ext, ' ');
												echo substr($ext, 0, $space) . ' ...';

												?></p>
							<div class="author d-flex align-items-center">
								<div class="ml-3 info">
									<span>
										<?php
											$date = "";
											setlocale(LC_TIME, 'fr_FR.UTF8', 'fra');
											echo utf8_encode(strftime("%A %d %B %G", strtotime($article['dateparution'])));
											?>
									</span>
								</div>
							</div>
							<div class="meta-wrap align-items-center">
								<div class="half">
									<p><a href="blog.php#<?= $article['idarticle']; ?>" class=" btn btn-primary px-3 py-2">
											Lire plus</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>