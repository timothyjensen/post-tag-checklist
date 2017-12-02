<?php
/**
 * Initialize Post Tag Checklist.
 *
 * @package     TimJensen\PostTagChecklist
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.1.0
 */

namespace TimJensen\PostTagChecklist;

add_filter( 'register_taxonomy_args', __NAMESPACE__ . '\\change_post_tag_registration_args', 20, 2 );
/**
 * Filters the arguments for registering the 'post_tag' taxonomy.
 *
 * @param array  $args     Array of arguments for registering the taxonomy.
 * @param string $taxonomy Taxonomy name.
 */
function change_post_tag_registration_args( $args, $taxonomy ) {
	// create_initial_taxonomies() fires once before plugins are loaded and once
	// on the 'init' hook. We only want to modify the latter.
	if ( ! did_action( 'init' ) || 'post_tag' !== $taxonomy ) {
		return $args;
	}

	/**
	 * Allow post tag checkbox to be overridden.
	 *
	 * @param bool Whether or not to render the post tag checklist.
	 * @param array  $args     Array of arguments for registering the taxonomy.
	 * @param string $taxonomy Taxonomy name.
	 */
	$render_checklist = apply_filters( 'post_tag_checklist_toggle', true, $args, $taxonomy );

	if ( ! $render_checklist ) {
		return $args;
	}

	if ( false === $args['hierarchical'] ) {
		add_filter( 'post_edit_category_parent_dropdown_args', __NAMESPACE__ . '\\remove_parent_dropdown_from_post_tag_meta_box' );
	}

	$args['meta_box_cb'] = 'post_categories_meta_box';

	return $args;
}

/**
 * Remove parent term dropdown from the post tag meta box since 'post_tags' are not hierarchical.
 *
 * @param array $parent_dropdown_args Arguments passed to `wp_dropdown_categories()`.
 * @return mixed
 */
function remove_parent_dropdown_from_post_tag_meta_box( $parent_dropdown_args ) {
	if ( 'post_tag' !== $parent_dropdown_args['taxonomy'] ) {
		return $parent_dropdown_args;
	}

	// Do not echo the parent dropdown.
	$parent_dropdown_args['echo'] = 0;

	return $parent_dropdown_args;
}

add_filter( 'wp_terms_checklist_args', __NAMESPACE__ . '\\use_post_tag_checklist_walker' );
/**
 * Add the post tag checklist walker to the arguments.
 *
 * @param array $args Array of arguments.
 * @return array
 */
function use_post_tag_checklist_walker( $args ) {
	if ( 'post_tag' !== $args['taxonomy'] ) {
		return $args;
	}

	$args['walker'] = new Walker_Post_Tag_Checklist();

	return $args;
}
