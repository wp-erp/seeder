<?php
/**
 * Plugin Name: WP ERP Dummy Data Generator
 * Description: Generates dummy data for your ERP installtaion
 * Plugin URI: http://wperp.com
 * Author: Tareq Hasan
 * Author URI: http://tareq.co
 * Version: 2.0.0
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
    private $employee_count;
    private $customer_count;
    private $create_leaves;

    /**
     * Constructor
     */
    public function __construct() {

        $this->employee_count = 20;
        $this->customer_count = 20;
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
     * Initializes the WeDevs_ERP_Seeder() class
     *
     * Checks for an existing WeDevs_ERP_Seeder() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Seeder files
     *
     * @return void
     */
    public function file_includes() {
        include_once __DIR__ . '/includes/class-hr-seeder.php';
        include_once __DIR__ . '/includes/class-crm-seeder.php';
	    include_once __DIR__ . '/includes/class-hr-leaves-seeder.php';

	    if ( defined( 'WP_CLI' ) && WP_CLI ) {
            include_once __DIR__ . '/includes/cli/class-commands.php';
        }
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
            $this->employee_count   = isset( $_POST['employee_number'] )    ? intval( $_POST['employee_number'] )   : 0;
            $this->customer_count   = isset( $_POST['customer_number'] )    ? intval( $_POST['customer_number'] )   : 0;
            $this->create_leaves    = isset( $_POST['create_leaves'] )      ? intval( $_POST['create_leaves'] )     : 0;
            $this->generate_data();

            echo "<h1>Done!</h1>";
            printf( '<a href="%s">View Employees</a> OR ', admin_url( 'admin.php?page=erp-hr&section=employee' ) );
            printf( '<a href="%s">View Leaves</a> OR ', admin_url( 'admin.php?page=erp-hr&section=leave' ) );
            printf( '<a href="%s">View Customers</a>', admin_url( 'admin.php?page=erp-crm&section=contacts' ) );
            die();
        }
    }

    /**
     * Run the seeder from cli
     *
     * @param  string $type
     * @param  int    $number
     *
     * @return void
     */
    public function run_seeder_from_cli( $type, $number ) {
        $this->employee_count = 0;
        $this->customer_count = 0;

        if ( $type == 'employee' ) {
            $this->employee_count = $number;
        }

        if ( in_array( strtolower( $type ), ['customer', 'contact', 'company'] ) ) {
            $this->customer_count = $number;
        }

        $this->generate_data();
    }

    /**
     * Instantiate the seeder classes
     *
     * @return void
     */
    function generate_data() {
        if ( $this->employee_count > 0 ) {
            (new WeDevs_ERP_HR_Seeder( $this->faker, $this->employee_count ))->run();
        }

        if ( $this->customer_count > 0 ) {
            (new WeDevs_ERP_CRM_Seeder( $this->faker, $this->customer_count ))->run();
        }

        if ( $this->create_leaves > 0 ) {
	        (new WeDevs_ERP_HR_Leaves_Seeder( $this->customer_count ))->run();
        }
    }
}

function erp_seeder() {
    return WeDevs_ERP_Seeder::init();
}

erp_seeder();
