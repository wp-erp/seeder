<?php

/**
 * HR Seeder Class
 */
class WeDevs_ERP_HR_Seeder {

    function __construct( \Faker\Generator $faker, $count ) {
        $this->faker = $faker;
        $this->count = $count;
    }

    /**
     * Run the seeder functions
     *
     * @return void
     */
    public function run() {
        $this->init_depts();
        $this->truncate_all();
        $this->create_departments();
        $this->create_designations();
        $this->create_employees();
    }

    /**
     * Delete employees and clear the table
     *
     * @return void
     */
    public function truncate_all() {
        global $wpdb;

        if ( ! function_exists( 'wp_delete_user' ) ) {
            require_once ABSPATH . '/wp-admin/includes/user.php';
        }

        // delete all the employees
        $employees = erp_hr_get_employees( [ 'number' => 100 ] );
        if ( $employees ) {
            foreach ($employees as $employee) {
                erp_employee_delete( $employee->id, true );
            }
        }

        // truncate the tables
        $tables = [ 'erp_hr_depts', 'erp_hr_designations', 'erp_hr_employees' ];
        foreach ($tables as $table) {
            $wpdb->query( 'TRUNCATE TABLE ' . $wpdb->prefix . $table );
        }
    }

    /**
     * Initialize the department and designations
     *
     * @return void
     */
    public function init_depts() {
        $this->departments = [
            1 => [
                'title' => 'Administration',
                'designations' => [
                    1 => 'Admin',
                    2 => 'HR Manager'
                ]
            ],
            2 => [
                'title' => 'Engineering',
                'designations' => [
                    3 => 'Android Developer',
                    4 => 'iOS Developer',
                    5 => 'Platform Engineer',
                    6 => 'Frontend Developer'
                ]
            ],
            3 => [
                'title' => 'Design',
                'designations' => [
                    7 => 'Print Designer',
                    8 => 'UI Designer'
                ]
            ],
            4 => [
                'title' => 'Marketing',
                'designations' => [
                    9  => 'Marketing Manager',
                    10 => 'Marketing Executive'
                ]
            ],
            5 => [
                'title' => 'Sales',
                'designations' => [
                    11 => 'Sales Manager',
                    12 => 'Sales Executive'
                ]
            ],
            6 => [
                'title' => 'Support',
                'designations' => [
                    13 => 'Support Ninja'
                ]
            ]
        ];
    }

    /**
     * Create Departments
     *
     * @return void
     */
    function create_departments() {
        foreach ($this->departments as $dept_id => $dept) {
            erp_hr_create_department( [ 'title' => $dept['title'] ] );
        }
    }

    /**
     * Create designations
     *
     * @return void
     */
    function create_designations() {
        foreach ($this->departments as $dept_id => $dept) {
            foreach ($dept['designations'] as $designation) {
                erp_hr_create_designation( [ 'title' => $designation ] );
            }
        }
    }

    /**
     * Create employees
     *
     * @return void
     */
    function create_employees() {
        $id_base = 1000;

        for ( $i = 0; $i < $this->count; $i++ ) {
            $genders          = erp_hr_get_genders();
            $marital_statuses = erp_hr_get_marital_statuses();
            $random_dept_id   = array_rand( $this->departments );
            $random_dept      = $this->departments[ $random_dept_id ];
            $random_desig     = array_rand( $random_dept['designations'] );
            $pay_rates        = range( 5000, 80000, 5000 );


            $gender           = array_rand( $genders );
            $marital_status   = array_rand( $marital_statuses );
            $status           = 'active';
            $hiring_date      = $this->faker->dateTimeThisDecade();

            $args = array(
                'user_email'      => $this->faker->email,
                'work'            => array(
                    'designation'   => $random_desig,
                    'department'    => $random_dept_id,
                    'location'      => '',
                    'hiring_source' => array_rand( erp_hr_get_employee_sources() ),
                    'hiring_date'   => $hiring_date->format('Y-m-d'),
                    'date_of_birth' => $this->faker->dateTimeBetween( '-45 years', '-18 years')->format('Y-m-d'),
                    'reporting_to'  => 0,
                    'pay_rate'      => $pay_rates[ array_rand( $pay_rates ) ],
                    'pay_type'      => 'monthly',
                    'type'          => array_rand( erp_hr_get_employee_types() ),
                    'status'        => $status,
                ),
                'personal'        => array(
                    'photo_id'        => 0,
                    'employee_id'     => $id_base + $i,
                    'first_name'      => $this->faker->firstName( $gender ),
                    'middle_name'     => '',
                    'last_name'       => $this->faker->lastName,
                    'other_email'     => '',
                    'phone'           => $this->faker->phoneNumber,
                    'work_phone'      => '',
                    'mobile'          => '',
                    'address'         => $this->faker->address,
                    'gender'          => $gender,
                    'marital_status'  => $marital_status,
                    'nationality'     => 'US',
                    'driving_license' => '',
                    'hobbies'         => '',
                    'user_url'        => $this->faker->url,
                    'description'     => $this->faker->realText(),
                ),
                'additional'          => array(),
            );

            $employee_id = erp_hr_employee_create( $args );
        }
    }
}
