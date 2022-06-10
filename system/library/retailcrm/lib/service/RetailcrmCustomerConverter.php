<?php

namespace retailcrm\service;

class RetailcrmCustomerConverter {
    protected $data;
    protected $customer_data = array();
    protected $address = array();

    protected $settingsManager;

    public function __construct(
        SettingsManager $settingsManager
    ) {
        $this->settingsManager = $settingsManager;
    }

    public function getCustomer() {
        return $this->data;
    }

    public function initCustomerData($customer_data, $address) {
        $this->data = array();
        $this->customer_data = $customer_data;
        $this->address = $address;

        return $this;
    }

    public function materialSelect($material)
    {
        if ($material == 'chlopock') {
            return $material = 'Хлопок';
        } else if ($material == 'setka') {
            return $material = 'Сетка';
        } else if ($material == 'cruzhevo') {
            return $material = 'Кружево';
        } else if ($material == 'all') {
            return $material = 'Все';
        }

    }
    
    public function setCustomerData() {
        $this->data['externalId'] = $this->customer_data['customer_id'];
        $this->data['firstName'] = $this->customer_data['firstname'];
        $this->data['lastName'] = $this->customer_data['lastname'];
        $this->data['email'] = $this->customer_data['email'];
        $this->data['createdAt'] = $this->customer_data['date_added'];

        if (!empty($this->customer_data['telephone'])) {
            $this->data['phones'] = array(
                array(
                    'number' => $this->customer_data['telephone']
                )
            );
        }
        $subscribe = false;
        if ($this->customer_data['subscribe']['pay_status'] == 'successful')
        {
            $this->customer_data['subscribe']['pay_status'] = 'true';
        }
        else
        {
            $this->customer_data['subscribe']['pay_status'] = 'false';
        }
        if (preg_match_all('~"([^"]*)"~u' , $this->customer_data['subscribe']['user_data'] , $m)) {

            if (count($m[1]) == 22 )
            {
                $this->data['customFields'] = array (
                    'bust' => $m[1][1],
                    'girth_under_bust2' =>$m[1][3],
                    'hip_girth' => $m[1][5],
                    'cup_size' =>$m[1][7],
                    'wear_chokers' => $m[1][11],
                    'wear_straps' => $m[1][13],
                    'material' => $this->materialSelect($m[1][15]),
                    'prefer_of_color' => $m[1][17],
                    'put_in_bag' => $m[1][19],
                    'wishes_didnt_ask_about' => $m[1][21],
                    'instagram_account' => $this->customer_data['social_nick'],
                    'subscribe' => $this->customer_data['subscribe']['pay_status']
                );
            }
            else if(count($m[1]) == 23)
            {
                $this->data['customFields'] = array (
                    'bust' => $m[1][1],
                    'girth_under_bust2' =>$m[1][3],
                    'hip_girth' => $m[1][5],
                    'cup_size' =>$m[1][7],
                    'wear_chokers' => $m[1][11],
                    'wear_straps' => $m[1][13],
                    'material' =>$this->materialSelect($m[1][15]).','.$this->materialSelect($m[1][16]),
                    'prefer_of_color' => $m[1][18],
                    'put_in_bag' => $m[1][20],
                    'wishes_didnt_ask_about' => $m[1][22],
                    'instagram_account' => $this->customer_data['social_nick'],
                    'subscribe' => $this->customer_data['subscribe']['pay_status']
                );
            }
            else if(count($m[1]) == 24)
            {
                $this->data['customFields'] = array (
                    'bust' => $m[1][1],
                    'girth_under_bust2' =>$m[1][3],
                    'hip_girth' => $m[1][5],
                    'cup_size' =>$m[1][7],
                    'wear_chokers' => $m[1][11],
                    'wear_straps' => $m[1][13],
                    'material' => $this->materialSelect($m[1][15]).','.$this->materialSelect($m[1][16]).','.$this->materialSelect($m[1][17]),
                    'prefer_of_color' => $m[1][19],
                    'put_in_bag' => $m[1][21],
                    'wishes_didnt_ask_about' => $m[1][23],
                    'instagram_account' => $this->customer_data['social_nick'],
                    'subscribe' => $this->customer_data['subscribe']['pay_status']
                );
            }
            else if(count($m[1]) == 25)
            {
                $this->data['customFields'] = array (
                    'bust' => $m[1][1],
                    'girth_under_bust2' =>$m[1][3],
                    'hip_girth' => $m[1][5],
                    'cup_size' =>$m[1][7],
                    'wear_chokers' => $m[1][11],
                    'wear_straps' => $m[1][13],
                    'material' => $this->materialSelect($m[1][15]).','.$this->materialSelect($m[1][16]).','.$this->materialSelect($m[1][17]).','.$this->materialSelect($m[1][18]),
                    'prefer_of_color' => $m[1][20],
                    'put_in_bag' => $m[1][22],
                    'wishes_didnt_ask_about' => $m[1][24],
                    'instagram_account' => $this->customer_data['social_nick'],
                    'subscribe' => $this->customer_data['subscribe']['pay_status']
                );
            }


        }else{
            $this->data['customFields'] = array (
                'instagram_account' => $this->customer_data['social_nick']
            );
        }

        return $this;
    }


    public function setAddress() {
        if (!empty($this->address)) {
            $this->data['address'] = array(
                'index' => $this->address['postcode'],
                'countryIso' => $this->address['iso_code_2'],
                'region' => $this->address['zone'],
                'city' => $this->address['city'],
                'text' => $this->address['address_1'] . ' ' . $this->address['address_2']
            );
        }

        return $this;
    }

    public function setCustomFields() {
        $settings = $this->settingsManager->getSetting('custom_field');
        if (!empty($settings) && $this->customer_data['custom_field']) {
            $customFields = json_decode($this->customer_data['custom_field']);

            foreach ($customFields as $key => $value) {
                if (isset($settings['c_' . $key])) {
                    $customFieldsToCrm[$settings['c_' . $key]] = $value;
                }
            }

            if (isset($customFieldsToCrm)) {
                $this->data['customFields'] = $customFieldsToCrm;
            }
        }

        return $this;
    }
}
