<?php
gp_title( sprintf( __( 'Projects translated to %s &lt; GlotPress' ),  esc_html( $locale->english_name ) ) );
gp_breadcrumb( array(
	gp_link_get( '/languages', __( 'Locales' ) ),
	esc_html( $locale->english_name )
) );
gp_tmpl_header();
?>

	<h2><?php printf( __( 'Active Projects translated to %s' ), esc_html( $locale->english_name ) ); ?></h2>
<?php
if ( empty( $projects_data ) ) {
	_e( 'No active projects found.' );
}
?>
	<div class="locale-project">
		<h3><?php _e( 'Overall stats'); ?></h3>
		<table class="locale-sub-projects">
			<thead>
			<tr>
				<th><?php _e( 'Translated' ); ?></th>
				<th><?php _e( 'Fuzzy' ); ?></th>
				<th><?php _e( 'Untranslated' ); ?></th>
				<th><?php _e( 'Waiting' ); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			global $gpdb;
			$results = $gpdb->get_results( sprintf( "SELECT ts.name, tl.status, COUNT( tl.original_id ) AS number FROM gp_translations tl, gp_originals o, gp_translation_sets ts WHERE o.id = tl.original_id AND o.status = '+active' AND ts.id = tl.translation_set_id AND ts.locale = '%s' GROUP BY tl.status ORDER BY number DESC", $locale->slug ) );
			foreach ( $results as $result ) {
				$overall_stats[ $result->status ] = $result->number;
			}
			$overall_stats[ 'untranslated' ] = $gpdb->get_var( sprintf( "SELECT COUNT(id) AS total FROM gp_originals WHERE status = '+active' AND project_id IN ( SELECT project_id FROM gp_translation_sets WHERE locale = '%s' )", $locale->slug ) ) - $overall_stats['current'];
			?>
			<tr>
				<td class="stats translated"><?php echo $overall_stats['current']; ?></td>
				<td class="stats fuzzy"><?php echo '&nbsp;'; ?></td>
				<td class="stats untranslated"><?php echo $overall_stats['untranslated']; ?></td>
				<td class="stats waiting"><?php echo $overall_stats['waiting']; ?></td>
			</tr>
		</tbody>
	</table>
</div>
<?php foreach ( $projects_data as $project_id => $sub_projects ) : ?>
	<div class="locale-project">
		<h3><?php echo ( $projects[$project_id]->name );?></h3>
		<table class="locale-sub-projects">
			<thead>
			<tr>
				<th class="header" <?php if (count($sub_projects)>1 ) echo 'rowspan="'. count($sub_projects) . '"';?>><?php if (count($sub_projects)>1 ) _e( 'Project' ); ?></th>
				<th class="header"><?php _e( 'Set / Sub Project' ); ?></th>
				<th><?php _e( 'Translated' ); ?></th>
				<th><?php _e( 'Fuzzy' ); ?></th>
				<th><?php _e( 'Untranslated' ); ?></th>
				<th><?php _e( 'Waiting' ); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ( $sub_projects as $sub_project_id => $data ) : ?>
				<tr>
				<th class="sub-project" rowspan="<?php echo count( $data['sets'] );  ?>">
					<?php if (count($sub_projects)>1  ) echo esc_html( $projects[$sub_project_id]->name ); ?>
					<div class="stats">
						<div class="total-strings"><?php printf( __( '%d strings' ), $data['totals']->all_count ); ?></div>
						<div class="percent-completed"><?php printf( __( '%d%% translated' ), $data['totals']->current_count ? floor( absint($data['totals']->current_count ) / absint( $data['totals']->all_count ) * 100 ) : 0 ); ?></div>
					</div>
				</th>
				<?php foreach ( $data['sets'] as $set_id => $set_data ) : ?>
					<?php  reset( $data['sets'] );	if ( $set_id !== key($data['sets']) ) echo '<tr>'; ?>
					<td class="set-name">
						<strong><?php gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ) ), $set_data->name ); ?></strong>
						<?php if ( $set_data->current_count && $set_data->current_count >= $set_data->all_count * 0.9 ):
							$percent = floor( $set_data->current_count / $set_data->all_count * 100 );
							?>
							<span class="bubble morethan90"><?php echo $percent; ?>%</span>
						<?php endif;?>
					</td>
					<td class="stats translated"><?php gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ), array('filters[translated]' => 'yes', 'filters[status]' => 'current') ), absint( $set_data->current_count ) ); ?></td>
					<td class="stats fuzzy"><?php gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ), array('filters[status]' => 'fuzzy' ) ), absint( $set_data->fuzzy_count ) ); ?></td>
					<td class="stats untranslated"><?php gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ), array('filters[status]' => 'untranslated' ) ), absint( $set_data->all_count ) -  absint( $set_data->current_count ) ); ?></td>
					<td class="stats waiting"><?php gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ), array('filters[translated]' => 'yes', 'filters[status]' => 'waiting') ), absint( $set_data->waiting_count ) ); ?></td>
					</tr>
				<?php endforeach; //sub project slugs ?>
				</tr>
			<?php endforeach;  //sub projects ?>
			</tbody>
		</table>
	</div>
<?php endforeach; //top projects ?>

	<p class="actionlist secondary">
		<?php gp_link( '/projects', __('All projects') ); ?>
	</p>

<?php gp_tmpl_footer();
