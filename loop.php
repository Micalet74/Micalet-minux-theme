<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('micalet-item'); ?>>

		<?php if ( has_post_thumbnail()) : ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail('medium_large'); // Tamaño optimizado para grid ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="post-content">
			
			<header class="post-header">
				<span class="post-date"><?php the_time('j F, Y'); ?></span>
				<h2 class="post-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h2>
			</header>

			<div class="post-excerpt">
				<?php 
					// Mostramos un extracto corto de 20 palabras
					echo wp_trim_words( get_the_excerpt(), 20, '...' ); 
				?>
			</div>

			<footer class="post-footer">
				<a href="<?php the_permalink(); ?>" class="leermas_entrada">
					<?php _e( 'Leer más', 'micaletminux' ); ?>
				</a>
			</footer>

		</div>

	</article>

<?php endwhile; ?>

<?php else: ?>

	<article>
		<h2><?php _e( 'Lo sentimos, no hay nada que mostrar.', 'micaletminux' ); ?></h2>
	</article>

<?php endif; ?>