<?php

class ControllerApiRocketSms extends Controller {
    private $errors = [];

    public function send() {
        $this->load->language('api/rocketsms');
        $json = [];

        if (!isset( $this->session->data['api_id'] )) {
            $json['success'] = false;
            $json['error']['warning'] = $this->language->get('error_permission');
        } else {
            $this->load->model('account/customer');

            $validate = $this->validate($this->request->post);
            if ($validate === false) {
                $json['success'] = false;
                $json['errors'] = $this->errors;
            } else {
                $this->customer->logout();
                $this->cart->clear();

                unset($this->session->data['order_id']);
                unset($this->session->data['payment_address']);
                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);
                unset($this->session->data['shipping_address']);
                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
                unset($this->session->data['comment']);
                unset($this->session->data['coupon']);
                unset($this->session->data['reward']);
                unset($this->session->data['voucher']);
                unset($this->session->data['vouchers']);

                $token = token(40);
                $code = rand(10,10000);
                $phone = '375' . str_replace(['+', '375', ' ', '(', ')', '-', '_', '#'], '', $this->request->post['phone']);
                $this->model_account_customer->editCodeFromResetPassword($phone, $code, $token);
                $sender = '';
                $message = sprintf($this->language->get('sms_message'), $code);

                $res = @json_decode($this->_read_url('http://api.rocketsms.by/simple/send?username='.ROCKET_AUTH_LOGIN.'&password='.ROCKET_AUTH_PASSWORD . '&phone='.$phone.'&text='.urlencode(html_entity_decode(str_replace('\n', "\n", $message), ENT_QUOTES, 'UTF-8')) . '&priority=' . true . ($sender ? '&sender='.urlencode($sender) : '')), true);

//                $json['success'] = true;
//                $json['sms_phone'] = $phone;
//                $json['answer'] = $this->language->get('text_enter_message');

                $log = fopen(DIR_LOGS . 'rocketsms.log', 'w');
                $log_message = "************************************\n";

                if ($res && array_key_exists('id', $res)) {

                    $log_message .= ($res ? $res['id'] : 0)."\nusername=". ROCKET_AUTH_LOGIN ."\npassword=". ROCKET_AUTH_PASSWORD ."\nphone=". $phone ."\nsender=". $sender ."\ntext=" . $message;
                    $json['success'] = true;
                    $json['sms_phone'] = $phone;
                    $json['answer'] = $this->language->get('text_enter_message');

                } else if ($res && array_key_exists('error', $res)) {
                    $json['success'] = false;
                    $log_message .= "Error occurred while sending message. Error ID: " . $res['error'];
                    $json['answer'] = "Error occurred while sending message. Error ID: " . $res['error'];
                } else {
                    $json['answer'] = false;
                    $log_message .= "Server Error!";
                }
                $log_message .= "\n************************************\n";
                fwrite($log, $log_message);
                fclose($log);
            }
        }

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function verify() {
        $this->load->language('api/rocketsms');
        $json = [];
        if (!isset( $this->session->data['api_id'] )) {
            $json['success'] = false;
            $json['error']['warning'] = $this->language->get('error_permission');
        } else {
            $this->load->model('account/customer');
            $customer = $this->model_account_customer->getCustomerByPhone($this->request->post['phone']);

            if (!$customer) {
                $json['success'] = false;
                $json['answer'] = $this->language->get('error_verify_customer');
            } else {
                $code = (int)$customer['code'];

                if ($code !== (int)$this->request->post['code']) {
                    $json['success'] = false;
                    $json['answer'] = $this->language->get('error_verify_code');
                } else {
                    $json['success'] = true;
                    $json['answer'] = '/forgot-password?token=' . $customer['token'];
                }
            }
        }
        $json['post'] = $this->request->post;

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function validate($post) {
        if (!array_key_exists('phone', $post) || mb_strlen($post['phone']) === 0) {
            $this->errors['phone'] = $this->language->get('phone_error_empty');
        } else if (!preg_match('/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){9,14}(\s*)?$/', $post['phone'])) {
            $this->errors['phone'] = $this->language->get('phone_error');
        } else if (!$this->model_account_customer->getCustomerByPhone($post['phone'])) {
            $this->errors['phone'] = $this->language->get('phone_error_isset');
        }

        return !$this->errors;
    }

    private function _read_url($url) {

        $ret = "";

        if (function_exists("curl_init")) {

            $c = curl_init();
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($c, CURLOPT_TIMEOUT, 10);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($c, CURLOPT_URL, $url);

            $ret = curl_exec($c);
        } elseif (function_exists("fsockopen") && strncmp($url, 'http:', 5) == 0) { // not https
            $m = parse_url($url);

            $fp = fsockopen($m["host"], 80, $errno, $errstr, 10);

            if ($fp) {
                fwrite($fp, "GET $m[path]?$m[query] HTTP/1.1\r\nHost: api.rocketsms.by\r\nUser-Agent: PHP\r\nConnection: Close\r\n\r\n");

                while (!feof($fp))
                    $ret = fgets($fp, 1024);

                fclose($fp);
            }
        } else {
            $ret = file_get_contents($url);
        }

        return $ret;
    }
}
