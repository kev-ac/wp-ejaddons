<?php

namespace EasyjobAddons;

if ( ! defined( 'WPINC' ) ) {
	die;
}

class EmailFilter
{
	public function __construct()
	{
		add_filter( 'woocommerce_email_subject_easyjob_new_order', [$this, 'register_woocommerce_email_subject_filter'], 10, 2 );
	}

	public function register_woocommerce_email_subject_filter($subject, $order)
	{
		$settings = get_option( 'ejaddons_settings' );

		$subject = "";

		if(array_key_exists("ejaddons_text_field_email_prefix", $settings) && false === empty($settings['ejaddons_text_field_email_prefix']))
		{
			$subject .= sanitize_text_field($settings['ejaddons_text_field_email_prefix']);
		}
		else
		{
			$subject = "Neue Webshop-Bestellung";
		}


		if(array_key_exists("ejaddons_checkbox_field_customer_name", $settings))
		{
			if($settings['ejaddons_checkbox_field_customer_name'] === '1')
			{
				$name = $order->get_formatted_billing_full_name();
				if(!empty($name))
				{
					$subject .= " von {$name}";
				}
			}
		}

		if(array_key_exists("ejaddons_checkbox_field_timeframe", $settings))
		{
			if($settings['ejaddons_checkbox_field_timeframe'] === '1')
			{
				$projectFrom = $order->get_meta("custom_field_project_from", true);
				$projectTo = $order->get_meta("custom_field_project_to", true);
				if(!empty($projectFrom))
				{
					$subject .= " (Zeitraum: {$projectFrom} - {$projectTo})";
				}
			}
		}

		return $subject;
	}
}