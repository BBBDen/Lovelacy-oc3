<?php

class ControllerExtensionModuleRetailcrm extends Controller {

    private $retailcrmApiClient;

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->load->library('retailcrm/retailcrm');
        $this->retailcrmApiClient = $this->retailcrm->getApiClient();
    }

    /**
     * Create order on event
     *
     * @param string $trigger
     * @param array $data
     * @param int $order_id order identificator
     *
     * @return void
     */
    public function order_create($trigger, $data, $order_id = null) {
        if (\retailcrm\Retailcrm::$history_run === true) {
            return;
        }

        $this->load->library('retailcrm/retailcrm');

        $order_data = $this->model_checkout_order->getOrder($order_id);
        $products = $this->model_account_order->getOrderProducts($order_id);
        $totals = $this->model_account_order->getOrderTotals($order_id);
        $moduleTitle = $this->retailcrm->getModuleTitle();

        foreach ($products as $key => $product) {
            $productOptions = $this->model_account_order->getOrderOptions($order_id, $product['order_product_id']);

            if (!empty($productOptions)) {
                $products[$key]['option'] = $productOptions;
            }
        }

        $this->load->model('setting/setting');
        $status = $this->model_setting_setting->getSetting($moduleTitle);

        if (isset($order_data['order_status_id']) && $order_data['order_status_id'] > 0) {
            $order_data['order_status'] = $status[$moduleTitle . '_status'][$order_data['order_status_id']];
        }

        if (file_exists(DIR_APPLICATION . 'model/extension/retailcrm/custom/order.php')) {
            $this->load->model('extension/retailcrm/custom/order');
            $order_data['products'] = $products;
            $order_data['totals'] = $totals;

            $order = $this->model_extension_retailcrm_custom_order->processOrder($order_data);
            $this->model_extension_retailcrm_custom_order->sendToCrm($order, $this->retailcrmApiClient, $order_data);
        } else {
            $order_manager = $this->retailcrm->getOrderManager();
            $order_manager->createOrder($order_data, $products, $totals);
        }
    }

    /**
     * Update order on event
     *
     * @param string $trigger
     * @param array $parameter2
     *
     * @return void
     */
    public function order_edit($trigger, $parameter2 = null) {
        if (\retailcrm\Retailcrm::$history_run === true) {
            return;
        }

        $order_id = $parameter2[0];

        $this->load->library('retailcrm/retailcrm');

        $moduleTitle = $this->retailcrm->getModuleTitle();
        $data = $this->model_checkout_order->getOrder($order_id);

        if ($data['order_status_id'] == 0) {
            return;
        }

        $products = $this->model_account_order->getOrderProducts($order_id);
        $totals = $this->model_account_order->getOrderTotals($order_id);

        foreach ($products as $key => $product) {
            $productOptions = $this->model_account_order->getOrderOptions($order_id, $product['order_product_id']);

            if (!empty($productOptions)) {
                $products[$key]['option'] = $productOptions;
            }
        }

        if (!isset($data['fromApi'])) {
            $status = $this->model_setting_setting->getSetting($moduleTitle);

            if ($data['order_status_id'] > 0) {
                $data['order_status'] = $status[$moduleTitle . '_status'][$data['order_status_id']];
            }

            if (file_exists(DIR_APPLICATION . 'model/extension/retailcrm/custom/order.php')) {
                $this->load->model('extension/retailcrm/custom/order');
                $data['products'] = $products;
                $data['totals'] = $totals;

                $order = $this->model_extension_retailcrm_custom_order->processOrder($data, false);
                $this->model_extension_retailcrm_custom_order->sendToCrm($order, $this->retailcrmApiClient, $data, false);
            } else {
                $order_manager = $this->retailcrm->getOrderManager();
                $order_manager->editOrder($data, $products, $totals);
            }
        }
    }

    /**
     * Create customer on event
     *
     * @param int $customerId customer identificator
     *
     * @return void
     */
    public function customer_create($parameter1, $parameter2 = null, $parameter3 = null) {
        $this->load->model('account/customer');
        $this->load->model('localisation/country');
        $this->load->model('localisation/zone');

        $customerId = $parameter3;
        $customer = $this->model_account_customer->getCustomer($customerId);

        if (isset($this->request->post['city'])) {
            $post = $this->request->post;
            if(!isset($post['country_id'])){ $post['country_id'] = 20; }
            if(!isset($post['zone_id'])){ $post['zone_id'] = 0; }
            if(!isset($post['city'])){ $post['address_1'] = ''; }
            if(!isset($post['address_2'])){ $post['address_2'] = ''; }
            if(!isset($post['postcode'])){ $post['postcode'] = ''; }

            $country = $this->model_localisation_country->getCountry($post['country_id']);
            $zone = $this->model_localisation_zone->getZone($post['zone_id']);
            $customer['customFields'] =
                array(
                    'instagram_account' => $customer['social_nick']
                );
            $customer['address'] = array(
                'address_1' => $post['address_1'],
                'address_2' => $post['address_2'],
                'city' => $post['city'],
                'postcode' => $post['postcode'],
                'iso_code_2' => $country['iso_code_2'],
                'zone' => $zone['name']
            );
        }

        if (file_exists(DIR_APPLICATION . 'model/extension/retailcrm/custom/customer.php')) {
            $this->load->model('extension/retailcrm/custom/customer');
            $this->model_extension_retailcrm_custom_customer->sendToCrm($customer);
        } else {
            $this->load->model('extension/retailcrm/customer');
            $this->model_extension_retailcrm_customer->sendToCrm($customer);
        }









        //        $customerId = $parameter3;
//        $customer = $this->model_account_customer->getCustomer($customerId);
////        $customer['customFields'] = array(
////            'instagram_account' => 'test'
////        );
//
//        $customer['address'] = array(
//
//            'city' => 'Gomel'
//
//        );
//
//
//        if (file_exists(DIR_APPLICATION . 'model/extension/retailcrm/custom/customer.php')) {
//            $this->load->model('extension/retailcrm/custom/customer');
//            $this->model_extension_retailcrm_custom_customer->sendToCrm($customer, $this->retailcrmApiClient);
//        } else {
//            $address = array();
//            $customer_manager = $this->retailcrm->getCustomerManager();
//            $customer_manager->createCustomer($customer, $address);
//        }
    }

    /**
     * Update customer on event
     *
     * @param int $customerId customer identificator
     *
     * @return void
     */
    public function customer_edit($parameter1, $parameter2, $parameter3) {
        $customerId = $this->customer->getId();

        $customer = $this->model_account_customer->getCustomer($customerId);
        $address = $this->model_account_address->getAddress($customer['address_id']);
        if ($customer['social_nick'] <> null) {
            if (file_exists(DIR_APPLICATION . 'model/extension/retailcrm/custom/customer.php')) {
                $this->load->model('extension/retailcrm/custom/customer');


                $this->model_extension_retailcrm_custom_customer->changeInCrm($customer, $this->retailcrmApiClient);
            } else {
                $customer_manager = $this->retailcrm->getCustomerManager();
                $customer_manager->editCustomer($customer, $address);
            }
        }
        }
}
