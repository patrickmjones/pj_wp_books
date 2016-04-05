<?php

get_header(); // Loads the header.php template. ?>

	<div id="content" class="content">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h1>
				<div class="entry-meta">
					<?php 
						$product_id = get_field('product_id', get_the_ID());
						if($product_id) {
							echo '<strong>Product ID</strong>: '.$product_id.'<br />';
						}
						$platform_id = get_field('platform', get_the_ID());
						if($platform_id) {
							$term = get_term( $platform_id, 'videogame_platform');
							echo '<strong>Platform</strong>: '.$term->name.'<br />';
						}
						$developer_id = get_field('developer', get_the_ID());
						if($developer_id) {
							$term = get_term( $developer_id, 'videogame_developer');
							echo '<strong>Developer</strong>: '.$term->name.'<br />';
						}
						$publisher_id = get_field('publisher', get_the_ID());
						if($publisher_id) {
							$term = get_term( $publisher_id, 'videogame_publisher');
							echo '<strong>Publisher</strong>: '.$term->name.'<br />';
						}

						$has_manual = get_field('has_manual', get_the_ID());
						if($has_manual) {
							echo '<strong>Has Manual</strong>: Yes<br />';
						} else {
							echo '<strong>Has Manual</strong>: No<br />';
						}

						$is_complete = get_field('is_complete', get_the_ID());
						if($has_manual) {
							echo '<strong>Is Complete</strong>: Yes<br />';
						} else {
							echo '<strong>Is Complete</strong>: No<br />';
						}

						$reference_link = get_field('reference_link', get_the_ID());
						if($reference_link) {
							echo '<style>.embed-wrap iframe { margin: 1em 0; height: 400px;}</style>';
							echo '<a class="embedly-card" href="'.$reference_link.'">'.get_the_title().'</a><script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>';
						}
					?>
				</div>
				<div class="entry-summary">
					<?php the_content(); ?>
				</div>
			</div>
			<?php /*
			<script type="application/ld+json">
				{
				  "@context" : "http://schema.org",
				  "@type" : "Review",
				  "author" : {
				    "@type" : "Person",
				    "name" : "<?php the_author(); ?>",
				    "sameAs" : "<?php the_author_url(); ?>"
				  },
				  "datePublished" : "<?php the_date("c"); ?>",
				  "description" : "<?php strip_tags(get_the_excerpt(true)); ?>",
				  "itemReviewed" : {
				    "@type" : "Movie",
				    "name" : "<?php the_title(); ?>",
				    "sameAs" : "http://www.imdb.com/title/tt<?php echo $imdbid; ?>/",
				    "director" : {
				      "@type" : "Person",
				      "name" : "<?php echo $meta["director"]; ?>"
				    }
				  },
				  "publisher" : {
				    "@type" : "Organization",
				    "name" : "<?php the_author(); ?>"
				  },
				  "reviewRating" : {
				    "@type" : "Rating",
				    "worstRating" : 1,
				    "bestRating" : 5,
				    "ratingValue" : <?php echo $meta["personalscore"]; ?>
				  },
				  "url" : "<?php the_permalink(); ?>"
				}
			</script>	
			*/ ?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'loop-error' ); ?>

		<?php endif; ?>

		<?php comments_template(); ?>

	</div>
<?php get_footer(); // Loads the footer.php template. ?>

