<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Model class
*/
abstract class Model {
    const COLOR_FILTER_GROUP = 1;

	protected $registry;

	const ELECTRONIC_CERTIFICATE = 'E';
	const COUPON_DISCOUNT = 'C';

	const COUPON_TYPE_GIFT = 'G';
	const COUPON_TYPE_FIX = 'F';
	const COUPON_TYPE_PERCENT = 'P';

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

	protected function __get_product_certificate_id__()
    {
        return 50;
    }

    protected function __get_url_api__($code)
    {
        return "https://www.nbrb.by/api/exrates/rates/{$code}?parammode=2";
    }

    protected function __curl_handler__($url, $headers = [], $method = 'POST', $params = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if ($method === 'POST' && $params) {
            $data = http_build_query($params);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $result = curl_exec($curl);

        if (curl_errno($curl)) {
            return json_encode(['error' => curl_error($curl)]);
        }

        curl_close($curl);

        return $result;
    }

    protected function __get_converted_currency__($api_url, $coast, $code = 'rub')
    {
        $result = json_decode($this->__curl_handler__($api_url), true);
        $result_coast = $this->currency->format($coast, $this->session->data['currency']);
        if (isset($result['Cur_OfficialRate'])) {
            $national_bank_exchange_rate = (float)$result['Cur_OfficialRate'];
            if ($code === 'rub') {
                $result_coast = number_format(((float)$coast / (float)$national_bank_exchange_rate * 100), 2) . ' ' . $result['Cur_Abbreviation'];
            } else if ($code === 'usd') {
                $result_coast = number_format((float)$coast / (float)$national_bank_exchange_rate, 2) . ' ' . $result['Cur_Abbreviation'];
            }
        }

        return $result_coast;
    }
}
