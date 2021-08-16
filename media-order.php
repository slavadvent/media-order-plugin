<?php
/**
 * Plugin Name: media-order
 * Description: Проверка привязки изображений к публикациям, связывание их и удаление лишних изображений не используемых на сайте
 * Plugin URI:  Ссылка на инфо о плагине
 * Author URI:  Ссылка на автора
 * Author:      S2S
 * Version:     1.0
 *
 * Text Domain: Идентификатор перевода, указывается в load_plugin_textdomain()
 * Domain Path: Путь до файла перевода. Нужен если файл перевода находится не в той же папке, в которой находится текущий файл.
 *              Например, .mo файл находится в папке myplugin/languages, а файл плагина в myplugin/myplugin.php, тогда тут указываем "/languages"
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Network:     Укажите "true" для возможности активировать плагин по все сети сайтов (для Мультисайтовой сборки).
 */


/** Прекрасный автолоад классов лаконичный. в namespace пишем некий уникальный свой путь*/
//namespace Kibo\PhastPlugins\PhastPress;
//
//spl_autoload_register(function ($class) {
//    if (strpos($class, __NAMESPACE__ . '\\') !== 0) {
//        return;
//    }
//    $relativeClass = substr($class, strlen(__NAMESPACE__) + 1);
//    $classFile = __DIR__ . '/classes/' . str_replace('\\', '/', $relativeClass) . '.php';
//    if (file_exists($classFile)) {
//        include $classFile;
//    }
//});





/** If this file is called directly, abort */
if(!defined('WPINC')) {
    die;
}

/** Версия плагина */
define('PLUGIN_NAME_VERSION', '1.0.0');

/** Директория плагина */
define('MO_PLUG_DIR', plugin_dir_path(__FILE__));


/** Директория плагина */
define('MO_NAME_OPTIONS', 'media_order_set');




/** Активация плагина */
function activate_plugin_name() {
    require_once MO_PLUG_DIR . 'includes/class-plugin-name-activator.php';
    Plugin_Name_Activator::activate();
}

/** Деактивация плагина */
function deactivate_plugin_name() {
    require_once MO_PLUG_DIR . 'includes/Class/class-plugin-name-deactivator.php';
    Plugin_Name_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_plugin_name');
register_deactivation_hook(__FILE__, 'deactivate_plugin_name');


/** Подключаем базовый класс, в котором определяем и подключаем остальные */
require MO_PLUG_DIR . 'includes/Class/MO_load_set_options.php';


/** Выдача сообщения в админке об ошибках */
//add_action('admin_notices', 'media_order_error_notice');
//function media_order_error_notice(){
//    if(!empty($_SESSION['down_message_error'])){
//        echo '<div class="notice notice-error is-dismissible"> <p>'. $_SESSION['down_message_error'] .'</p></div>';
//        unset($_SESSION['down_message_error']);
//    }
//}



/** Begins execution of the plugin */
function run_plugin_name() {

    $plugin = new MO_load_set_options();
    $plugin->set_options();

}
run_plugin_name();






