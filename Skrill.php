<?php
class Skrill {
	public $settings = array(
		'description' => 'Accept payments via Skrill.',
	);
	function payment_features() {
		return '<img src="data:image/png;base64,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">';	
	}
	function payment_button($params) {
		global $billic, $db;
		$html = '';
		if (get_config('skrill_email') == '') {
			return $html;
		}
		$limit_users_before = get_config('skrill_limit_users_before');
		if (!empty($limit_users_before)) {
			$time = strtotime($limit_users_before);
			if ($billic->user['datecreated']>$time)
				return false;
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
			$html.= '<input type="submit" class="btn btn-default" value="Pay by Skrill">' . PHP_EOL;
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
			echo '<tr><td>Limit Payments</td><td>from users registered before <input type="text" name="skrill_limit_users_before" value="' . safe(get_config('skrill_limit_users_before')). '" placeholder="YYYY-MM-DD" class="form-control" style="max-width: 150px;display:inline">. Leave blank to disable.</td></tr>';
			echo '<tr><td colspan="2" align="center"><input type="submit" class="btn btn-default" name="update" value="Update &raquo;"></td></tr>';
			echo '</table></form>';
		} else {
			$date = explode('-', $_POST['skrill_limit_users_before']);
			if (count($date)==1 && empty($date[0])) {
				// empty date
			} else {
				if (strlen($date[0])!==4 || strlen($date[1])!==2 || strlen($date[2])!==2)
					$billic->errors[] = 'Invalid date';
				elseif (!ctype_digit($date[0]) || $date[0]<1970)
					$billic->errors[] = 'Invalid year';
				elseif (!ctype_digit($date[1]) || $date[1]<1 || $date[1]>12)
					$billic->errors[] = 'Invalid month';
				elseif (!ctype_digit($date[2]) || $date[1]<1 || $date[1]>31)
					$billic->errors[] = 'Invalid day';
				else {
					$daysInMonth = date('t', mktime(0, 0, 1, $date[1], 1, $date[0]));
					if ($date[2]>$daysInMonth)
						$billic->errors[] = "There are only $daysInMonth days in the month";
				}
			}
			if (empty($billic->errors)) {
				set_config('skrill_require_verification', $_POST['skrill_require_verification']);
				set_config('skrill_email', $_POST['skrill_email']);
				set_config('skrill_secret', $_POST['skrill_secret']);
				set_config('paypal_limit_users_before', $_POST['skrill_limit_users_before']);
				$billic->status = 'updated';
			}
		}
	}
}
