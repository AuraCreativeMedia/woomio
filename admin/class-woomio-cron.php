<?php

/**
 * The CRON-specific functionality of the plugin.
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 */

require_once plugin_dir_path(dirname(__FILE__)) . 'admin/modules/Module_Config.php';  

class Woomio_Cron {

    use Module_Config;

    public function __construct() {

        add_action('init', array($this, 'schedule_cron_jobs'));
        add_filter('cron_schedules', array($this, 'add_daily_cron_schedules'));
    }

    protected function get_cron_interval() {
        // Default to daily
        return 'daily';
    }

    protected function get_cron_hook_name() {
        // To be defined in child classes
        return '';
    }

    public function cron_task() {
        // To be defined in child classes
    }

    public function schedule_cron_jobs() {

        $interval = $this->get_cron_interval();
        $hook_name = $this->get_cron_hook_name();
        
        if ($interval === 'weekly_based_on_option') {
            $chosen_day = get_option('_woomio_mod_new_prod_dow', 'Monday'); // Default to Monday if no value is set
            $next_day = strtotime("next $chosen_day");
            $hook_name .= "_$chosen_day";
    
            if (!wp_next_scheduled($hook_name)) {
                wp_schedule_event($next_day, "weekly_on_$chosen_day", $hook_name);
            }
        } else {
            if (!wp_next_scheduled($hook_name)) {
                wp_schedule_event(time(), $interval, $hook_name);
            }
        }
    
        add_action($hook_name, array($this, 'cron_task'));
    }

    public function unschedule_cron_jobs() {
        wp_clear_scheduled_hook($this->get_cron_hook_name());
    }

    public function instantiate_module_crons() {
        // Fetch module meta
        $modules_meta = self::get_module_meta();
        
        foreach ($modules_meta as $module) {
            $module_slug = $module['slug'];
            $file_path = plugin_dir_path(dirname(__FILE__)) . "admin/modules/{$module_slug}/{$module_slug}_cron.php";
            
            // Check if the file exists before including it
            if (file_exists($file_path)) {
                require_once $file_path;
                $class_name = "Woomio_{$module_slug}_Cron";
                if (class_exists($class_name)) {
                    new $class_name();
                }
            }
        }

        new Woomio_send_new_releases_growmio_Cron();
    }

    public function add_daily_cron_schedules($schedules) {
        $days_of_week = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    
        foreach ($days_of_week as $day) {
            $schedules["weekly_on_$day"] = array(
                'interval' => 604800,  // Number of seconds in a week
                'display'  => __("Once Weekly on $day"),
            );
        }
    
        return $schedules;
    }
    

}
