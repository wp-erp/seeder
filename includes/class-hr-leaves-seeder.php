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
        $this->entitlement_datas();
    }

    /**
     * Delete employees and clear the table
     *
     * @return void
     */
    public function truncate_all() {
        global $wpdb;

        // truncate the tables
        $tables = [ 'leave_policies', 'leave_entitlements', 'leave_requests', 'hr_leaves', 'user_leaves' ];

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

    protected function policies_datas() {
	    global $wpdb;

    	$this->policies = [

	    ];

    	//create policies datas here

    }


    protected function create_entitlements() {
    	//grab policie ids

	    //grab user ids

	    //insert datas to entitlements table

    }

    protected function create_leave_requests() {
		//get policy id, user id, data from $this->leave_request_datas, then insert into table
    }


}
