<?php

/**
Plugin Name: Etc Test
Plugin URI: https://github.com/DenisTolmachev/EtcTest
Description: Etcetera Agency - WP Developer - Test Task.
Version: 1.0
Author: Denys Tolmachov
Author URI: https://github.com/DenisTolmachev
 */

// Реєстрація нового типу запису "Об'єкт нерухомості"
function create_property_post_type()
{
    $labels = array(
        'name'               => 'Об\'єкти нерухомості',
        'singular_name'      => 'Об\'єкт нерухомості',
        'menu_name'          => 'Об\'єкти нерухомості',
        'name_admin_bar'     => 'Об\'єкт нерухомості',
        'add_new'            => 'Додати новий',
        'add_new_item'       => 'Додати новий об\'єкт нерухомості',
        'edit_item'          => 'Редагувати об\'єкт нерухомості',
        'new_item'           => 'Новий об\'єкт нерухомості',
        'view_item'          => 'Переглянути об\'єкт нерухомості',
        'all_items'          => 'Всі об\'єкти нерухомості',
        'search_items'       => 'Шукати об\'єкти нерухомості',
        'not_found'          => 'Об\'єкти нерухомості не знайдені',
        'not_found_in_trash' => 'Об\'єкти нерухомості не знайдені в кошику',
        'parent_item_colon'  => 'Батьківський об\'єкт нерухомості:',
        'featured_image'     => 'Зображення об\'єкту нерухомості',
        'set_featured_image' => 'Вибрати зображення об\'єкту нерухомості',
        'remove_featured_image' => 'Видалити зображення об\'єкту нерухомості',
        'use_featured_image'    => 'Використовувати як зображення об\'єкту нерухомості',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'property'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-admin-multisite',
        'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('property', $args);
}
add_action('init', 'create_property_post_type');

//search script
add_action('wp_enqueue_scripts', 'add_my_scripts');
function add_my_scripts()
{
    wp_enqueue_script('etc-task-real-estate', plugins_url('/script.js', __FILE__), array(), '1.0', true);
    wp_enqueue_script('pagination', 'https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.4/jquery.simplePagination.min.js', array(), '', true);
    global $wp_query;
    wp_localize_script('etc-task-real-estate', 'search', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
        'nonce'    => wp_create_nonce('search'),
        'posts' => json_encode($wp_query->query_vars), // передача параметров запроса в формате JSON
        'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
        'max_page' => $wp_query->max_num_pages
    ));
}

// Реєстрація нової таксономії "Район"
function create_district_taxonomy()
{
    $labels = array(
        'name'                       => 'Райони',
        'singular_name'              => 'Район',
        'search_items'               => 'Шукати райони',
        'popular_items'              => 'Популярні райони',
        'all_items'                  => 'Всі райони',
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Редагувати район',
        'update_item'                => 'Оновити район',
        'add_new_item'               => 'Додати новий район',
        'new_item_name'              => 'Назва нового району',
        'separate_items_with_commas' => 'Розділяйте райони комами',
        'add_or_remove_items'        => 'Додати або видалити райони',
        'choose_from_most_used'      => 'Оберіть з найпопулярніших районів',
        'not_found'                  => 'Райони не знайдені',
        'menu_name'                  => 'Райони',
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'district'),
    );

    register_taxonomy('district', 'property', $args);
}
add_action('init', 'create_district_taxonomy');

// Реєстрація шорткоду для відображення блоку фільтра
function realestate_filter_shortcode($atts)
{
    ob_start();
    // Код для відображення блоку фільтра
    // Використовуйте ваш HTML та PHP-код для створення блоку фільтра
    echo '<div>Ваш блок фільтра тут</div>';
    return ob_get_clean();
}
add_shortcode('realestate_filter', 'realestate_filter_shortcode');

// Створення класу віджету для відображення блоку фільтра
class RealestateFilterWidget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'realestate_filter_widget',
            'Фільтр нерухомості',
            array('description' => 'Відображає блок фільтра для об\'єктів нерухомості')
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        echo $args['before_title'] . 'Фільтр нерухомості' . $args['after_title'];
        // Код для відображення блоку фільтра
        // Використовуйте ваш HTML та PHP-код для створення блоку фільтра
?>


        <div class="my-ajax-filter-search">
            <form action="" method="POST" id="form-filter">
                <div class="items column d-flex flex-column">
                    <?php
                    if (function_exists('acf_get_field_groups')) {
                        $acf_field_group = acf_get_field_group(7);
                        $acf_fields = acf_get_fields(7);
                    }
                    $args = array(
                        'post_type' => 'estate',
                        'posts_per_page' => -1,
                        'orderby' => 'DESC'
                    );
                    $estate = new WP_Query($args);

                    $unique_values = array();
                    $rooms_array = array();
                    $floor_mass = array();
                    $ecology_mass = array();

                    if ($estate->have_posts()) : while ($estate->have_posts()) : $estate->the_post(); ?>
                    <?php
                            $floors_value = get_field('floors', get_the_ID());
                            $floors_val = $floors_value['value'];
                            if (!in_array($floors_val, $floor_mass)) {
                                $floor_mass[] = $floors_val;
                            }
                            sort($floor_mass);

                            $ecology_value = get_field('ecology', get_the_ID());
                            $eco_val = $ecology_value['value'];
                            if (!in_array($eco_val, $ecology_mass)) {
                                $ecology_mass[] = $eco_val;
                            }
                            sort($ecology_mass);

                            // repeater fields
                            if (have_rows('inside')) :
                                while (have_rows('inside')) : the_row();
                                    $value = get_sub_field('square', get_the_ID());
                                    if (!in_array($value, $unique_values)) {
                                        $unique_values[] = $value;
                                    }
                                    sort($unique_values);

                                    $rooms_value = get_sub_field('rooms', get_the_ID());
                                    if (!in_array($rooms_value, $rooms_array)) {
                                        $rooms_array[] = $rooms_value;
                                    }
                                    sort($rooms_array);
                                endwhile;
                            endif;
                        endwhile;
                    endif;
                    wp_reset_postdata();
                    ?>
                    <?php foreach ($acf_fields as $fields) { ?>
                        <div class="item-search <?php if ($fields['type'] == 'radio') : echo 'wrap d-flex justify-content-space flex-column';
                                                else : endif; ?>">
                            <?php if ($fields['type'] == 'text') : ?>
                                <label for="<?php echo $fields['name']; ?>"><?php echo $fields['label']; ?></label>
                                <input name="<?php echo $fields['name']; ?>" type="text" id="<?php echo $fields['name']; ?>">
                            <?php elseif ($fields['type'] == 'radio') : ?>
                                <label>Тип будівлі</label>
                                <?php foreach ($fields['choices'] as $value => $label) { ?>
                                    <div class="d-flex flex-13 form-check">
                                        <label for="type_building" class="form-check-label"><?php echo $label; ?></label>
                                        <input name="type_building" type="radio" value="<?php echo $value; ?>" id="type" class="form-check-input">
                                    </div>
                                <?php } ?>
                            <?php elseif ($fields['wrapper']['class'] == 'floor_choose') : ?>
                                <label for="<?php echo $fields['name']; ?>"><?php echo $fields['label']; ?></label>
                                <select name="<?php echo $fields['name']; ?>" id="<?php echo $fields['name']; ?>">
                                    <option value="" disable>Оберіть <?php echo mb_strtolower($fields['label']); ?></option>
                                    <?php foreach ($floor_mass as $fl) { ?>
                                        <option value="<?php echo $fl; ?>"><?php echo $fl; ?></option>
                                    <?php } ?>
                                </select>
                            <?php elseif ($fields['wrapper']['class'] == 'ecology_choose') : ?>
                                <label for="<?php echo $fields['name']; ?>"><?php echo $fields['label']; ?></label>
                                <select name="<?php echo $fields['name']; ?>" id="<?php echo $fields['name']; ?>">
                                    <option value="" disable>Оберіть <?php echo mb_strtolower($fields['label']); ?></option>
                                    <?php foreach ($ecology_mass as $eco) { ?>
                                        <option value="<?php echo $eco; ?>"><?php echo $eco; ?></option>
                                    <?php } ?>
                                </select>
                            <?php elseif ($fields['type'] == 'repeater') : ?>
                                <?php
                                foreach ($fields['sub_fields'] as $field) { ?>
                                    <?php if ($field['type'] == 'text') : ?>
                                        <div class="d-flex flex-13 column">
                                            <label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
                                            <input name="<?php echo $field['name']; ?>" type="text" id="<?php echo $field['name']; ?>">
                                        </div>
                        </div>
                    <?php elseif ($field['type'] == 'number') : ?>
                        <div class="d-flex flex-13 column">
                            <label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?> в м<sup><small>2</small></sup></label>
                            <select name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>">
                                <option value="" disable>Оберіть площу</option>
                                <?php foreach ($unique_values as $value) { ?>
                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                </div>
            <?php elseif ($field['wrapper']['class'] == 'mytest') : ?>
                <div class="item-search wrap d-flex justify-content-space">
                    <label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
                    <select name="" id="<?php echo $field['name']; ?>">
                        <option value="" disable>Оберіть <?php echo mb_strtolower($field['label']); ?></option>
                        <?php foreach ($rooms_array as $rooms) { ?>
                            <option value="<?php echo $rooms; ?>"><?php echo $rooms; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php elseif ($field['type'] == 'radio') : ?>
                <div class="item-search form-check form-switch">
                    <label for="<?php echo $field['name']; ?>" class="form-check-label"><?php echo $field['label']; ?></label>
                    <input type="checkbox" name="<?php echo $field['name']; ?>" value="" class="form-check-input" id="<?php echo $field['name']; ?>">
                </div>
            <?php endif; ?>
        <?php } ?>
    <?php endif; ?>
        </div>
    <?php } ?>
    <div class="controls">
        <input type="submit" id="search" value="Пошук" class="btn" />
        <input type="submit" id="clear" value="Очистити" class="btn" />
    </div>
    </div>
    </form>
    </div>
    <div id="my_search_results">
    <?php

        $args_query = array(
            'post_type' => 'property',
            'post_status' => 'publish',
        );
        $query = new WP_Query($args_query);

        foreach ($query->posts as $post) { ?>
        <div class="etc-item-wrapper">
            <div class="etc-item-title">
                <?php echo $post->post_title; ?>
            </div>
            <div class="etc-item-block">
                
                <div class="etc-item-info">
                    <img class="etc-item-img" src="<?php echo get_field('image', $post->ID); ?>"></img>
                    <div class="etc-item-info-field">
                        <div class="etc-item-info-field-label">Назва будинку:&nbsp;</div>
                        <div class="etc-item-building-info-field-value"><?php echo get_field('build_name', $post->ID); ?></div>
                    </div>
                    <div class="etc-item-info-field">
                        <div class="etc-item-info-field-label">Адреса:&nbsp;</div>
                        <div class="etc-item-building-info-field-value"><?php echo get_field('coordinates', $post->ID); ?></div>
                    </div>
                    <div class="etc-item-info-field">
                        <div class="etc-item-info-field-label">Кількість поверхів:&nbsp;</div>
                        <div class="etc-item-building-info-field-value"><?php echo get_field('floors', $post->ID); ?></div>
                    </div>
                    <div class="etc-item-info-field">
                        <div class="etc-item-info-field-label">Тип будівлі:&nbsp;</div>
                        <div class="etc-item-building-info-field-value"><?php echo get_field('build_type', $post->ID); ?></div>
                    </div>
                    <div class="etc-item-info-field">
                        <div class="etc-item-info-field-label">Екологічність:&nbsp;</div>
                        <div class="etc-item-building-info-field-value"><?php echo get_field('ecology', $post->ID); ?></div>
                    </div>
                </div>
                
                <div class="etc-item-appartment-info-block">
                    <div class="etc-item-appartment-info-title">
                        <h5>Квартира</h5>
                    </div>
                    <div class="etc-item-appartment-info-section">
                        <?php $rooms = get_field('rooms', $post->ID); ?>
                    <img class="etc-item-appartment-img" src="<?php echo $rooms['image']; ?>"></img>
                    <div class="etc-item-appartment-info-row">
                        
                        <div class="etc-item-appartment-info-field">
                        
                        <div class="etc-item-appartment-info-field-label">Площа:&nbsp;</div>
                        <div class="etc-item-appartment-info-field-value"><?php echo $rooms['square']; ?></div>
                    </div>
                    <div class="etc-item-appartment-info-field">
                        <div class="etc-item-appartment-info-field-label">Кількість комнат:&nbsp;</div>
                        <div class="etc-item-appartment-info-field-value"><?php echo $rooms['rooms_number']; ?></div>
                    </div>
                    <div class="etc-item-appartment-info-field">
                        <div class="etc-item-appartment-info-field-label">Балкон:&nbsp;</div>
                        <div class="etc-item-appartment-info-field-value"><?php echo $rooms['balcony']; ?></div>
                    </div>
                    <div class="etc-item-appartment-info-field">
                        <div class="etc-item-appartment-info-field-label">Санвузол:&nbsp;</div>
                        <div class="etc-item-appartment-info-field-value"><?php echo $rooms['bath']; ?></div>
                    </div>
                        
                    </div>
                    
                        
                    </div>
                    
                </div>
                
            </div>
        </div>

<?php   }

        echo $args['after_widget'];
?>
</div>
<?php
    }
}

//AJAX filter
add_action('wp_ajax_my_ajax_filter_search', 'my_ajax_filter_search_callback');
add_action('wp_ajax_nopriv_my_ajax_filter_search', 'my_ajax_filter_search_callback');
// Filter
function my_ajax_filter_search_callback()
{
    header("Content-Type: application/json");

    check_ajax_referer('search', 'nonce');

    $meta_query = array('relation' => 'AND');

    if (isset($_POST['name_house'])) {
        $meta_query[] = array(
            'key' => 'build_name',
            'value' => $_POST['name_house'],
            'compare' => '='
        );
    }

    if (isset($_POST['floors'])) {
        $meta_query[] = array(
            'key' => 'floors',
            'value' => $_POST['floors'],
            'compare' => '='
        );
    }

    if (isset($_POST['coordinate'])) {
        $meta_query[] = array(
            'key' => 'coordinates',
            'value' => $_POST['coordinate'],
            'compare' => '='
        );
    }

    if (isset($_POST['ecology'])) {
        $meta_query[] = array(
            'key' => 'ecology',
            'value' => $_POST['ecology'],
            'compare' => '='
        );
    }


    $square = $_POST['square'];
    if (isset($_POST['square'])) {
        $meta_query[] = array(
            'key' => 'inside_$_square',
            'value' => $square,
            'compare' => '='
        );
    }

    $rooms = $_POST['rooms'];
    if (isset($_POST['rooms'])) {
        $meta_query[] = array(
            'key' => 'inside_$_rooms_number',
            'value' => $rooms,
            'compare' => '='
        );
    }

    $balcony = $_POST['balcony'];
    if (isset($_POST['balcony'])) {
        $meta_query[] = array(
            'key' => 'inside_$_balcony',
            'value' => $balcony,
            'compare' => '='
        );
    }

    $bedroom = $_POST['bedroom'];
    if (isset($_POST['bedroom'])) {
        $meta_query[] = array(
            'key' => 'inside_$_bath',
            'value' => $bedroom,
            'compare' => '='
        );
    }

    $type = $_POST['type_house'];
    if (isset($_POST['type_house'])) {
        $meta_query[] = array(
            'key' => 'build_type',
            'value' => $type,
            'compare' => '='
        );
    }

    $paged = $_POST['page'];

    $search_query = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    $args = array(
        'post_type'      => 'property',
        'posts_per_page' => 5,
        'meta_query' => $meta_query,
        's'              => $search_query,
        'order' => 'ASC',
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    );

    $search_query = new WP_Query($args);
    if (get_query_var('page')) {
        $page = get_query_var('page');
    } else {
        $page = 1;
    }

    if ($search_query->have_posts()) {
        $result = array();
        while ($search_query->have_posts()) {
            $search_query->the_post();
            $repeater_data = array();
            $compared = array();

            if (get_field('rooms')) {
                while (have_rows('rooms')) {
                    the_row();
                    $row++;

                    $square_inside = get_sub_field('square'); //square
                    $rooms_inside = get_sub_field('rooms_number'); // rooms
                    $balcony_inside = "no";
                    if(get_sub_field('balcony')){
                        $balcony_inside = "yes";
                    }
                    $bedroom_inside= "no";
                    if(get_sub_field('balcony')){
                        $bedroom_inside = "yes";
                    }
                    if (
                        $square_inside === $square ||
                        $rooms_inside === $rooms ||
                        $balcony_inside === $balcony ||
                        $bedroom_inside === $bedroom
                    ) {
                        $new_square = get_sub_field_object('square')['value'];
                        $new_image = get_sub_field_object('image')['value']['url'];
                        $new_room = get_sub_field_object('rooms')['value'];
                        $new_balcony = get_sub_field_object('balcony')['value'];
                        $new_bedroom = get_sub_field_object('bedroom')['value'];
                        $compared[] = array(
                            'square' => $new_square,
                            'rooms' => $new_room,
                            'balcony' => $new_balcony,
                            'bedroom' => $new_bedroom,
                            'image' => $new_image
//                            'id' => $count
                        );
                    }
                }
            }
            $updated_types = get_field('build_type');
            global $post;
            $terms = get_the_terms($post->ID, 'district');

            if ($terms != null) {
                foreach ($terms as $term) {
                    $term_name = $term->name;
                }
            }

            $result[] = array(
                "id" => get_the_ID(),
                "title" => get_the_title(),
                "content" => get_the_content(),
                "permalink" => get_permalink(),
                "image" => get_field('image'),
                "name_house" => get_field('build_name'),
                "floors" => get_field('floors'),
                "coordinate" => get_field('coordinates'),
                "ecology" => get_field('ecology'),
                "tax_name" => $term_name,
                "type_house" => $updated_types,
                "compared" => $compared
            );
        }
        wp_reset_query();
        wp_send_json($result);
    } else {
        echo 'no posts found';
    }
?>
<div class="pagination-block">
    <div class="pagination-right">
        <?php $args = array(
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 1,
            'prev_next' => true,
            'add_args' => false,
            'add_fragment' => '',
        );
        $pagination = get_the_posts_pagination($args);
        echo str_replace('wp-admin/admin-ajax.php', 'property', $pagination); ?>
    </div>
</div>
<?php
    wp_die();
}


// Реєстрація віджету
function realestate_register_widget()
{
    register_widget('RealestateFilterWidget');
}
add_action('widgets_init', 'realestate_register_widget');
