<?php
get_header(); ?>

	<div id="content" class="hfeed content">
		<div class="book-feed">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('book-pin'); ?>>
				<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); ?>
				<a href="<?php echo $large_image_url[0]; ?>" class="" rel="lightbox">
					<?php the_post_thumbnail('large', array('class' => '')); ?>
				</a>
				<p>
					<?php 
						the_title(); 
						$origTitle = get_field('original_title');
						if($origTitle) {
							echo " (".$origTitle.")";
						}

						$year = get_field('year');
						if($year) {
							echo ", ".$year;
						}
				
						$language_id = get_field('language');
						if($language_id) {
							$term = get_term( $language_id, 'book_language');
							echo "<br/>Language: ".$term->name;
						}
						$coverArtist = get_field('cover_artist');
						if($coverArtist) {
							echo "<br/>Artist: ".$coverArtist;
						}
					?>
				</p>
			</div>

			<?php comments_template( '', true ); ?>

			<?php endwhile; ?>
		</div>
			<div class="navigation-links">
				<!-- now show the paging links -->
				<div class="alignleft"><?php previous_posts_link('Previous Entries'); ?></div>
				<div class="alignright"><?php next_posts_link('Next Entries'); ?></div>
			</div>

		<?php else: ?>

			<p class="no-data">
				<?php _e('Sorry, no page matched your criteria.', 'hybrid'); ?>
			</p><!-- .no-data -->

		<?php endif; ?>

	</div><!-- .content .hfeed -->
	<style>
		.book-feed {
			-webkit-column-count: 3;
			-webkit-column-gap: 10px;
			-webkit-column-fill: auto;
			-moz-column-count: 3;
			-moz-column-gap: 10px;
			-moz-column-fill: auto;
			column-count: 3;
			column-gap: 15px;
			column-fill: auto;
		}
		.book-feed:after {
			content:' ';
			display:table;
			clear: both;
		}
		.book-pin,
		.book-pin:last-of-type {
			display: inline-block;
			background: #FEFEFE;
			border: 2px solid #FAFAFA;
			box-shadow: 0 1px 2px rgba(34, 25, 25, 0.4);
			margin: 0 2px 15px;
			-webkit-column-break-inside: avoid;
			-moz-column-break-inside: avoid;
			column-break-inside: avoid;
			padding: 10px;
			padding-bottom: 5px;
			background: -webkit-linear-gradient(45deg, #FFF, #F9F9F9);
			opacity: 1;
	
			-webkit-transition: all .2s ease;
			-moz-transition: all .2s ease;
			-o-transition: all .2s ease;
			transition: all .2s ease;
			display: block;
		}
		
		.book-pin img {
			max-width: 100%;
			opacity: 1;
			display: block;
			margin: 0 auto .4em;
		}
		.book-pin p {
			font-size: 14px;
			margin: 0;
		}

		@media (max-width: 768px) {
			.book-feed {
				-webkit-column-count: 2;
				-moz-column-count: 2;
				column-count: 2;
			}

		}
		@media (max-width: 480px) {
			.book-feed {
				-webkit-column-count: 1;
				-moz-column-count: 1;
				column-count: 1;
			}
		}
	</style>

<?php get_footer(); ?>
