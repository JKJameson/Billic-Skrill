<?php
class Skrill {
	public $settings = array(
		'description' => 'Accept payments via Skrill.',
	);
	function payment_button($params) {
		global $billic, $db;
		$html = '';
		if (get_config('skrill_email') == '') {
			return $html;
		}
		if ($billic->user['verified'] == 0 && get_config('skrill_require_verification') == 1) {
			return 'verify';
		} else {
			$html.= '<form action="https://www.moneybookers.com/app/payment.pl">' . PHP_EOL;
			$html.= '<input type="hidden" name="pay_to_email" value="' . get_config('skrill_email') . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="pay_from_email" value="' . $billic->user['email'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="language" value="EN">' . PHP_EOL;
			$html.= '<input type="hidden" name="amount" value="' . $params['charge'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="currency" value="' . get_config('billic_currency_code') . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="recipient_description" value="' . get_config('billic_companyname') . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="detail1_description" value="Invoice #' . $params['invoice']['id'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="detail1_text" value="' . $params['invoice']['id'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="return_url" value="http' . (get_config('billic_ssl') == 1 ? 's' : '') . '://' . get_config('billic_domain') . '/User/Invoices/ID/' . $params['invoice']['id'] . '/Status/Complete/">' . PHP_EOL;
			$html.= '<input type="hidden" name="cancel_url" value="http' . (get_config('billic_ssl') == 1 ? 's' : '') . '://' . get_config('billic_domain') . '/User/Invoices/ID/' . $params['invoice']['id'] . '/Status/Cancelled/">' . PHP_EOL;
			$html.= '<input type="hidden" name="status_url" value="http' . (get_config('billic_ssl') == 1 ? 's' : '') . '://' . get_config('billic_domain') . '/Gateway/Skrill/">' . PHP_EOL;
			$html.= '<input type="hidden" name="transaction_id" value="' . $params['invoice']['id'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="firstname" value="' . $billic->user['firstname'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="lastname" value="' . $billic->user['lastname'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="address" value="' . $billic->user['address1'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="city" value="' . $billic->user['city'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="state" value="' . $billic->user['state'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="postal_code" value="' . $billic->user['postcode'] . '">' . PHP_EOL;
			$html.= '<input type="submit" class="btn btn-default" value="Skrill">' . PHP_EOL;
			$html.= '</form>' . PHP_EOL;
		}
		return $html;
	}
	function payment_callback() {
		global $billic, $db;
		$concatFields = $_POST['merchant_id'] . $_POST['transaction_id'] . strtoupper(md5(get_config('skrill_secret'))) . $_POST['mb_amount'] . $_POST['mb_currency'] . $_POST['status'];
		// Ensure the signature is valid, the status code == 2,
		// and that the money is going to you
		if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == get_config('skrill_email')) { // Valid transaction.
			$billic->module('Invoices');
			return $billic->modules['Invoices']->addpayment(array(
				'gateway' => 'Skrill',
				'invoiceid' => $_POST['transaction_id'],
				'amount' => $_POST['amount'],
				'currency' => $_POST['currency'],
				'transactionid' => $_POST['mb_transaction_id'],
			));
		} else {
			return 'invalid transaction hash';
		}
	}
	function settings($array) {
		global $billic, $db;
		if (empty($_POST['update'])) {
			echo '<form method="POST"><input type="hidden" name="billic_ajax_module" value="Skrill"><table class="table table-striped">';
			echo '<tr><th>Setting</th><th>Value</th></tr>';
			echo '<tr><td>Require Verification</td><td><input type="checkbox" name="skrill_require_verification" value="1"' . (get_config('skrill_require_verification') == 1 ? ' checked' : '') . '></td></tr>';
			echo '<tr><td>Skrill Email</td><td><input type="text" class="form-control" name="skrill_email" value="' . safe(get_config('skrill_email')) . '"></td></tr>';
			echo '<tr><td>Skrill Secret</td><td><input type="text" class="form-control" name="skrill_secret" value="' . safe(get_config('skrill_secret')) . '"></td></tr>';
			echo '<tr><td colspan="2" align="center"><input type="submit" class="btn btn-default" name="update" value="Update &raquo;"></td></tr>';
			echo '</table></form>';
		} else {
			if (empty($billic->errors)) {
				set_config('skrill_require_verification', $_POST['skrill_require_verification']);
				set_config('skrill_email', $_POST['skrill_email']);
				set_config('skrill_secret', $_POST['skrill_secret']);
				$billic->status = 'updated';
			}
		}
	}
}
