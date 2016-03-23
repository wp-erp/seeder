<?php
/**
 * Plugin Name: WP ERP Dummy Data Generator
 * Description: Generates dummy data for your ERP installtaion
 * Plugin URI: http://wperp.com
 * Author: Tareq Hasan
 * Author URI: http://tareq.co
 * Version: 1.0
 * License: GPL2
 */

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

require_once 'vendor/autoload.php';

/**
 * The plugin
 */
class WeDevs_ERP_Seeder {

    private $faker;
    private $count;

    /**
     * Constructor
     */
    public function __construct() {

        $this->count = 20;
        $this->faker = Faker\Factory::create();

        $this->faker->addProvider( new Faker\Provider\en_US\Person($this->faker ) );
        $this->faker->addProvider( new Faker\Provider\Internet( $this->faker ) );
        $this->faker->addProvider( new Faker\Provider\Base( $this->faker ) );
        $this->faker->addProvider( new Faker\Provider\DateTime( $this->faker ) );
        $this->faker->addProvider( new Faker\Provider\en_US\Address( $this->faker ) );
        $this->faker->addProvider( new Faker\Provider\en_US\PhoneNumber( $this->faker ) );
        $this->faker->addProvider( new Faker\Provider\Miscellaneous( $this->faker ) );

        $this->file_includes();

        add_action( 'erp_tools_page', [ $this, 'add_settings_area' ] );
        add_action( 'admin_init', [ $this, 'submit_tools_page' ] );
    }

    /**
     * Seeder files
     *
     * @return void
     */
    public function file_includes() {
        include_once __DIR__ . '/includes/class-hr-seeder.php';
    }

    /**
     * Tools page
     */
    public function add_settings_area() {
        include __DIR__ . '/includes/tools-page.php';
    }

    /**
     * Run the seeder
     *
     * @return void
     */
    function submit_tools_page() {
        if ( isset( $_POST['erp_generate_dummy_data'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'erp-dummy-data-nonce' ) ) {
            $this->count = isset( $_POST['employee_number'] ) ? intval( $_POST['employee_number'] ) : 20;
            $this->generate_data();
        }
    }

    /**
     * Instantiate the seeder classes
     *
     * @return void
     */
    function generate_data() {

        (new WeDevs_ERP_HR_Seeder( $this->faker, $this->count ))->run();

        echo "<h1>Done!</h1>";
        printf( '<a href="%s">View Employees</a>', admin_url( 'admin.php?page=erp-hr-employee' ) );
        die();
    }
}

new WeDevs_ERP_Seeder();
