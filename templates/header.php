<?php
wp_enqueue_style( 'base' );
wp_enqueue_style( 'open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:600,400', false, 'all' );
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<title><?php echo gp_title(); ?></title>
		<?php gp_head(); ?>

		<style>
		body, html,
		.gp-content,
		.gp-content textarea,
		.gp-content input {
			font-family: "Open Sans", "Helvetica", "Arial", sans-serif;
		}
		h1 a.logo {
			width: 328px;
			height: 60px;
		}
		h1 span.breadcrumb {
			margin-top: 24px;
		}
		.alignleft, .column {
			float: left !important;
		}
		.alignright {
			float: right !important;
		}
		.aligncenter {
			display: block;
			margin: 0 auto;
		}
		.clear {
			clear: both;
		}
		.column {
			width: 47%;
			margin-right: 3%;
		}
		.user-card dl.user-info dd, .user-card dl.user-info dt {
			float: left;
			margin: 0 0 5px 0;
		}
		.user-card dl.user-info dt {
			margin: 0;
			font-size: 14px;
			clear: both;
			width: 125px;
		}
		.user-card dl.user-info dd {
			width: 275px;
		}
		.user-card .user-avatar {
			width: 120px;
			height: 120px;
		}
		#projects_box {
			float: right; 
			width: 320px; 
			margin: 10px 5%; 
			padding: 10px 20px; 
			background-color: #f9f9f9;
		}
		textarea.profile {
			width: 500px;
			height: 80px;
		}
		.translation-sets .even .stats.complete50, .translation-sets .even .stats.complete60, .translation-sets .even .stats.complete70, .translation-sets .even .stats.complete80 {
			background-color: rgb(144, 238, 144);
			color: white;
		}
		.translation-sets .odd .stats.complete50, .translation-sets .odd .stats.complete60, .translation-sets .odd .stats.complete70, .translation-sets .odd .stats.complete80 {
			background-color: rgb(144, 200, 144);
			color: white;
		}
		
		</style>

	</head>
	<body <?php body_class(); ?>>
	<script type="text/javascript">document.body.className = document.body.className.replace('no-js','js');</script>
		<div class="gp-content">
	    <div id="gp-js-message"></div>
		<h1>
			<a class="logo" href="<?php echo gp_url( '/' ); ?>" rel="home">
				<?php echo file_get_contents( '/var/www/translate.yoast.com/plugins/templates/images/Yoast_Translate_horizontal.embed.svg' ); ?>
			</a>
			<?php echo gp_breadcrumb(); ?>
			<span id="hello">
			<?php
			if (GP::$user->logged_in()):
				$user = GP::$user->current();

				printf( __('Hi, %s.'), '<a href="'.gp_url( '/profile' ).'">'.$user->user_login.'</a>' );
				?>
				<a href="<?php echo gp_url('/logout')?>"><?php _e('Log out'); ?></a>
			<?php elseif( ! GP_INSTALLING ): ?>
				<strong><a href="<?php echo gp_url_login(); ?>"><?php _e('Log in'); ?></a></strong>
				| <strong><a href="/register/"><?php _e('Register'); ?></a></strong>
			<?php endif; ?>
			<?php do_action( 'after_hello' ); ?>
			</span>
			<div class="clearfix"></div>
		</h1>
		<div class="clear after-h1"></div>
		<?php if (gp_notice('error')): ?>
			<div class="error">
				<?php echo gp_notice( 'error' ); //TODO: run kses on notices ?>
			</div>
		<?php endif; ?>
		<?php if (gp_notice()): ?>
			<div class="notice">
				<?php echo gp_notice(); ?>
			</div>
		<?php endif; ?>
		<?php do_action( 'after_notices' ); ?>
