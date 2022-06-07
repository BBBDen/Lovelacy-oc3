<?php

class ControllerApiRocketSms extends Controller {
    public function send() {
        $this->load->language('api/rocketsms');
        $json = [];

        if (!isset( $this->session->data['api_id'] )) {
            $json['error']['warning'] = $this->language->get('error_permission');
        } else {
            $json['success']['text'] = "TEXT";
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
}
