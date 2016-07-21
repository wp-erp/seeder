<?php
/**
 * WeDevs_ERP_HR_Seeder_Commands class
 */
class WeDevs_ERP_HR_Seeder_Commands extends WP_CLI_Command {

    /**
     * Truncate the tables
     *
     * ## EXAMPLES
     *
     *     wp erp-seeder truncate customer
     *
     * @synopsis <name>
     */
    public function truncate( $args ) {
        list( $name ) = $args;
        $type         = strtolower( $name );

        global $wpdb;

        if ( $name == 'employee' ) {
            $tables = [ 'erp_hr_depts', 'erp_hr_designations', 'erp_hr_employees' ];
        } else {
            $tables = [ 'erp_peoples', 'erp_peoplemeta', 'erp_crm_contact_group', 'erp_crm_contact_subscriber' ];
        }

        foreach ( $tables as $table ) {
            $wpdb->query( 'TRUNCATE TABLE ' . $wpdb->prefix . $table);
        }

        WP_CLI::success( "Tables are successfully truncated!" );
    }

    /**
     * Seed the tables
     *
     * ## EXAMPLES
     *
     *     wp erp-seeder seed customer --num=2000
     *
     * @synopsis <name> [--num=<number>]
     */
    public function seed( $args, $assoc_args ) {
        list( $name ) = $args;
        $type         = strtolower( $name );
        $number       = isset( $assoc_args['num'] ) ? $assoc_args['num'] : 0;

        erp_seeder()->run_seeder_from_cli( $type, $number );

        WP_CLI::success( "Tables are successfully seeded!" );
    }
}

WP_CLI::add_command( 'erp-seeder', 'WeDevs_ERP_HR_Seeder_Commands' );