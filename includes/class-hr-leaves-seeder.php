<?php

/**
 * HR Seeder Class
 */
class WeDevs_ERP_HR_Leaves_Seeder {

	protected $policies;

	protected $leave_request_datas;

    function __construct( $count ) {
        $this->count = $count;
    }

    /**
     * Run the seeder functions
     *
     * @return void
     */
    public function run() {
        $this->truncate_all();
        $this->policies_datas();
        $this->create_entitlements();
    }

    /**
     * Delete employees and clear the table
     *
     * @return void
     */
    public function truncate_all() {
        global $wpdb;

        // truncate the tables
        $tables = [
            'erp_hr_leave_policies',
            'erp_hr_leave_entitlements',
            'erp_hr_leave_requests',
            'erp_hr_leaves',
            'erp_user_leaves',
            'erp_hr_holiday'
        ];

        foreach ($tables as $table) {
            $wpdb->query( 'TRUNCATE TABLE ' . $wpdb->prefix . $table );
        }
    }

	/**
	 * Use this method as seeder for leave request
	 */
	protected function leave_request_datas() {
		$this->leave_request_datas = [

		];
	}

	/**
	 * Use this method as seeder for leave policy
	 */
    protected function policies_datas() {
        global $wpdb;
        
    	$this->policies = [
            [
                'name'           => 'Annual leave',
                'value'          => 5,
                'color'          => '#8224e3',
                'department'     => 2,
                'designation'    => 5,
                'gender'         => '-1',
                'marital'        => '-1',
                'description'    => 'Annual leave policy',
                'location'       => '-1',
                'effective_date' => '2020-01-01 00:00:00',
                'activate'       => 1,
                'execute_day'    => 0,
                'created_at'     => '2020-02-03 10:39:03',
                'updated_at'     => '2020-02-03 10:39:03'
            ],
            [
                'name'           => 'Casual leave',
                'value'          => 10,
                'color'          => '#f90000',
                'department'     => '-1',
                'designation'    => '-1',
                'gender'         => '-1',
                'marital'        => '-1',
                'description'    => 'Casual leave policy',
                'location'       => '-1',
                'effective_date' => '2020-01-01 00:00:00',
                'activate'       => 1,
                'execute_day'    => 0,
                'created_at'     => '2020-02-03 10:42:04',
                'updated_at'     => '2020-02-03 10:42:04'
            ],
            [
                'name'           => 'Sick leave',
                'value'          => 5,
                'color'          => '#f54330',
                'department'     => '-1',
                'designation'    => '-1',
                'gender'         => '-1',
                'marital'        => '-1',
                'description'    => 'Casual leave policy',
                'location'       => '-1',
                'effective_date' => '2020-01-01 00:00:00',
                'activate'       => 1,
                'execute_day'    => 0,
                'created_at'     => '2020-02-03 10:42:04',
                'updated_at'     => '2020-02-03 10:42:04'
            ],
            [
                'name'           => 'Marriage leave',
                'value'          => 5,
                'color'          => '#f54330',
                'department'     => '-1',
                'designation'    => '-1',
                'gender'         => '-1',
                'marital'        => 'single',
                'description'    => 'Marriage leave policy',
                'location'       => '-1',
                'effective_date' => '2020-01-01 00:00:00',
                'activate'       => 1,
                'execute_day'    => 0,
                'created_at'     => '2020-02-03 10:42:04',
                'updated_at'     => '2020-02-03 10:42:04'
            ],
            [
                'name'           => 'Maternity leave',
                'value'          => 84,
                'color'          => '#0726c1',
                'department'     => '-1',
                'designation'    => '-1',
                'gender'         => 'female',
                'marital'        => 'married',
                'description'    => 'Maternity leave policy',
                'location'       => '-1',
                'effective_date' => '2020-01-01 00:00:00',
                'activate'       => 1,
                'execute_day'    => 0,
                'created_at'     => '2020-02-03 10:55:28',
                'updated_at'     => '2020-02-03 10:55:28'
            ],
            [
                'name'           => 'Paternity leave',
                'value'          => 5,
                'color'          => '#8726c1',
                'department'     => '-1',
                'designation'    => '-1',
                'gender'         => 'male',
                'marital'        => 'married',
                'description'    => 'Paternity leave policy',
                'location'       => '-1',
                'effective_date' => '2020-01-01 00:00:00',
                'activate'       => 1,
                'execute_day'    => 0,
                'created_at'     => '2020-02-03 10:55:28',
                'updated_at'     => '2020-02-03 10:55:28'
            ]
        ];

        foreach( $this->policies as $policy ) {
            $wpdb->insert( $wpdb->prefix . 'erp_hr_leave_policies', $policy );
        }
    }

    protected function create_entitlements() {
        global $wpdb;

        $current_user = get_current_user_id();
        $date_minus_1 = strtotime( date('Y-m-d') . ' -1 year' );
        $prev_year    = date('Y', $date_minus_1);

    	$policies_id = [
            'annual'    => 1,
            'casual'    => 2,
            'sick'      => 3,
            'marriage'  => 4,
            'maternity' => 5,
            'paternity' => 6
        ];

        $basic = [
            [
                'policy_id'  => $policies_id['annual'],
                'days'       => 5,
                'comments'   => 'An entitlement',
                'status'     => 1,
                'created_by' => $current_user,
                'created_on' => date('Y-m-d h:i:s')
            ],
            [
                'policy_id'  => $policies_id['casual'],
                'days'       => 10,
                'comments'   => 'An entitlement',
                'status'     => 1,
                'created_by' => $current_user,
                'created_on' => date('Y-m-d h:i:s')
            ],
            [
                'policy_id'  => $policies_id['sick'],
                'days'       => 5,
                'comments'   => 'An entitlement',
                'status'     => 1,
                'created_by' => $current_user,
                'created_on' => date('Y-m-d h:i:s')
            ]
        ];

        $professional = [
            'policy_id'  => $policies_id['marriage'],
            'days'       => 5,
            'comments'   => 'An entitlement',
            'status'     => 1,
            'created_by' => $current_user,
            'created_on' => date('Y-m-d h:i:s')
        ];

        $business = [
            'policy_id'  => $policies_id['maternity'],
            'days'       => 84,
            'from_date'  => '2020-01-01 00:00:00',
            'to_date'    => '2020-12-31 23:59:59',
            'comments'   => 'An entitlement',
            'status'     => 1,
            'created_by' => $current_user,
            'created_on' => date('Y-m-d h:i:s')
        ];

        $enterprise = [
            'policy_id'  => $policies_id['paternity'],
            'days'       => 5,
            'from_date'  => '2020-01-01 00:00:00',
            'to_date'    => '2020-12-31 23:59:59',
            'comments'   => 'An entitlement',
            'status'     => 1,
            'created_by' => $current_user,
            'created_on' => date('Y-m-d h:i:s')
        ];

        $employees = erp_hr_get_employees( [ 'number' => -1 ] );

        foreach( $employees as $employee ) {
            $user_id        = $employee->get_user_id();
            $gender         = $employee->get_gender();
            $marital_status = $employee->get_marital_status();

            if ( $user_id % 2 === 0 ) {
                $from_date = $prev_year . '-01-01 00:00:00';
                $to_date   = $prev_year . '-01-01 00:00:00';
            } else {
                $from_date = date('Y') . '-01-01 00:00:00';
                $to_date   = date('Y') . '-01-01 00:00:00';
            }

            foreach( $basic as $base ) {
                $base['user_id']   = $user_id;
                $base['from_date'] = $from_date;
                $base['to_date']   = $to_date;

                $wpdb->insert( $wpdb->prefix . 'erp_hr_leave_entitlements', $base );
            }

            if ( $marital_status === 'single' ) {
                $professional['from_date'] = $from_date;
                $professional['to_date']   = $to_date;

                $wpdb->insert( $wpdb->prefix . 'erp_hr_leave_entitlements', $professional );
            }

            if ( $marital_status === 'married' && $gender === 'female' ) {
                $business['from_date'] = $from_date;
                $business['to_date']   = $to_date;

                $wpdb->insert( $wpdb->prefix . 'erp_hr_leave_entitlements', $business );
            }

            if ( $marital_status === 'married' && $gender === 'male' ) {
                $business['from_date'] = $from_date;
                $business['to_date']   = $to_date;

                $wpdb->insert( $wpdb->prefix . 'erp_hr_leave_entitlements', $enterprise );
            }
        }
    }

    protected function create_leave_requests() {
		//get policy id, user id, data from $this->leave_request_datas, then insert into table
    }

}
