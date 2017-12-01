<?php
/**
 * Plugin Name:     Post Tag Checklist
 * Plugin URI:      https://github.com/timothyjensen/post-tag-checklist
 * Description:     Replace the standard post tag meta box on the post edit screen with a category-style checklist.
 * Author:          Tim Jensen
 * Author URI:      https://www.timjensen.us
 * Text Domain:     post-tag-checklist
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         TimJensen\PostTagChecklist
 */

namespace TimJensen\PostTagChecklist;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! is_admin() ) {
	return;
}

require_once __DIR__ . '/src/Walker_Post_Tag_Checklist.php';
require_once __DIR__ . '/src/functions/functions.php';
