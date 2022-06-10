<?php
class ControllerApiSubscribers extends Controller {
    public function index() {
        $json = array();
        $subs_informations = [];

        if (!isset($this->session->data['api_id'])) {
            $json['error']['warning'] = $this->language->get('error_permission');
        } else {
            // load model
           $auth_data = self::AUTH_DATA;
           $this->load->model('account/customer');
           $subscribers = $this->model_account_customer->getCustomersSubscribers();
           if ($subscribers) {
               foreach ($subscribers as $subscriber) {
                   if ($subscriber['bepayed_sbs_id']) {
                       $subs_info = @json_decode(shell_exec('curl -u "'.$auth_data['login'].'":"'.$auth_data['password'].'" "https://api.bepaid.by/subscriptions/'. $subscriber['bepayed_sbs_id'] .'" -H "Content-Type: application/json"'), true);
                       if ($subs_info) {
                           $subs_informations[] = [
                               'card_subscribe_info_id' => $subscriber['card_subscribe_info_id'],
                               'bepayed_sbs_id' => $subscriber['bepayed_sbs_id'],
                               'pay_status' => $subs_info['state']
                           ];
                       }
                   }
               }
           }
        }

        if ($subs_informations) {
            foreach ($subs_informations as $item) {
                $this->model_account_customer->updatePayStatusToCustomerSubscriber($item['card_subscribe_info_id'], $item['pay_status']);
            }
        }
        $json['subs_info'] = $subs_informations;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
