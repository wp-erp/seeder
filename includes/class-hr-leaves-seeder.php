<?php

/**
 * HR Seeder Class
 */
class WeDevs_ERP_HR_Leaves_Seeder
{

    protected $policies;

    protected $leave_request_datas;

    function __construct($count) {
        $this->count = $count;
    }

    /**
     * Run the seeder functions
     *
     * @return void
     */
    public function run() {
        $this->truncate_all();
        $this->create_holidays();
        $this->policies_datas();
        $this->create_entitlements();
        $this->create_leave_requests();
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
            $wpdb->query('TRUNCATE TABLE ' . $wpdb->prefix . $table);
        }
    }

    /**
     * Use this method as seeder for leave request
     */
    protected function leave_request_datas() {
        $this->leave_request_datas = [];
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

        foreach ($this->policies as $policy) {
            $wpdb->insert($wpdb->prefix . 'erp_hr_leave_policies', $policy);
        }
    }

    protected function create_entitlements() {
        global $wpdb;

        $current_user = get_current_user_id();
        $date_minus_1 = strtotime(date('Y-m-d') . ' -1 year');
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

        $employees = erp_hr_get_employees(['number' => -1]);

        foreach ($employees as $employee) {
            $user_id        = $employee->get_user_id();
            $gender         = $employee->get_gender();
            $marital_status = $employee->get_marital_status();

            if ($user_id % 2 === 0) {
                $from_date = $prev_year . '-01-01 00:00:00';
                $to_date   = $prev_year . '-01-01 00:00:00';
            } else {
                $from_date = date('Y') . '-01-01 00:00:00';
                $to_date   = date('Y') . '-01-01 00:00:00';
            }

            foreach ($basic as $base) {
                $base['user_id']   = $user_id;
                $base['from_date'] = $from_date;
                $base['to_date']   = $to_date;

                $wpdb->insert($wpdb->prefix . 'erp_hr_leave_entitlements', $base);
            }

            if ($marital_status === 'single') {
                $professional['user_id']   = $user_id;
                $professional['from_date'] = $from_date;
                $professional['to_date']   = $to_date;

                $wpdb->insert($wpdb->prefix . 'erp_hr_leave_entitlements', $professional);
            }

            if ($marital_status === 'married' && $gender === 'female') {
                $business['user_id']   = $user_id;
                $business['from_date'] = $from_date;
                $business['to_date']   = $to_date;

                $wpdb->insert($wpdb->prefix . 'erp_hr_leave_entitlements', $business);
            }

            if ($marital_status === 'married' && $gender === 'male') {
                $enterprise['user_id']   = $user_id;
                $enterprise['from_date'] = $from_date;
                $enterprise['to_date']   = $to_date;

                $wpdb->insert($wpdb->prefix . 'erp_hr_leave_entitlements', $enterprise);
            }
        }
    }

    /**
     * Create leave requests
     */
    protected function create_leave_requests() {
        global $wpdb;

        $entitlements = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}erp_hr_leave_entitlements");

        foreach ($entitlements as $entitlement) {
            $date_plus_10 = date('Y-m-d', strtotime($entitlement->from_date . ' +10 days'));
            $date_plus_20 = date('Y-m-d', strtotime($date_plus_10 . ' +20 days'));

            $from_date  = $this->get_random_date($entitlement->from_date, $date_plus_10);
            $to_date    = $this->get_random_date($date_plus_10, $date_plus_20);
            $date_count = date_diff(date_create($from_date), date_create($to_date));

            $data = [
                'user_id'    => $entitlement->user_id,
                'policy_id'  => $entitlement->policy_id,
                'days'       => $date_count->format('%a') + 1, // plus 1 for count with the starting date
                'start_date' => $from_date,
                'end_date'   => date('Y-m-d 23:59:59', strtotime($to_date)),
                'comments'   => 'Leave request',
                'reason'     => 'No reason, just for testing',
                'status'     => rand(1, 3),
                'created_by' => get_current_user_id(),
                'created_on' => date('Y-m-d H:i:s')
            ];

            $wpdb->insert($wpdb->prefix . 'erp_hr_leave_requests', $data);

            /**
             * Breakdown days for details entry
             */
            $request_id = $wpdb->insert_id;

            $periods = new DatePeriod(
                new DateTime($from_date),
                new DateInterval('P1D'),
                new DateTime($to_date)
            );

            $holidays = erp_hr_leave_get_holiday_between_date_range($from_date, $to_date);

            $dates = [];

            foreach ($periods as $period) {
                $dates[] = $period->format('Y-m-d');
            }

            $applicable_dates = array_diff( $dates, $holidays );

            foreach ($applicable_dates as $applicable_date) {
                $wpdb->insert($wpdb->prefix . 'erp_hr_leaves', [
                    'request_id'    => $request_id,
                    'date'          => $applicable_date,
                    'length_hours'  => '8.00',
                    'length_days'   => '1',
                    'start_time'    => '00:00:00',
                    'end_time'      => '23:59:00',
                    'duration_type' => '1'
                ]);
            }
        }
    }

    /**
     * Get random data
     */
    private function get_random_date($start_date, $end_date)
    {
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        $val = rand($min, $max);

        return date('Y-m-d', $val);
    }

    /**
     * Create holidays
     */
    protected function create_holidays() {
        global $wpdb;

        $date_minus_1 = strtotime(date('Y-m-d') . ' -1 year');
        $prev_year    = date('Y', $date_minus_1);
        $current_year = date('Y');

        $holidays = [
            [
                'title'        => 'Independence Day',
                'start'        => $prev_year . '-02-01 00:00:00',
                'end'          => $prev_year . '-02-01 23:59:59',
                'description'  => 'Independence Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Tax Day',
                'start'        => $prev_year . '-02-09 00:00:00',
                'end'          => $prev_year . '-02-09 23:59:59',
                'description'  => 'Tax Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Thanksgiving Day',
                'start'        => $prev_year . '-03-12 00:00:00',
                'end'          => $prev_year . '-03-14 23:59:59',
                'description'  => 'Thanksgiving Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Election Day',
                'start'        => $prev_year . '-04-04 00:00:00',
                'end'          => $prev_year . '-04-04 23:59:59',
                'description'  => 'Election Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Orthodox Day',
                'start'        => $prev_year . '-05-05 00:00:00',
                'end'          => $prev_year . '-05-05 23:59:59',
                'description'  => 'Orthodox Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Hanukkah Day',
                'start'        => $prev_year . '-05-22 00:00:00',
                'end'          => $prev_year . '-05-22 23:59:59',
                'description'  => 'Hanukkah Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Rosh Hashanah Day',
                'start'        => $prev_year . '-06-06 00:00:00',
                'end'          => $prev_year . '-06-06 23:59:59',
                'description'  => 'Rosh Hashanah Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Lunar Day',
                'start'        => $prev_year . '-07-07 00:00:00',
                'end'          => $prev_year . '-07-07 23:59:59',
                'description'  => 'Lunar Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Yom Kippur',
                'start'        => $prev_year . '-08-22 00:00:00',
                'end'          => $prev_year . '-08-22 23:59:59',
                'description'  => 'Yom Kippur',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Easter',
                'start'        => $current_year . '-02-02 00:00:00',
                'end'          => $current_year . '-02-02 23:59:59',
                'description'  => 'Easter',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Ashura',
                'start'        => $prev_year . '-09-09 00:00:00',
                'end'          => $prev_year . '-09-09 23:59:59',
                'description'  => 'Ashura',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Diwali',
                'start'        => $prev_year . '-10-13 00:00:00',
                'end'          => $prev_year . '-10-13 23:59:59',
                'description'  => 'Diwali',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Holi',
                'start'        => $current_year . '-02-15 00:00:00',
                'end'          => $current_year . '-02-15 23:59:59',
                'description'  => 'Holi',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Ashura',
                'start'        => $prev_year . '-02-17 00:00:00',
                'end'          => $prev_year . '-02-17 23:59:59',
                'description'  => 'Ashura',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Palm Sunday',
                'start'        => $prev_year . '-04-05 00:00:00',
                'end'          => $prev_year . '-04-05 23:59:59',
                'description'  => 'Palm Sunday',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Christmas Eve',
                'start'        => $prev_year . '-05-23 00:00:00',
                'end'          => $prev_year . '-05-23 23:59:59',
                'description'  => 'Christmas Eve',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Palm Sunday',
                'start'        => $current_year . '-01-03 00:00:00',
                'end'          => $current_year . '-01-03 23:59:59',
                'description'  => 'Palm Sunday',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Columbus Day',
                'start'        => $current_year . '-01-17 00:00:00',
                'end'          => $current_year . '-01-17 23:59:59',
                'description'  => 'Columbus Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ],
            [
                'title'        => 'Memorial Day',
                'start'        => $current_year . '-06-06 00:00:00',
                'end'          => $current_year . '-06-06 23:59:59',
                'description'  => 'Memorial Day',
                'range_status' => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]
        ];

        foreach ( $holidays as $holiday ) {
            $wpdb->insert($wpdb->prefix . 'erp_hr_holiday', $holiday);
        }
    }
}
