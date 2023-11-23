<?php
/**
 * User administration panel
 *
 * @package WordPress
 * @subpackage Administration
 * @since 1.0.0
 */
/** WordPress Administration Bootstrap */
$admin_php_path = ABSPATH . 'wp-admin/admin.php';
require_once($admin_php_path);

wp_register_script('dxo_peity', plugins_url('/lib/vendor/js/jquery.peity.min.js', __DIR__));

wp_enqueue_style('dxosaas', plugins_url('/css/dxosaas.css', __DIR__));
wp_enqueue_style('font-awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

wp_enqueue_script('dxo_peity', plugins_url('/lib/vendor/js/jquery.peity.min.js', __DIR__));


$currentURL = basename(dirname(__DIR__)) . '%2Fviews%2FDXOoptionsUsers.php';

if (!current_user_can('list_users')) {
    wp_die(
        '<h1>' . __('You need a higher level of permission.') . '</h1>' .
        '<p>' . __('Sorry, you are not allowed to list users.') . '</p>',
        403
    );
}

/*
 * Plugin options
 */
$options = get_option('docxpressoSaaS', array());
$searchUser = false;

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'save')) {
    /*
     * Save configuration
     */

    $edits = array();
    $downloads = array();

    if (isset($_POST['edits'])) {
        $edits = $_POST['edits'];
    }
    if (isset($_POST['downloads'])) {
        $downloads = $_POST['downloads'];
    }
    if (isset($_POST['users'])) {
        $usersModidyArray = $_POST['users'];

        foreach ($usersModidyArray as $userModify) {

            $user_data_array = get_user_meta($userModify, "DXOCapabilities", true);

            if (in_array($userModify, $downloads)) {

                $downloadCap = 1;
            } else {

                $downloadCap = 0;
            }

            if (in_array($userModify, $edits)) {

                $editCap = 1;
            } else {

                $editCap = 0;
            }

            if (empty($user_data_array)) {


                $user_data_array = array(
                    'Edit' => $editCap,
                    'Download' => $downloadCap,
                    'info' => ''
                );

            } else {

                $user_data_array['Edit'] = $editCap;
                $user_data_array['Download'] = $downloadCap;
            }

            $updated = update_user_meta($userModify, 'DXOCapabilities', $user_data_array);

        }
    }

} else if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'search')) {
    // Search user
    $searchUser = true;

    $nameSearch = $_POST['s'];

    $count_args = array(
        'role' => '',
        'fields' => 'all_with_meta',
        'number' => 999999,
        'search' => '*'.$nameSearch.'*',
        'search_columns' => array('user_login', 'user_email')
    );

}

/*
 * We start by doing a query to retrieve all users
 * We need a total user count so that we can calculate how many pages there are
 */
if ($searchUser) {


} else {
    $nameSearch = "";
    $count_args = array(
        'role' => '',
        'fields' => 'all_with_meta',
        'number' => 999999,
    );
}

$user_count_query = new WP_User_Query($count_args);
$user_count = $user_count_query->get_results();

// count the number of users found in the query
$total_users = $user_count ? count($user_count) : 1;

// grab the current page number and set to 1 if no page number is set
$page = isset($_GET['p']) ? $_GET['p'] : 1;

// how many users to show per page
$users_per_page = 20;

// calculate the total number of pages.
$total_pages = 1;
$offset = $users_per_page * ($page - 1);
$total_pages = ceil($total_users / $users_per_page);


// main user query
$args = array(
    'search' => '*'.$nameSearch.'*',
    'search_columns' => array('user_login', 'user_email'),
    // search only for Authors role
    'role' => '',
    // order results by display_name
    'orderby' => 'display_name',
    // return all fields
    'fields' => 'all_with_meta',
    'number' => $users_per_page,
    'offset' => $offset // skip the number of users that we have per page
);

// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($args);

// Get the results
$authors = $wp_user_query->get_results();

$title = __('Users');

?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php echo $title ?>
    </h1>
    <?php
    if (isset($_POST['_wpnonce'])&& wp_verify_nonce($_POST['_wpnonce'], 'save')){
        ?>
        <div class="updated notice"
             id="conf_updated">
            <p><?php _e('The plugin user configuration has been successfully updated.', 'document-data-automation'); ?></p>
        </div>
        <?php
    }
    ?>
    <form action="" method="post">
        <?php wp_nonce_field('search') ?>
        <p class="search-box" style="margin: 10px">
            <label class="screen-reader-text"
                   for="user-search-input"><?php _e('Search user', 'document-data-automation'); ?>:</label>
            <input type="search" id="user-search-input" name="s" value=<?php echo $nameSearch?>>
            <input type="submit" id="search-submit" class="button"
                   value="<?php _e('Search user', 'document-data-automation'); ?>" name="search">
        </p>
    </form>
    <?php
    // check to see if we have users
    if (!empty($authors)) {
    ?>


    <form action="" method="post">
        <?php wp_nonce_field('save') ?>


        <h2 class="screen-reader-text"><?php _e('Users', 'document-data-automation'); ?>:</h2>
        <table class="wp-list-table widefat fixed striped users">
            <thead>
            <tr>
                <th scope="col" id="username" class="manage-column column-username column-primary">
                    <span><?php _e('User Name', 'document-data-automation'); ?></span>
                </th>
                <th scope="col" id="name"
                    class="manage-column column-name"><?php _e('Name', 'document-data-automation'); ?></th>
                <th scope="col" id="email" class="manage-column column-email">
                    <span><?php _e('Email', 'document-data-automation'); ?></span></th>
                <th scope="col" id="role"
                    class="manage-column column-role"><?php _e('Role', 'document-data-automation'); ?></th>
                <th scope="col" id="caps"
                    class="manage-column column-role"><?php _e('Capabilities', 'document-data-automation'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($authors as $author) {

                $roles = ( array )$author->roles;
                $role = $roles[0];

                $user_data_array = get_user_meta($author->ID, "DXOCapabilities", true);

                if (empty($user_data_array)) {
                    // Create for defaults

                    if (isset($options['DXOCapabilitiesEditDefault'])) {
                        $editDefault = $options['DXOCapabilitiesEditDefault'];
                    } else {
                        $editDefault = 0;
                    }

                    if (isset($options['DXOCapabilitiesDownloadDefault'])) {
                        $downloadDefault = $options['DXOCapabilitiesDownloadDefault'];
                    } else {
                        $downloadDefault = 1;
                    }

                    $user_data_array = array(
                        'Edit' => $editDefault,
                        'Download' => $downloadDefault,
                        'info' => ''
                    );
                }

                $DXOUserCapEdit = $user_data_array['Edit'];
                $DXOUserCapDownload = $user_data_array['Download'];

                echo "<tr id='" . $author->ID . "'>";

                echo '<td class="username column-username has-row-actions column-primary" data-colname="Nombre de usuario"><p style="display: none"><input type="checkbox" name="users[]" id="user_' . $author->ID . '" class="' . $role . '" value="' . $author->ID . '" checked></p>' . $author->user_login . '</strong></td>';
                echo '<td class="name column-name" data-colname="Nombre"><span aria-hidden="true">' . $author->first_name . ' ' . $author->last_name . '</span></td>';
                echo '<td class="email column-email" data-colname="Correo electrónico">' . $author->user_email . '</td>';
                echo '<td class="role column-role" data-colname="Perfil">' . $role . '</td>';
                echo '<td class="posts column-role" data-colname="caps">';
                echo '<span>';
                if ($DXOUserCapEdit == 1) {
                    echo '<input type="checkbox" id="chk_edit_' . $author->ID . '" name="edits[]" value="' . $author->ID . '" checked title="'.__('User can edit usage data','document-data-automation').'">';

                } else {
                    echo '<input type="checkbox" id="chk_edit_' . $author->ID . '" name="edits[]" value="' . $author->ID . '" title="'.__('User can edit usage data','document-data-automation').'">';
                }
                _e('Edit', 'document-data-automation');
                echo "</span>&emsp;&emsp;<span>";
                if ($DXOUserCapDownload == 1) {
                    echo '<input type="checkbox" id="chk_download_' . $author->ID . '" name="downloads[]" value="' . $author->ID . '" checked title="'.__('User can download the document','document-data-automation').'" >';
                } else {
                    echo '<input type="checkbox" id="chk_download_' . $author->ID . '" name="downloads[]" value="' . $author->ID . '" title="'.__('User can download the document','document-data-automation').'">';
                }
                _e('Download', 'document-data-automation');
                echo '</span>';
                echo '</td>';
                echo "</tr>";
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th scope="col" id="username" class="manage-column column-username column-primary">
                    <span><?php _e('User Name', 'document-data-automation'); ?></span>
                </th>
                <th scope="col" id="name"
                    class="manage-column column-name"><?php _e('Name', 'document-data-automation'); ?></th>
                <th scope="col" id="email" class="manage-column column-email">
                    <span><?php _e('Email', 'document-data-automation'); ?></span></th>
                <th scope="col" id="role"
                    class="manage-column column-role"><?php _e('Role', 'document-data-automation'); ?></th>
                <th scope="col" id="caps"
                    class="manage-column column-role"><?php _e('Capabilities', 'document-data-automation'); ?></th>
            </tr>
            </tfoot>
        </table>
        <div>
            <p class="submit">
                <button class="button button-primary" type="submit" name="save"><i
                            class="fa fa-save"> </i> <?php _e('Save User Configuration', 'document-data-automation'); ?>
                </button>
            </p>
        </div>

        <?php
        } else {

            echo __("No users found",'document-data-automation');

        }

        // grab the current query parameters
        $query_string = $_SERVER['QUERY_STRING'];

        // The $base variable stores the complete URL to our page, including the current page arg

        // if in the admin, your base should be the admin URL + your page
        $base = get_site_url() . '/wp-admin/admin.php?' . remove_query_arg('p', $query_string) . '%_%';

        // if on the front end, your base is the current page
        //$base = get_permalink( get_the_ID() ) . '?' . remove_query_arg('p', $query_string) . '%_%';
		echo "<div id='userPagination'>";
        echo paginate_links(array(
            'base' => $base, // the base URL, including query arg
            'format' => '&p=%#%', // this defines the query parameter that will be used, in this case "p"
            'prev_text' => __('&laquo; Previous') , // text for previous page
            'next_text' => __('Next &raquo;'), // text for next page
            'total' => $total_pages, // the total number of pages we have
            'current' =>  $page, // the current page
            'end_size' => 1,
            'mid_size' => 5,
        ));
		echo "</div>";
		
		
		

        ?>

    </form>
</div>
<script>

</script>
