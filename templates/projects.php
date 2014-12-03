<?php
gp_title( __('Projects &lt; GlotPress') );
gp_tmpl_header();
?>

	<h2><?php _e('Projects'); ?></h2>

	<div id="projects_box">
		<?php echo file_get_contents( '/var/www/translate.yoast.com/plugins/templates/images/Yoast_Translate.embed.svg' ); ?>
		<p>This is the home of the Yoast Translate project. Here we translate all Yoast's WordPress Plugins and Themes.</p>
		<p> If you're new, you can <a href="/register/">register here</a> and start translating. We usually encourage people to start translating on one of our free plugins, if you're doing well we'll happily provide you a copy of one of the premium plugins to translate it.</p> 
	</div>
	<ul>
		<?php foreach ( $projects as $project ): ?>
			<li><?php gp_link_project( $project, esc_html( $project->name ) ); ?> <?php gp_link_project_edit( $project, null, array( 'class' => 'bubble' ) ); ?></li>
		<?php endforeach; ?>
	</ul>

	<p class="actionlist secondary">
		<?php if ( GP::$user->current()->can( 'write', 'project' ) ): ?>
			<?php gp_link( gp_url_project( '-new' ), __('Create a New Project') ); ?>  &bull;&nbsp;
		<?php endif; ?>

		<?php gp_link( gp_url( '/languages' ), __('Projects by language') ); ?>
	</p>

<?php gp_tmpl_footer();
