<?php

/**
 * Plugin Name: media-order
 * File: Первичный клас настройки опций плагина.
 *
 * Plugin URI:  Ссылка на инфо о плагине
 * Author URI:  Ссылка на автора
 * Author:      S2S
 * Version:     1.0
 */


class MO_load_set_options {

	/**The loader that's responsible for maintaining and registering all hooks that power the plugin */
	protected $loader;

	/** The unique identifier of this plugin */
	protected $plugin_name;

	/** The current version of the plugin */
	protected $version;

	/** Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site */

	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'plugin-name';
        require_once MO_PLUG_DIR . 'includes/function/functions.php';

		$this->load_dependencies();
		//$this->set_locale();
		//$this->define_admin_hooks();
		//$this->define_public_hooks();

	}

	/** Load the required dependencies for this plugin */
	private function load_dependencies() {

		/** The class responsible for orchestrating the actions and filters of the core plugin */
		require_once MO_PLUG_DIR . 'includes/Class/class-plugin-name-loader.php';

		/** The class responsible for defining internationalization functionality of the plugin */
		require_once MO_PLUG_DIR . 'includes/Class/class-plugin-name-i18n.php';

		/** The class responsible for defining all actions that occur in the admin area */
		require_once MO_PLUG_DIR . 'admin/class-plugin-name-admin.php';

		/** The class responsible for defining all actions that occur in the public-facing side of the site */
		require_once MO_PLUG_DIR . 'public/class-plugin-name-public.php';

	}

	/** Run the loader to execute all of the hooks with WordPress */
	public function set_options() {

        /** Регистрируем настройки и запускаем настройку опций */
        //require_once MO_PLUG_DIR . 'includes/function/functions.php';
        if (function_exists('setting_options')) {
            setting_options ();
        }

    }


	/** The name of the plugin used to uniquely identify it within the context of WordPress and to define internationalization functionality */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/** The reference to the class that orchestrates the hooks with the plugin */
	public function get_loader() {
		return $this->loader;
	}

	/** Retrieve the version number of the plugin */
	public function get_version() {
		return $this->version;
	}

}
