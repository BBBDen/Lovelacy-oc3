<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Controller class
*/
abstract class Controller {
	protected $registry;
	const AUTH_DATA = [
	    'login' => BEPAY_LOGIN,
        'password' => BEPAY_PASSWORD
    ];

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

	public function __get_main_category_id__()
    {
        return 59;
    }

    public function __get_category_id__()
    {
        return [
            'underwear' => 66,
            'accessories' => 72,
            'dress' => 74,
            'swimwear' => 71,
            'sales' => 65,
        ];
    }

    public function __get_product_attribute__()
    {
        return 7;
    }

    public function __get_countries_id__()
    {
        return [
            'belarus' => 20,
            'russia' => 176
        ];
    }

    public function __get_cities_id__()
    {
        return [
            'minsk' => 339,
            'moscow' => 2761,
        ];
    }

    public function __get_certificate_product_id__()
    {
        return 50;
    }

    public function __get_code_payment__()
    {
        return 'cod';
    }

    public function __get_bank_transfer_payment__()
    {
        return 'begateway';
    }

    public function __get_percent__($price, $special)
    {
        return round((100 - (($special * 100) / $price)), 2);
    }

    public function __get_deprecated_symbols__($symbols = '')
    {
        if (strtolower(gettype($symbols)) === 'string') {
            $symbols = explode(',', $symbols);
        }
        $deprecated_symbols = ['+', ' ', '(', ')', '_', '-', '@', '!', '.', ',', '#', '№', '%', '^', ':', '"', '\'', '*', '[', '{', ']', '}'];
        return array_merge($deprecated_symbols, $symbols);
    }

    public function __is_mobile__()
    {
        if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
            $is_mobile = false;
        } elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Silk/' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Kindle' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' ) !== false ) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }

        return $is_mobile;
    }

    public function __get_option_size_id__()
    {
        return 15;
    }

    public function println($str)
    {
        if (array_key_exists('user_id', $this->session->data) && (int)$this->session->data['user_id'] === 1) {
            debug($str);
        }
    }

    public function curlHandler($url, $headers = [], $method = 'POST', $params = null)
    {
        $curl = curl_init();
        if ($params && array_key_exists('auth_data', $params)) {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $params['auth_data']['login'] . ":" . $params['auth_data']['password']);
        }
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
}
