<?php

namespace EasyjobAddons;

if ( ! defined( 'WPINC' ) ) {
	die;
}

class EasyjobAddons
{
	public function __construct()
	{
		add_action( 'admin_init', [$this, 'require_parent_plugin'] );


		$filter = new EmailFilter();

		add_action( 'admin_menu', [$this, 'ejaddons_add_admin_menu'] );
		add_action( 'admin_init', [$this, 'ejaddons_settings_init'] );
	}


	function require_parent_plugin()
    {
		if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'easyjob/easyjob.php' ) ) {
			add_action( 'admin_notices', [$this, 'require_parent_plugin_notice'] );

			deactivate_plugins( plugin_basename( __FILE__ ) );

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
	}

	function require_parent_plugin_notice()
    {
		?><div class="error"><p>Das Plugin kann nicht aktiviert werden, da das benötigte Plugin "easyjob Webshop" nicht existiert oder aktiviert ist.</p></div><?php
	}


	function ejaddons_add_admin_menu()
	{
		add_options_page( 'Easyjob Addons', 'Easyjob Addons', 'manage_options', 'ejaddons', [$this, 'ejaddons_options_page'] );
	}


	function ejaddons_settings_init()
	{

		register_setting( 'pluginPage', 'ejaddons_settings' );

		add_settings_section(
			'ejaddons_pluginPage_section',
			__( 'E-Mails', 'ejaddons' ),
			[$this, 'ejaddons_settings_section_callback'],
			'pluginPage'
		);

		add_settings_field(
			'ejaddons_text_field_email_prefix',
			__( 'E-Mail Betreff-Prefix', 'ejaddons' ),
			[$this, 'ejaddons_text_field_email_prefix_render'],
			'pluginPage',
			'ejaddons_pluginPage_section'
		);

		add_settings_field(
			'ejaddons_checkbox_field_timeframe',
			__( 'Zeige den angefragten Zeitraum im Betreff', 'ejaddons' ),
			[$this, 'ejaddons_checkbox_field_timeframe_render'],
			'pluginPage',
			'ejaddons_pluginPage_section'
		);

		add_settings_field(
			'ejaddons_checkbox_field_customer_name',
			__( 'Zeige den Namen des Kundens im Betreff', 'ejaddons' ),
			[$this, 'ejaddons_checkbox_field_customer_name_render'],
			'pluginPage',
			'ejaddons_pluginPage_section'
		);


	}


	function ejaddons_text_field_email_prefix_render(  ) {

		$options = get_option( 'ejaddons_settings' );
		?>
		<input type='text' name='ejaddons_settings[ejaddons_text_field_email_prefix]' value='<?php echo $options['ejaddons_text_field_email_prefix']; ?>'>
		<?php

	}


	function ejaddons_checkbox_field_timeframe_render(  ) {

		$options = get_option( 'ejaddons_settings' );
		?>
		<input type='checkbox' name='ejaddons_settings[ejaddons_checkbox_field_timeframe]' <?php checked( $options['ejaddons_checkbox_field_timeframe'], 1 ); ?> value='1'>
		<?php

	}


	function ejaddons_checkbox_field_customer_name_render(  ) {

		$options = get_option( 'ejaddons_settings' );
		?>
		<input type='checkbox' name='ejaddons_settings[ejaddons_checkbox_field_customer_name]' <?php checked( $options['ejaddons_checkbox_field_customer_name'], 1 ); ?> value='1'>
		<?php

	}


	function ejaddons_settings_section_callback(  ) {

		echo __( 'Hier können Sie die Ausgabe der Easyjob E-Mails anpassen.', 'ejaddons' );

	}


	function ejaddons_options_page(  ) {

		?>
		<form action='options.php' method='post'>

			<h2>Easyjob Addons</h2>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
		<i>"easyjob" ist eine Marke der <a href="https://www.protonic-software.com" rel="noreferrer">protonic software GmbH</a>.<br>Das Plugin wird von diesem Unternehmen weder unterstützt oder entwickelt.</i>
		<?php

	}


}