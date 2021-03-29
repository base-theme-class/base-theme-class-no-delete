<?php
/*
+----------------------------------------------------------------------
| Copyright (c) 2018,2019,2020 Genome Research Ltd.
| This is part of the Wellcome Sanger Institute extensions to
| wordpress.
+----------------------------------------------------------------------
| This extension to Worpdress is free software: you can redistribute
| it and/or modify it under the terms of the GNU Lesser General Public
| License as published by the Free Software Foundation; either version
| 3 of the License, or (at your option) any later version.
|
| This program is distributed in the hope that it will be useful, but
| WITHOUT ANY WARRANTY; without even the implied warranty of
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
| Lesser General Public License for more details.
|
| You should have received a copy of the GNU Lesser General Public
| License along with this program. If not, see:
|     <http://www.gnu.org/licenses/>.
+----------------------------------------------------------------------

# Author         : js5
# Maintainer     : js5
# Created        : 2018-02-09
# Last modified  : 2018-02-12

 * @package   BaseThemeClass/NoDelete
 * @author    JamesSmith james@jamessmith.me.uk
 * @license   GLPL-3.0+
 * @link      https://jamessmith.me.uk/base-theme-class/
 * @copyright 2018 James Smith
 *
 * @wordpress-plugin
 * Plugin Name: Website Base Theme Class - No delete
 * Plugin URI:  https://jamessmith.me.uk/wordpress/base-theme-class-no-delete/
 * Description: Disables the ability to delete objects once enabled.
 * Version:     1.0.0
 * Author:      James Smith
 * Author URI:  https://jamessmith.me.uk/
 * Text Domain: base-theme-class-locale
 * License:     GNU Lesser General Public v3
 * License URI: https://www.gnu.org/licenses/lgpl.txt
 * Domain Path: /lang
*/

namespace BaseThemeClass;

class NoDelete {
//======================================================================
//
// Remove ability to delete
//
//----------------------------------------------------------------------
//
// Add $this->remove_ability_to_delete() in sub-class initialization
// to make sure ALL users cannot delete
//
// [disable_delete is the function which does the work and is called at
//  the init phase]
//
//======================================================================

  function __construct() {
    add_action( 'init', [ $this, 'disable_delete' ] );
  }

  function disable_delete( ) {
    $x = new WP_Roles();
    $T = $x->roles;
    foreach( $T as $role_name => $role_info ) {
      $r = get_role( $role_name );
      foreach( array_filter(
        $role_info['capabilities'],
        function( $k ) {
          return substr($k,0,7) == 'delete_' &&
                  $k != 'delete_themes' &&
                  $k != 'delete_plugins' &&
                ;
        }, ARRAY_FILTER_USE_KEY
      ) as $cap => $_) {
        $r->remove_cap( $cap );
      }
    }
  }
}