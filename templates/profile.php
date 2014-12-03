<?php
gp_title( __('Profile &lt; GlotPress') );
gp_breadcrumb( array( __('Profile') ) );
gp_tmpl_header();

$per_page = GP::$user->current()->get_meta('per_page');
if ( 0 == $per_page )
	$per_page = 15;

$default_sort = GP::$user->current()->get_meta('default_sort');
if ( ! is_array($default_sort) ) {
	$default_sort = array(
		'by' => 'priority',
		'how' => 'DESC'
	);
}
?>
<h2><?php _e( "Profile" ); ?></h2>
<p>To change the appearance of your name on your <a href="/profile/<?php echo GP::$user->current()->get_meta('user_login'); ?>">public profile</a>, log into the WordPress install <a href="/register/wp-admin/profile.php">here</a> and update your profile there.</p>
<form action="" method="post">
	<table class="form-table">
		<tr>
			<th><label for="per_page"><?php _e( "Number of items per page:" ); ?></label></th>
			<td><input type="number" id="per_page" name="per_page" value="<?php echo $per_page ?>"/></td>
		</tr>
		<tr>
			<th><label for="default_sort[by]"><?php _e("Default Sort By:") ?></label></th>
			<td><?php echo gp_radio_buttons('default_sort[by]',
		array(
			'original_date_added' => __('Date added (original)'),
			'translation_date_added' => __('Date added (translation)'),
			'original' => __('Original string'),
			'translation' => __('Translation'),
			'priority' => __('Priority'),
			'references' => __('Filename in source'),
			'random' => __('Random'),
		), gp_array_get( $default_sort, 'by', 'priority' ) ); ?></td>
		</tr>
		<tr>
			<th><label for="default_sort[how]"><?php _e("Default Sort Order:") ?></label></th>
			<td><?php echo gp_radio_buttons('default_sort[how]',
				array(
					'asc' => __('Ascending'),
					'desc' => __('Descending'),
				), gp_array_get( $default_sort, 'how', 'desc' ) );
			?></td>
		</tr>
		<tr>
			<?php
			$permissions = GP::$user->current()->get_permissions();
					if ( count($permissions) >= 1 ) {
						$badge = '<a title="I validate translations at translate.yoast.com" href="https://translate.yoast.com"><img alt="Yoast Translate Validator" src="https://translate.yoast.com/plugins/templates/images/Validator_Badge_Yoast_Translate.svg" width="200" /></a>';
					} else {
						$badge = '<a title="I translate at translate.yoast.com" href="https://translate.yoast.com"><img alt="Yoast Translate Team Member" src="https://translate.yoast.com/plugins/templates/images/Team_Badge_Yoast_Translate.svg" width="200" /></a>';
					}
			?>
			<th>Badge:</th>
			<td>
				You can use this badge to promote your activity in this translate project!<br>
				<br>
				<textarea class="profile"><?php echo htmlentities( $badge ); ?></textarea><br>
				<br>
				It'll render like this:<br><br>
				<?php echo $badge; ?>
			</td>
		</tr>
	</table>
	<br>
	<input type="submit" name="submit" value="<?php esc_attr_e("Change Settings"); ?>">
</form>

<?php gp_tmpl_footer();