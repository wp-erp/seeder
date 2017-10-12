<?php

/**
 * CRM Seeder Class
 */
class WeDevs_ERP_CRM_Seeder {

    function __construct( \Faker\Generator $faker, $count ) {
        $this->faker = $faker;
        $this->count = $count;
        $this->groups = [];
    }

    /**
     * Run the seeder functions
     *
     * @return void
     */
    public function run() {
        $this->truncate_all();
        $this->create_contacts_group();
        $this->create_contacts();
    }

    /**
     * Clear the customers table
     *
     * @return void
     */
    public function truncate_all() {
        global $wpdb;

        // truncate the tables
        $tables = [ 'erp_peoples', 'erp_peoplemeta', 'erp_crm_contact_group', 'erp_crm_contact_subscriber', 'erp_people_type_relations' ];
        foreach ($tables as $table) {
            $wpdb->query( 'TRUNCATE TABLE ' . $wpdb->prefix . $table );
        }
    }

    /**
     * Create Contacts Group
     *
     * @return void
     */
    function create_contacts_group() {
        for ( $i = 0; $i < 5; $i++ ) {
            $data = [
                'name'        => $this->faker->company,
                'description' => $this->faker->sentence,
            ];

            $group = erp_crm_save_contact_group( $data );

            $this->groups[] = $group->id;
        }
    }

    /**
     * Create contacts
     *
     * @return void
     */
    function create_contacts() {

        $genders     = ['male', 'female'];
        $types       = ['contact', 'company'];
        $life_stages = ['customer', 'lead', 'opportunity', 'subscriber'];

        // get WP ERP provided countries, states and currencies
        $erp_countries  = \WeDevs\ERP\Countries::instance();
        $erp_states     = array_filter( $erp_countries->states );
        $countries      = array_keys( $erp_states );
        $currencies     = array_keys( erp_get_currencies() );

        for ( $i = 0; $i < $this->count; $i++ ) {
            shuffle( $genders );
            shuffle( $types );
            shuffle( $life_stages );
            shuffle( $countries );
            shuffle( $currencies );

            $country = $countries[0];

            $states = array_keys( $erp_states[ $country ] );
            shuffle( $states );
            $state = $states[0];

            $currency = $currencies[0];


            $args = array(
                'first_name'  => $this->faker->firstName( $genders[0] ),
                'last_name'   => $this->faker->lastName,
                'email'       => $this->faker->email,
                'company'     => $this->faker->company,
                'phone'       => $this->faker->phoneNumber,
                'mobile'      => '',
                'other'       => '',
                'website'     => $this->faker->url,
                'fax'         => '',
                'notes'       => '',
                'street_1'    => $this->faker->streetAddress,
                'street_2'    => '',
                'city'        => $this->faker->city,
                'state'       => $state,
                'postal_code' => $this->faker->postcode,
                'country'     => $country,
                'currency'    => $currency,
                'type'        => $types[0],
            );

	        $erp_version   = get_option( 'wp_erp_version' );
	        $contact_owner = get_current_user_id() ? get_current_user_id() : '1';
	        $contact_hash  = sha1( microtime() . 'erp-unique-hash-id' . $args['email'] );

	        if ( version_compare( $erp_version, '1.2.7', '>=' ) ) {
		        $args['contact_owner'] = $contact_owner;
		        $args['life_stage']    = $life_stages[0];
		        $args['hash']          = $contact_hash;

		        $contact_id = erp_insert_people( $args );
	        } else {
		        $contact_id = erp_insert_people( $args );
		        erp_people_update_meta( $contact_id, '_assign_crm_agent', $contact_owner );
		        erp_people_update_meta( $contact_id, 'contact_owner', $contact_owner );
		        erp_people_update_meta( $contact_id, 'life_stage', $life_stages[0] );
		        erp_people_update_meta( $contact_id, 'hash', $contact_hash );
	        }


	        // assing contact to a group that created in create_contacts_group method
            shuffle( $this->groups );
            $group = [
                'user_id' => $contact_id,
                'group_id' => $this->groups[0],
            ];

            erp_crm_create_new_contact_subscriber( $group );
        }
    }
}
