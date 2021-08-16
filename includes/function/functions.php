<?php
/**
* Plugin Name: media-order
* Description: Проверка привязки изображений к публикациям, связывание их и удаление лишних изображений не используемых на сайте
* Plugin URI:  Ссылка на инфо о плагине
* Author URI:  Ссылка на автора
* Author:      S2S
* Version:     1.0
*/


function setting_options () {
    require_once MO_PLUG_DIR . 'admin/start-setting-options.php';
}
