<?php
/**
 * Class Walker_Post_Tag_Checklist
 *
 * @package     TimJensen\PostTagChecklist
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @link        https://www.timjensen.us
 * @since       0.1.0
 */

namespace TimJensen\PostTagChecklist;

require_once ABSPATH . 'wp-admin/includes/class-walker-category-checklist.php';

/**
 * Class Walker_Post_Tag_Checklist
 *
 * @package TimJensen\PostTagChecklist
 */
class Walker_Post_Tag_Checklist extends \Walker_Category_Checklist {

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output   Used to append additional content (passed by reference).
	 * @param object $category The current term object.
	 * @param int    $depth    Depth of the term in reference to parents. Default 0.
	 * @param array  $args     An array of arguments. @see wp_terms_checklist()
	 * @param int    $id       ID of the current term.
	 */
	public function start_el( &$output, $term, $depth = 0, $args = array(), $id = 0 ) {
		$taxonomy = 'post_tag';
		$name     = 'tax_input[' . $taxonomy . ']';

		$args['popular_tags'] = empty( $args['popular_cats'] ) ? array() : $args['popular_cats'];
		$class                = in_array( $term->term_id, $args['popular_tags'] ) ? ' class="popular-category"' : '';

		$args['selected_tags'] = empty( $args['selected_cats'] ) ? array() : $args['selected_cats'];

		$output .= "\n<li id='{$taxonomy}-{$term->term_id}'$class>" .
		           '<label class="selectit"><input value="' . $term->name . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $term->term_id . '"' .
		           checked( in_array( $term->term_id, $args['selected_tags'] ), true, false ) .
		           disabled( empty( $args['disabled'] ), false, false ) . ' /> ' .
		           esc_html( apply_filters( 'the_tags', $term->name, '', '' ) ) . '</label>';
	}
}
