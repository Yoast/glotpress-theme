<?php

function yst_get_user_meta( $field, $user_id ) {
	global $gpdb;
	$out = $gpdb->get_var( $gpdb->prepare( "SELECT meta_value FROM wp_usermeta WHERE meta_key = %s AND user_id = %d", $field, $user_id ) );
	$out = trim( $out );
	if ( $out && $out !== '' ) {
		return $out;
	} else {
		return false;
	}
}

function yst_get_user_website( $user_id ) {
	global $gpdb;
	$out = $gpdb->get_var( $gpdb->prepare( "SELECT user_url FROM wp_users WHERE ID = %d", $user_id ) );
	$out = trim( $out );
	if ( $out && $out !== '' ) {
		return $out;
	} else {
		return false;
	}
}

if ( yst_get_user_meta( 'hide_profile', $user->id ) ) {
	if ( ! GP::$user->admin() ) {
		header( "Location: " . gp_url('/'), true, 307 );
		exit;
	}
}

gp_title( __('Profile &lt; GlotPress') );
gp_breadcrumb( array( __('Profile') ) );
gp_tmpl_header();

?>

<h2><?php echo $user->display_name; ?></h2>

<div class="column">
	<div class="user-card">
		<img class="user-avatar alignright" src="<?php echo $user->get_avatar( 240 ); ?>" />

		<p class="bio"><?php
			$bio = yst_get_user_meta( 'description', $user->id );
			if ( $bio ) {
				echo esc_html( $bio );
			}
		?></p>

		<dl class="user-info">
			<dt><?php _e( 'Member Since' ); ?></dt>
			<dd><?php echo date( 'M j, Y', strtotime( $user->user_registered ) ); ?></dd>
			<dt><?php _e( 'Role' ); ?></dt>
			<dd><?php 
			if ( $user->admin() ) { 
				printf( __( '%s is an admin on this site.' ), $user->display_name );
			} else {
				vprintf( _n( '%s is a polyglot who contributes to %s',
									'%s is a polyglot who knows %s but also knows %s.', count( $locales ) ),
									array_merge( array( $user->display_name ), array_keys( $locales ) ) ); 
			} 
			?></dd>
			<?php
			$website = yst_get_user_website( $user->id );
			if ( $website ) {
				echo '<dt>' . __( 'Website' ) . '</dt><dd><a rel="nofollow" href="' . esc_attr( $website ) . '">' . esc_html( $website ) . '</a></dd>';
			}

			$slack = yst_get_user_meta( 'slack', $user->id );
			if ( $slack ) {
				echo '<dt>' . __( 'WordPress Slack' ) . '</dt><dd>' . esc_html( $slack ) . '</dd>';
			}

			$twitter = yst_get_user_meta( 'twitter', $user->id );
			if ( $twitter ) {
				echo '<dt>' . __( 'Twitter' ) . '</dt><dd><a rel="nofollow" href="https://twitter.com/' . esc_attr( $twitter ) . '">@' . esc_html( $twitter ) . '</a></dd>';
			}
			?>
		</dl>
	</div>
</div>

<div class="column">
	
	<?php if ( count($permissions) >= 1 ) { ?>
	<img class="aligncenter" alt="Yoast Translate Validator" src="https://translate.yoast.com/plugins/templates/images/Validator_Badge_Yoast_Translate.svg" width="200" />
	<?php } else { ?>
	<img class="aligncenter" alt="Yoast Translate Team Member" src="https://translate.yoast.com/plugins/templates/images/Team_Badge_Yoast_Translate.svg" width="200" />
	<?php } ?>
</div>

<div class="clear"></div>

<div id="profile">
	<div class="recent-projects">
		<h3><?php _e( 'Recent Projects' ); ?></h3>
		<ul>
		<?php foreach ( $recent_projects as $project ): ?>
			<li>
				<p><?php
					echo gp_link_get( $project->project_url, $project->set_name ) . ': ';
					echo gp_link_get( $project->project_url . '?filters[status]=either&filters[user_login]=' . $user->display_name,
						sprintf( _n( '%s contribution', '%s contributions',$project->count ), $project->count ) );
				?></p>
				<p class="ago">
					<?php printf( __( 'last translation about %s ago (UTC)' ), gp_time_since( backpress_gmt_strtotime( $project->last_updated ) ) ); ?>
				</p>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<div class="validates-projects">
		<h3><?php _e( 'Validator to' ); ?></h3>
		
		<?php if ( count($permissions) >= 1 ): ?>
			<ul>
			<?php foreach ( $permissions as $permission ): ?>
				<li>
					<p> <?php echo gp_link_get( $permission->project_url, $permission->set_name ); ?> </p>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p><?php printf( '%s is not validating any projects!', $user->display_name )?></p>
		<?php endif ?>
	</div>
</div>

<?php gp_tmpl_footer();