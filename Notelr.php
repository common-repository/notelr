<?php
/**
 * Plugin Name: Notelr
 * Plugin URI: http://notelr.com
 * Description: Notelr Monetisation Plugin
 * Version: 0.1.1
 * Author: Notelr Technologies
 * Author URI: http://notelr.com/
 * License: GPLv3
 */

include "app/src/View.php";
include "app/src/API.php";
include "app/src/User.php";
/**
 * Class Notelr
 */
class Notelr
{
    /**
     * @var array
     */
    private $options = array();

    /**
     * Start up
     */
    public function __construct()
    {
        ob_start();
        define('APP_PATH', realpath(dirname(__FILE__) . '/app'));

        add_action('admin_menu', array($this, 'notelrMenu'));
        add_action('wp_ajax_notelr_send_email', array($this, 'sendEmail'));
        add_action('wp_ajax_notelr_login', array($this, 'login'));
        add_action('wp_ajax_notelr_register', array($this, 'registerUser'));
        add_action('wp_ajax_notelr_get_key', array($this, 'getKey'));
        add_action('wp_ajax_notelr_get_products', array($this, 'getProducts'));
        add_action('wp_ajax_notelr_save_widget', array($this, 'saveWidget'));
        add_action('wp_ajax_notelr_set_paypal', array($this, 'setPaypal'));
        add_action('wp_ajax_notelr_resend_email', array($this, 'resendEmail'));
        add_action('wp_ajax_notelr_change_email', array($this, 'changeEmail'));
        add_action('admin_init', array($this, 'editorButton'));

    }

    /**
     * Change the existing user email
     */
    public function changeEmail()
    {
        delete_option("notelr_user_id");
        delete_option("notelr_user_email");
        echo json_encode(array("status" => "ok"));
        die();
    }

    /**
     * Resend confirmation email
     */
    public function resendEmail()
    {
        $userId = $this->getOption("notelr_user_id");
        $api = new Notelr_API();
        $response = $api->resendEmail($userId);
        if ($response['status'] == "ok") {
            echo json_encode(array("status" => "ok"));
        }
        die();
    }

    /**
     * Set paypal account
     */
    public function setPaypal()
    {
        $email = $_POST['email'];
        $user = $this->getUser();
        $api = new Notelr_API($user->getKey());
        $response = $api->setPaypalEmail($user->getId(), $email);
        if ($response['status'] == "ok") {
            echo json_encode(array("status" => "ok"));
        }
        die();
    }

    /**
     * Set css styles
     */
    private function initStyles()
    {
        wp_enqueue_style('notelr_css', plugins_url('assets/css/notelr.css', __FILE__));
    }

    /**
     * Save widget
     */
    public function saveWidget()
    {

        $data = $_GET['data'];
        $user = $this->getUser();
        if (!empty($user)) {
            $api = new Notelr_API($user->getKey());
            $response = $api->saveWidget($user->getId(), $data['type'], $data);
            if ($response['status'] == "ok") {
                echo json_encode(array("status" => "ok"));
            }
        }
        die();
    }

    /**
     * Get the products for a specific widget
     */
    public function getProducts()
    {
        $data = $_GET['data'];
        $user = $this->getUser();
        if (!empty($user)) {
            $api = new Notelr_API($user->getKey());
            $products = $api->getProducts($data);
            echo json_encode($products);

        }
        die();
    }

    /**
     * Get the user key
     */
    function getKey()
    {
        $user = $this->getUser();
        if (!empty($user)) {
            echo json_encode(array("id" => $user->getId(), "key" => $user->getKey()));
        } else {
            echo json_encode(null);
        }
        die();
    }

    /**
     * Editor buttons for TinyMCE
     */
    function editorButton()
    {
        $is_admin = current_user_can( 'manage_options' );
        if($is_admin){
            add_filter("mce_external_plugins", array($this, "addEditorButton"));
            add_filter('mce_buttons', array($this, "registerEditorButton"));
        }
    }

    /**
     * Add the editor button
     * @param $plugin_array
     * @return mixed
     */
    function addEditorButton($plugin_array)
    {
        $plugin_array['notelr'] = plugins_url('assets/js/plugin/notelr_plugin.js', __FILE__);
        return $plugin_array;
    }

    /**
     * Register editor button
     * @param $buttons
     * @return mixed
     */
    function registerEditorButton($buttons)
    {

        array_push($buttons, 'notelr');
        return $buttons;
    }

    /**
     * Generate the notelr admin menu
     */
    public function notelrMenu()
    {
        function admin_inline_js(){
            echo "<script type='text/javascript'>\n";
            echo 'var notelrBaseUrl = "'.site_url() .'"';
            echo "\n</script>";
        }
        add_action( 'admin_print_scripts', 'admin_inline_js' );

        $icon_url = plugins_url('/assets/images/logo.png', __FILE__);

        if (!$this->isUserSet()) {
            add_menu_page(
                'Notelr',
                'Notelr',
                'manage_options',
                'notelr-settings',
                array($this, 'notelrSettings'),
                $icon_url
            );
            $page4 = add_submenu_page(
                'notelr',
                'Authenticate',
                'Authenticate',
                'manage_options',
                'notelr-settings',
                array($this, 'notelrSettings')
            );
            return;
        }
        add_menu_page(
            'Notelr',
            'Notelr',
            'manage_options',
            'notelr',
            array($this, 'notelrWidgets'),
            $icon_url
        );
        add_submenu_page(
            'notelr',
            'Widgets',
            'Widgets',
            'manage_options',
            'notelr',
            array($this, 'notelrWidgets')
        );
        $page2 = add_submenu_page(
            'notelr',
            'Notelr Add Widget',
            'Add widget',
            'manage_options',
            'notelr-add-widget',
            array($this, 'notelrAddWidget')
        );

        $page4 = add_submenu_page(
            'notelr',
            'Notelr Settings',
            'Settings',
            'manage_options',
            'notelr-settings',
            array($this, 'notelrSettings')
        );

        $page5 = add_submenu_page(
            'notelr',
            'Notelr Edit Widget',
            null,
            'manage_options',
            'notelr-edit-widget',
            array($this, 'notelrAddWidget')
        );
        $page6 = add_submenu_page(
            null,
            'Notelr Delete Widget',
            null,
            'manage_options',
            'notelr-delete-widget',
            array($this, 'notelrDeleteWidget')
        );
        $page7 = add_submenu_page(
            'notelr',
            'Notelr Logout',
            null,
            'manage_options',
            'notelr-logout',
            array($this, 'notelrLogout')
        );
    }

    /**
     *  Delete an existing widget
     */
    public function notelrDeleteWidget()
    {
        $view = new Notelr_View("add-widget");
        if (isset($_GET['id']) && isset($_GET['type'])) {
            $user = $this->getUser();
            $api = new Notelr_API($user->getKey());
            $response = $api->deleteWidget($_GET['id'], $_GET['type']);
            if ($response['status'] == "ok") {
                $view->type = $_GET['type'];
                $view->data = json_encode($response['data']);
            }
        }
        $this->notelrWidgets();
    }

    /**
     * The add/edit widget page
     */
    public function notelrAddWidget()
    {
        $this->initStyles();
        wp_enqueue_script('save_widget_js', plugins_url('assets/js/notelr_save_widget.js', __FILE__));
        wp_enqueue_script('handlebars_js', plugins_url('assets/js/libs/handlebars.js', __FILE__));
        wp_enqueue_script('raty_js', plugins_url('assets/js/libs/raty/jquery.raty.min.js', __FILE__));
        $view = new Notelr_View("add-widget");
        if (isset($_GET['id']) && isset($_GET['type'])) {
            $user = $this->getUser();
            $api = new Notelr_API($user->getKey());
            $response = $api->getWidget($_GET['id'], $_GET['type']);
            if ($response['status'] == "ok") {
                $view->type = $_GET['type'];
                $view->data = json_encode($response['data']);
            }
        }
        $view->render();
    }


    /**
     * Logout a user
     */
    public function notelrLogout()
    {
        delete_option('notelr_user');
        delete_option('notelr_user_id');
        delete_option('notelr_user_email');
        wp_redirect('admin.php?page=notelr-settings');
    }

    /**
     * The settings page
     */
    public function notelrSettings()
    {
        $this->initStyles();
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        wp_enqueue_script('settings_js', plugins_url('assets/js/notelr_settings.js', __FILE__));
        if (!$this->isUserSet()) {
            return $this->authenticate();
        }

        $user = $this->getUser();
        $view = new Notelr_View("settings");
        $view->name = $user->getName();
        $view->username = $user->getUsername();
        $api = new Notelr_API($user->getKey());
        $response = $api->getPaypalEmail($user->getId());
        if ($response['status'] == "ok") {
            $view->paypalEmail = $response['data']['email'];
        }
        return $view->render();

    }

    /**
     * The widgets page
     */
    public function notelrWidgets()
    {
        $this->initStyles();
        if ($this->isUserSet()) {
            $user = $this->getUser();
            $api = new Notelr_API($user->getKey());
            $widgets = $api->getWidgets($user->getId());
            $view = new Notelr_View("widgets");
            $view->widgets = $widgets['data'];
            return $view->render();
        }
    }

    /**
     * The authentication page including login and register
     */
    public function authenticate()
    {
        $this->initStyles();
        $view = new Notelr_View("authenticate");
        $userId = $this->getOption("notelr_user_id");
        $email = $this->getOption("notelr_user_email");
        $view->userId = $userId;
        $view->email = $email;
        return $view->render();
    }

    /**
     * Send confirmation email
     */
    public function sendEmail()
    {
        $email = $_GET['email'];
        $api = new Notelr_API();
        $response = $api->sendEmail($email);
        if ($response['status'] == "ok") {
            $this->setOption('notelr_user_id', $response['data']['id']);
            $this->setOption('notelr_user_email', $email);
            echo json_encode(array("status" => "ok"));
        }else{
            echo json_encode(array("status" => "error", "message" => $response['message']));
        }
        die();
    }

    /**
     * Create a new user
     */
    public function registerUser()
    {
        $key = $_POST['key'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $api = new Notelr_API($key);
        $response = $api->registerUser($this->getOption('notelr_user_id'), $name, $username, $password);
        if ($response['status'] == "ok") {
            $user = new Notelr_User();
            $user->setId($response['data']['id'])
                ->setName($response['data']['name'])
                ->setUsername($response['data']['username'])
                ->setKey($key);
            $this->setUser($user);
            echo json_encode(array("status" => "ok"));
        } else {
            echo json_encode(array("status" => "error", "message" => $response['message']));
        }
        die();
    }

    /**
     * Login an existing user
     */
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $api = new Notelr_API();
        $response = $api->login($email, $password);
        if ($response['status'] == "ok") {
            $user = new Notelr_User();
            $user->setId($response['data']['id'])
                ->setKey($response['data']['key'])
                ->setName($response['data']['name'])
                ->setUsername($response['data']['username']);
            $this->setUser($user);
            echo json_encode(array("status" => "ok"));
        } else {
            echo json_encode(array("status" => "error", "message" => $response['message']));
        }
        die();
    }

    /**
     * Check if the user is saved as an option
     * @return bool
     */
    public function isUserSet()
    {
        $this->options['user'] = unserialize(get_option('notelr_user'));
        if (empty($this->options['user'])) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Set the user as an option
     * @param $user
     */
    public function setUser($user)
    {
        $this->setOption('notelr_user', $user);
    }

    /**
     * Get the saved user
     * @return mixed|null
     */
    public function getUser()
    {
        if ($this->isUserSet()) {
            return $this->getOption('notelr_user');
        } else {
            return null;
        }
    }

    /**
     * Abstraction for setting options
     * @param $name
     * @param $value
     */
    public function setOption($name, $value)
    {
        if (get_option($name)) {
            update_option($name, $value);
        } else {
            add_option($name, serialize($value));
        }
        $this->options[$name] = $value;
    }

    /**
     * Abstraction for getting options
     * @param $name
     * @return mixed|null
     */
    public function getOption($name)
    {
        if (!empty($this->options[$name])) {
            return $this->options[$name];
        }
        $wpOption = @unserialize(get_option($name));
        if ($wpOption === false) {
            $wpOption = get_option($name);
        }
        if (!empty($wpOption)) {
            $this->options[$name] = $wpOption;
            return $wpOption;
        }
        return null;
    }
}

if (is_admin()) {
    $my_settings_page = new Notelr();

}


add_shortcode('notelr', 'notelrShortcode');
register_uninstall_hook(__FILE__,'uninstall');
function uninstall()
{
    delete_option("notelr_user_id");
    delete_option("notelr_user_email");
    delete_option("notelr_user");
}
/**
 * Shortcode implementation
 * @param $atts
 * @return string
 */
function notelrShortcode($atts)
{
    $code = $atts['code'];
    $type = $atts['type'];
    $size = $atts['size'];
    $color = $atts['color'];
    if ($type == "travelNow") {
        $type = "expedia-hotel";
    }
    $embedCode = "<iframe data-standalone='1' class='notelr-$code' id='notelr-$code' width='$size'  scrolling='no' frameborder='0'></iframe>";
    if ($size >= 300) {
        $size = 1;
    } else {
        $size = 0;
    }
    $url = "http://notelr.com/widget/embed/code/$code/style/$color/size/$size/type/$type";
    $embedCode .= "<script src='$url' type='text/javascript'></script>";
    return $embedCode;
}