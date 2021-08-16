<?php
/**
 * Plugin Name: media-order
 * Description: Проверка привязки изображений к публикациям, связывание их и удаление лишних изображений не используемых на сайте
 * Plugin URI:  Ссылка на инфо о плагине
 * Author URI:  Ссылка на автора
 * Author:      S2S
 * Version:     1.0
 */

/** Создаем страницу настроек плагина */
add_action('admin_menu', 'add_plugin_page');
function add_plugin_page(){
    $name_plag = 'Настройки упорядочивания изображений и привязки их к публикациям';
    add_options_page($name_plag, 'Media-order', 'manage_options', 'media-order-slug', function () {
            ?>
            <div class="wrap">
                <h2><?php echo get_admin_page_title() ?></h2>
                <?php //settings_errors(); ?>

                <form action="options.php" method="POST">
                    <?php
//                    $args = array(
//                        'public'                => true
//                    );
//                    $output   = 'names';
//                    $post_types = get_post_types($args, $output);
//                    unset( $post_types['attachment'] );
//                    foreach( $post_types as $post_type ) {
//                        echo '<p>'. $post_type. '</p>';
//                    }
//                    echo '<p>-----------------------</p>';
//
//                    $args = array(
//                        'public'                => true
//                    );
//                    $output   = 'names';
//                    $taxonomies = get_taxonomies($args, $output);
//                    foreach( $taxonomies as $taxonomy ) {
//                        echo '<p>'. $taxonomy. '</p>';
//                    }

                    $array_submit = [
                        'id' => 'media_order_submit',
                        'data-show' => 'show'];
                    settings_fields( 'option_group' );     // скрытые защитные поля
                    do_settings_sections( 'media_order_set_page' ); // секции с настройками (опциями). У нас она всего одна 'section_id'
                    submit_button('', 'primary', 'submit', true, $array_submit);
                    //submit_button();
                    ?>
                </form>
                <div>Check</div>
            </div>
            <?php
        }
    );
}

/** Регистрируем настройки. Настройки будут храниться в массиве, а не одна настройка = одна опция */
add_action('admin_init', 'media_order_plugin_settings');
function media_order_plugin_settings() {
    $val = get_option(MO_NAME_OPTIONS);

    // параметры: $option_group, $option_name, $sanitize_callback
    register_setting( 'option_group', MO_NAME_OPTIONS, 'sanitize_callback' );


    // параметры: $id, $title, $callback, $page
    add_settings_section( 'section_id', 'Основные настройки', 'field_info_function', 'media_order_set_page' );


    add_settings_field('first_field', 'Все публикации', 'public_chouse_function', 'media_order_set_page', 'section_id', $val );
    add_settings_field('second_field', 'Все таксономии', 'taxonomy_chouse_function', 'media_order_set_page', 'section_id', $val );
    //add_settings_field('three_field', 'Все таксономии1', 'fill_primer_field1', 'media_order_set_page', 'section_id', $val );

    // параметры: $id, $title, $callback, $page
    //add_settings_section( 'section_id1', 'Другие настройки', '', 'media_order_set_page' );

    // параметры: $id, $title, $callback, $page, $section, $args
    //add_settings_field('primer_field3', 'Название другое', 'fill_primer_field3', 'media_order_set_page', 'section_id1', $val );

    //add_settings_field('phone','<label for="phone">Телефон</label>', 'phone_field_html', 'media_order_set_page', 'section_id1');

}

/** Заполнение сегмента info */
function field_info_function(){
    ?>
    <p>Выберите все вариманты контента для поиска и сравнения медиафайлов</p>
    <?php
}


/** Заполняем опцию 1 */
//function fill_primer_field1($val) {
//    $val = $val ? $val['name1'] : null;
//    ?>
<!--    <input type="text" name="media_order_set[name1]" value="--><?php //echo esc_attr( $val ) ?><!--" />-->
<!--    --><?php
//}

/** Заолнение секции выбор публикации. По умолчанию выбран */
function public_chouse_function($val) {
    $val = $val ? array_key_exists('checkbox_post', $val) ? $val['checkbox_post'] : null : 1;
    //$val = array_key_exists('checkbox_post' ,$val) ? $val['checkbox_post'] : null;
    ?>
    <label><input type="checkbox" name="<?php echo MO_NAME_OPTIONS ?>[checkbox_post]" value="1" <?php checked( 1, $val ) ?> />'Page', 'Post', 'User_type' и т.д.</label>
    <?php
}

/** Заолнение секции выбор категории. По умолчанию выбран */
function taxonomy_chouse_function($val) {
    $val = $val ? array_key_exists('checkbox_tax', $val) ? $val['checkbox_tax'] : null : 1;
    //$val = array_key_exists('checkbox_tax' ,$val) ? $val['checkbox_tax'] : null;
    ?>
    <label><input type="checkbox" name="<?php echo MO_NAME_OPTIONS ?>[checkbox_tax]" value="1" <?php checked( 1, $val ) ?> />'Category', 'Tag', 'User_taxonomy' и т.д.</label>
    <?php
}

/** Заполняем опцию 3 (Другие настройки) */
//function fill_primer_field3($val){
//    $val = $val ? $val['name2'] : null;
//    ?>
<!--    <input type="text" name="option_name[name2]" value="--><?php //echo esc_attr( $val ) ?><!--" />-->
<!--    --><?php
//}





## Очистка данных
function sanitize_callback( $options ) {
    // очищаем
    foreach( $options as $name => & $val ){
        if( $name == 'name1' ) $val = strip_tags( $val );

        //if( $name == 'name2' ) $val = strip_tags( $val );

        if( $name == 'checkbox_post' ) $val = (int)$val;

        if( $name == 'checkbox_tax' ) $val = (int)$val;
    }

    var_dump($options);

    //die(print_r( $options )); // Array ( [input] => aaaa [checkbox] => 1 )

    return $options;
}