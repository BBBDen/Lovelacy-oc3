<?php
class ModelAccountCustomer extends Model {
    public function addCustomer($data) {
        if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
            $customer_group_id = $data['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $this->load->model('account/customer_group');

        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

        $language_id = isset($data['language_id']) ? (int)$data['language_id'] : (int)$this->config->get('config_language_id');

        $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', language_id = '" . $language_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW()");

        $customer_id = $this->db->getLastId();

	    // remarketing all in one
		$this->load->model('tool/remarketing');
		if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
		if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
			$facebook_data['event_name'] = 'CompleteRegistration';
			$fb_time = time();
			$facebook_data['custom_data'] = [
				'status' => true,
				'currency' => $this->config->get('remarketing_facebook_currency'),
				'value' => 1
			];
			$facebook_data['time'] = $fb_time;
			
			$this->model_tool_remarketing->sendFacebook($facebook_data);
		}
		
		if ($this->config->get('remarketing_esputnik_status') && $customer_id) {
			if (isset($data['newsletter']) && $data['newsletter']) {
				$create_contact_url = 'https://esputnik.com/api/v1/contact/subscribe';
				$json_contact_value = new stdClass();
				$contact = new stdClass();
				$contact->firstName = $data['firstname'];
				$contact->lastName = $data['lastname'];
				$contact->contactKey = $customer_id;
				$contact->id = $customer_id;
				$contact->channels = [['type'=>'email', 'value' => $data['email']],['type'=>'sms', 'value' => $data['telephone']]];
				$contact->groups = [['name'=>'Web Site']];
				$json_contact_value->contact = $contact;
				$json_contact_value->groups = ['Subscribers'];
				$this->model_tool_remarketing->sendEsputnik($json_contact_value, $create_contact_url);
			} else {
				$create_contact_url = 'https://esputnik.com/api/v1/contact';
				$contact = new stdClass();
				$contact->firstName = $data['firstname'];
				$contact->lastName = $data['lastname'];
				$contact->contactKey = $customer_id;
				$contact->id = $customer_id;
				$contact->channels = [['type'=>'email', 'value' => $data['email']],['type'=>'sms', 'value' => $data['telephone']]];
				$contact->groups = [['name'=>'Web Site']];
				$this->model_tool_remarketing->sendEsputnik($contact, $create_contact_url);
			}
		}
		}
		

        if ($customer_group_info['approval']) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "customer_approval` SET customer_id = '" . (int)$customer_id . "', type = 'customer', date_added = NOW()");
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "customer_additional_info SET customer_id = '". (int)$customer_id ."', social_nick = '". (isset($data['social_nick']) ? $this->db->escape($data['social_nick']) : '') ."', birthday = '" . (isset($data['birthday']) ? $data['birthday'] : null) . "', country = '". (isset($data['country']) ? $this->db->escape($data['country']) : null) ."', city = '". ( isset($data['city']) ? $this->db->escape($data['city']) : null ) ."', street = '". ( isset($data['street']) ? $this->db->escape($data['street']) : null ) ."', house = '". ( isset($data['house']) ? $this->db->escape($data['house']) : null ) ."', building = '". ( isset($data['building']) ? $this->db->escape($data['building']) : null ) ."', flat = '". ( isset($data['flat']) ? $this->db->escape($data['flat']) : null ) ."'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '". (int)$customer_id ."', firstname = '" . $data['firstname'] . "', lastname = '". (isset($data['lastname']) ? $this->db->escape($data['lastname']) : '') ."', city = '". ( isset($data['city']) ? $this->db->escape($data['city']) : '' ) ."', company = '". ( isset($data['company']) ? $this->db->escape($data['company']) : '' ) ."', address_1 = '". ( isset($data['street']) ? $this->db->escape($data['street']) . (( isset($data['flat']) ? ' ' . $this->db->escape($data['flat']) : '' )) : '' ) ."', address_2 = '". ( isset($data['address_2']) ? $this->db->escape($data['address_2']) : '' ) ."', country_id = '". ( isset($data['country_id']) ? (int)$data['country_id'] : 0 ) ."', postcode = '". ( isset($data['postcode']) ? $this->db->escape($data['postcode']) : 0 ) ."', zone_id = '". ( isset($data['zone_id']) ? (int)$data['zone_id'] : 0 ) ."', custom_field = '". ( isset($data['custom_field']) ? $this->db->escape($data['custom_field']) : '' ) ."'");

        $address_id = $this->db->getLastId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '". (int)$address_id ."' WHERE customer_id = '". (int)$customer_id ."'");

        return $customer_id;
    }

    public function editAddress($customer_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "customer_additional_info SET country = '". $this->db->escape($data['country']) ."', city = '". $this->db->escape($data['city']) ."', street = '". $this->db->escape($data['street']) ."', house = '". $this->db->escape($data['house']) ."', building = '". ( isset($data['building']) ? $this->db->escape($data['building']) : null ) ."', flat = '". ( isset($data['flat']) ? $this->db->escape($data['flat']) : null ) ."' WHERE customer_id = '". (int)$customer_id ."'");

        $address = $this->db->query("SELECT address_id FROM " . DB_PREFIX . "address WHERE customer_id = '". (int)$customer_id ."'");

        if ($address->num_rows) {
            $this->db->query("UPDATE " . DB_PREFIX . "address SET city = '". ( isset($data['city']) ? $this->db->escape($data['city']) : '' ) ."', address_1 = '". ( isset($data['street']) ? $this->db->escape($data['street']) . ((isset($data['house'])) ? ' ' . $this->db->escape($data['house']) : '') . (( isset($data['flat']) ? ' ' . $this->db->escape($data['flat']) : '' )) : '' ) ."', address_2 = '". ( isset($data['address_2']) ? $this->db->escape($data['address_2']) : '' ) ."', country_id = '". ( isset($data['country_id']) ? (int)$data['country_id'] : 0 ) ."', postcode = '". ( isset($data['postcode']) ? $this->db->escape($data['postcode']) : 0 ) ."', zone_id = '". ( isset($data['zone_id']) ? (int)$data['zone_id'] : 0 ) ."', custom_field = '". ( isset($data['custom_field']) ? $this->db->escape($data['custom_field']) : '' ) ."' WHERE customer_id = '". (int)$customer_id ."'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '". (int)$customer_id ."'");
            $customer = $query->rows;
            $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '". (int)$customer_id ."', firstname = '" . $customer['firstname'] . "', lastname = '". $customer['lastname'] ."', city = '". ( isset($data['city']) ? $this->db->escape($data['city']) : '' ) ."', company = '". ( isset($data['company']) ? $this->db->escape($data['company']) : '' ) ."', address_1 = '". ( isset($data['street']) ? $this->db->escape($data['street']) . ((isset($data['house'])) ? ' ' . $this->db->escape($data['house']) : '') . (( isset($data['flat']) ? ' ' . $this->db->escape($data['flat']) : '' )) : '' ) ."', address_2 = '". ( isset($data['address_2']) ? $this->db->escape($data['address_2']) : '' ) ."', country_id = '". ( isset($data['country_id']) ? (int)$data['country_id'] : 0 ) ."', postcode = '". ( isset($data['postcode']) ? $this->db->escape($data['postcode']) : 0 ) ."', zone_id = '". ( isset($data['zone_id']) ? (int)$data['zone_id'] : 0 ) ."', custom_field = '". ( isset($data['custom_field']) ? $this->db->escape($data['custom_field']) : '' ) ."'");
            $address_id = $this->db->getLastId();

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '". (int)$address_id ."' WHERE customer_id = '". (int)$customer_id ."'");
        }
    }

    public function editCustomer($customer_id, $data) {

		/* NeoSeo Exchange 1c - begin */
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET `updated` = 1 WHERE customer_id = '" . (int)$customer_id . "'");
		/* NeoSeo Exchange 1c - end */

        /* NeoSeo Exchange 1c - begin */
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET `updated` = 1 WHERE customer_id = '" . (int)$customer_id . "'");
        /* NeoSeo Exchange 1c - end */
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET customer_group_id = '". (int)$data['customer_group_id'] ."', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "', newsletter = '". (int)$data['newsletter'] ."' WHERE customer_id = '" . (int)$customer_id . "'");
        $this->db->query("UPDATE " . DB_PREFIX . "customer_additional_info SET birthday = '".(isset($data['birthday']) ? $this->db->escape($data['birthday']) : null)."', social_nick = '".(isset($data['social_nick']) ? $this->db->escape($data['social_nick']) : '')."' WHERE customer_id = '".(int)$customer_id."'");
    }

    public function editPassword($email, $password) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', code = '' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
    }

    public function editPasswordAndResetToken($email, $password) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', code = '', token = '' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
    }


    public function editAddressId($customer_id, $address_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
    }

    public function editCode($email, $code) {
        $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET code = '" . $this->db->escape($code) . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
    }

    public function editCodeFromResetPassword($phone, $code, $token) {
        $telephone = utf8_strtolower(str_replace(['+', '_', '-', '(', ')', '=', '№', '#', '$', '%', ' '], '', $phone));
        $telephone2 = str_replace('375', '', $telephone);
        $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET code = '" . $this->db->escape($code) . "', token = '". $this->db->escape($token) ."' WHERE LCASE(telephone) = '" . $this->db->escape(utf8_strtolower($telephone)) . "' OR LCASE(telephone) = '+" . $this->db->escape(utf8_strtolower($telephone)) . "' OR LCASE(telephone) = '" . $this->db->escape(utf8_strtolower($telephone2)) . "'");
    }

    public function editNewsletter($newsletter) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
    }

    public function getCustomer($customer_id) {
        $query = $this->db->query("SELECT c.*, ci.birthday, ci.social_nick, ci.country AS country_id, (SELECT name FROM ". DB_PREFIX ."country WHERE country_id = ci.country) AS country, ci.city AS zone_id, (SELECT name FROM ". DB_PREFIX ."zone WHERE zone_id = ci.city) AS city, ci.street, ci.house, ci.building, ci.flat FROM " . DB_PREFIX . "customer as c LEFT JOIN " . DB_PREFIX . "customer_additional_info as ci ON (c.customer_id = ci.customer_id) WHERE c.customer_id = '" . (int)$customer_id . "'");

        return $query->row;
    }

    public function getCustomerByEmail($email) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

        return $query->row;
    }

    public function getCustomerByPhone($phone) {
        $telephone = utf8_strtolower(str_replace(['+', '_', '-', '(', ')', '=', '№', '#', '$', '%', ' '], '', $phone));
        $telephone2 = str_replace('375', '', $telephone);
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(telephone) = '" . $this->db->escape($telephone) . "' OR LOWER(telephone) = '+" . $this->db->escape($telephone) . "' OR LOWER(telephone) = '". $this->db->escape($telephone2) ."'");

        return $query->row;
    }

    public function getCustomerInfo($customer_id = 0)
    {
        if ($customer_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_subscribe_info WHERE customer_id = '". (int)$customer_id ."'");
            return $query->num_rows ? $query->row : [];
        }

        return [];
    }

    public function getBePayedCustomerId($customer_id)
    {
        $query = $this->db->query("SELECT bepayed_customer_id AS id, bepayed_sbs_id, pay_status FROM " . DB_PREFIX . "card_subscribe_info WHERE customer_id = '". (int)$customer_id ."' LIMIT 1");
        return $query->row;
    }

    public function saveInfo($params = [])
    {
        $data = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_subscribe_info WHERE customer_id = '". (int)$params['customer_id'] ."'");
        if ($data->num_rows > 0) {
            $this->db->query("UPDATE " . DB_PREFIX . "card_subscribe_info SET customer_id = '". (int)$params['customer_id'] ."', user_data = '". $this->db->escape($params['user_data']) ."' WHERE customer_id = '". (int)$params['customer_id'] ."'");
        } else {
            $sql = '';
            if (array_key_exists('bepayed_customer_id', $params)) {
                $sql .= ", bepayed_customer_id = '". $this->db->escape($params['bepayed_customer_id']) ."'";
            }

            if (array_key_exists('bepayed_sbs_id', $params)) {
                $sql .= ", bepayed_sbs_id = '". $this->db->escape($params['bepayed_sbs_id']) ."'";
            }
            $this->db->query("INSERT INTO " . DB_PREFIX . "card_subscribe_info SET customer_id = '". (int)$params['customer_id'] ."', user_data = '". $this->db->escape($params['user_data']) ."'" . $sql);
        }
    }

    public function getCustomerSubscribeId($customer_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_subscribe_info WHERE customer_id = '". (int)$customer_id ."' LIMIT 1");
        return $query->row;
    }

    public function updateCustomerSubscribeInfo($customer_id, $status)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "card_subscribe_info SET pay_status = '". $this->db->escape($status) ."' WHERE customer_id = '". (int)$customer_id ."'");
    }


    public function checkSubscriber($data) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($data['email'])) . "' AND customer_group_id = '". (int)$data['customer_group_id'] ."'");

        return $query->num_rows > 0 ? true : false;
    }

    public function getCustomerByCode($code) {
        $query = $this->db->query("SELECT customer_id, firstname, lastname, email FROM `" . DB_PREFIX . "customer` WHERE code = '" . $this->db->escape($code) . "' AND code != ''");

        return $query->row;
    }

    public function getCustomerByTokenId($token) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

        return $query->row;
    }

    public function getCustomerByToken($token) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");

        return $query->row;
    }

    public function getTotalCustomersByEmail($email) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

        return $query->row['total'];
    }

    public function addTransaction($customer_id, $description, $amount = '', $order_id = 0) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$customer_id . "', order_id = '" . (float)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', date_added = NOW()");
    }

    public function deleteTransactionByOrderId($order_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");
    }

    public function getTransactionTotal($customer_id) {
        $query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'");

        return $query->row['total'];
    }

    public function getTotalTransactionsByOrderId($order_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");

        return $query->row['total'];
    }

    public function getRewardTotal($customer_id) {
        $query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");

        return $query->row['total'];
    }

    public function getIps($customer_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");

        return $query->rows;
    }

    public function addLoginAttempt($email) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

        if (!$query->num_rows) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_login SET email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
        } else {
            $this->db->query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
        }
    }

    public function addLoginAttemptPhone($phone) {
        $query = $this->db->query("SELECT cl.* FROM " . DB_PREFIX . "customer as c LEFT JOIN ".DB_PREFIX."customer_login as cl ON (c.email = cl.email) WHERE (c.telephone = '" . $this->db->escape(utf8_strtolower((string)$phone)) . "' OR c.telephone = '" . $this->db->escape(utf8_strtolower((string)$phone)) . "') AND cl.ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

        if ($query->num_rows) {
            $this->db->query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
        }
    }

    public function getLoginAttempts($email) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");

        return $query->row;
    }

    public function getLoginAttemptsByPhone($phone) {
        $query = $this->db->query("SELECT cl.* FROM `" . DB_PREFIX . "customer_login` as cl LEFT JOIN `".DB_PREFIX."customer` as c ON (c.email = cl.email) WHERE c.telephone = '" . $this->db->escape(utf8_strtolower($phone)) . "' OR  c.telephone = '+" . $this->db->escape(utf8_strtolower($phone)) . "'");

        return $query->row;
    }

    public function deleteLoginAttempts($email) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");
    }

    public function deleteLoginAttemptsPhone($phone) {
        return;
    }

    public function addAffiliate($customer_id, $data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "customer_affiliate SET `customer_id` = '" . (int)$customer_id . "', `company` = '" . $this->db->escape($data['company']) . "', `website` = '" . $this->db->escape($data['website']) . "', `tracking` = '" . $this->db->escape(token(64)) . "', `commission` = '" . (float)$this->config->get('config_affiliate_commission') . "', `tax` = '" . $this->db->escape($data['tax']) . "', `payment` = '" . $this->db->escape($data['payment']) . "', `cheque` = '" . $this->db->escape($data['cheque']) . "', `paypal` = '" . $this->db->escape($data['paypal']) . "', `bank_name` = '" . $this->db->escape($data['bank_name']) . "', `bank_branch_number` = '" . $this->db->escape($data['bank_branch_number']) . "', `bank_swift_code` = '" . $this->db->escape($data['bank_swift_code']) . "', `bank_account_name` = '" . $this->db->escape($data['bank_account_name']) . "', `bank_account_number` = '" . $this->db->escape($data['bank_account_number']) . "', `status` = '" . (int)!$this->config->get('config_affiliate_approval') . "'");

        if ($this->config->get('config_affiliate_approval')) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "customer_approval` SET customer_id = '" . (int)$customer_id . "', type = 'affiliate', date_added = NOW()");
        }
    }

    public function editAffiliate($customer_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer_affiliate SET `company` = '" . $this->db->escape($data['company']) . "', `website` = '" . $this->db->escape($data['website']) . "', `commission` = '" . (float)$this->config->get('config_affiliate_commission') . "', `tax` = '" . $this->db->escape($data['tax']) . "', `payment` = '" . $this->db->escape($data['payment']) . "', `cheque` = '" . $this->db->escape($data['cheque']) . "', `paypal` = '" . $this->db->escape($data['paypal']) . "', `bank_name` = '" . $this->db->escape($data['bank_name']) . "', `bank_branch_number` = '" . $this->db->escape($data['bank_branch_number']) . "', `bank_swift_code` = '" . $this->db->escape($data['bank_swift_code']) . "', `bank_account_name` = '" . $this->db->escape($data['bank_account_name']) . "', `bank_account_number` = '" . $this->db->escape($data['bank_account_number']) . "' WHERE `customer_id` = '" . (int)$customer_id . "'");
    }

    public function getAffiliate($customer_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_affiliate` WHERE `customer_id` = '" . (int)$customer_id . "'");

        return $query->row;
    }

    public function getAffiliateByTracking($tracking) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_affiliate` WHERE `tracking` = '" . $this->db->escape($tracking) . "'");

        return $query->row;
    }
}
