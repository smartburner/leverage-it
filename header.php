<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Leverage_IT_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">


	<!-- ******************* The Navbar Area ******************* -->
	<header>

		<a class="skip-link screen-reader-text"
		   href="#primary"><?php esc_html_e('Skip to content', 'leverage-it'); ?></a>

		<nav class="navbar navbar-expand-md navbar-dark bg-primary" aria-labelledby="main-nav-label">

			<h2 id="main-nav-label" class="screen-reader-text">
				<?php esc_html_e('Main Navigation', 'leverage-it'); ?>
			</h2>

			<div class="container-fluid">

				<!-- Your site title as branding in the menu -->
				<?php if (!has_custom_logo()) { ?>

					<?php if (is_front_page() && is_home()) : ?>

						<h1 class="navbar-brand mb-0">
							<a rel="home" href="<?php echo esc_url(home_url('/')); ?>" itemprop="url">
								<?php bloginfo('name'); ?>
							</a>
						</h1>

					<?php else : ?>

						<a class="navbar-brand" rel="home" href="<?php echo esc_url(home_url('/')); ?>"
						   itemprop="url"><?php bloginfo('name'); ?></a>

					<?php endif; ?>

					<?php
				} else {
					the_custom_logo();
				}
				?>
				<!-- end custom logo -->

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
						aria-controls="navbarNavDropdown" aria-expanded="false"
						aria-label="<?php esc_attr_e('Toggle navigation', 'leverage-it'); ?>">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!-- The WordPress Menu goes here -->
				<?php
				wp_nav_menu(
						array(
								'theme_location' => 'menu-1',
								'container_class' => 'collapse navbar-collapse',
								'container_id' => 'navbarNavDropdown',
								'menu_class' => 'navbar-nav ms-auto',
								'fallback_cb' => '',
								'menu_id' => 'main-menu',
								'depth' => 2,
								'walker' => new LeverageIT_WP_Bootstrap_Navwalker(),
						)
				);
				?>
			</div><!-- .container -->

		</nav><!-- .site-navigation -->

	</header>
