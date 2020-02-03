<div class="postbox">
    <h3><?php _e( 'Dummy Data Generator', 'erp-dummy' ); ?></h3>

    <div class="inside">
        <p><?php _e( 'Generate dummy data for test purpose', 'erp-dummy' ); ?></p>
        <p><?php _e( '<strong>WARNING!</strong> This will delete ALL existing employees, departments and designations.', 'erp-dummy' ); ?></p>

        <form method="post" action="<?php echo admin_url( 'admin.php?page=erp-tools' ); ?>">
            <?php
            $menus          = get_option( '_erp_admin_menu', array() );
            $adminbar_menus = get_option( '_erp_adminbar_menu', array() );
            ?>
            <p>
                <label><?php _e( 'Number of Employees', 'erp-dummy' ); ?></label>
                <input type="number" name="employee_number" value="20">
            </p>
            <p>
                <label><?php _e( 'Number of Customers', 'erp-dummy' ); ?></label>
                <input type="number" name="customer_number" value="20">
            </p>
            <p>
                <label><?php _e( 'Create Leaves Data', 'erp-dummy' ); ?></label>
                <input type="checkbox" name="create_leaves" value="1" checked />
            </p>

            <?php wp_nonce_field( 'erp-dummy-data-nonce' ); ?>
            <?php submit_button( __( 'Generate Dummy Content', 'erp-dummy' ), 'primary', 'erp_generate_dummy_data' ); ?>
        </form>
    </div><!-- .inside -->
</div><!-- .postbox -->
