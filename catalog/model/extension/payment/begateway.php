<?php
class ModelExtensionPaymentBegateway extends Model {
  public function getMethod($address, $total) {
    $this->load->language('extension/payment/begateway');

    $country_id = isset($address['country_id']) ? $address['country_id'] : 20;
    $zone_id = !array_key_exists('zone_id', $address) ? 0 : (int)$address['zone_id'];

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('begateway_geo_zone_id') . "' AND country_id = '" . (int)$country_id . "' AND (zone_id = '" . $zone_id . "' OR zone_id = '0')");

    if ($this->config->get('begateway_total') > 0 && $this->config->get('begateway_total') > $total) {
      $status = false;
    } elseif (!$this->config->get('begateway_geo_zone_id')) {
      $status = true;
    } elseif ($query->num_rows) {
      $status = true;
    } else {
      $status = false;
    }

    $method_data = array();

    if ($status) {
      $method_data = array(
        'code'       => 'begateway',
        'title'      => $this->language->get('text_title'),
        'terms'      => '',
        'sort_order' => $this->config->get('begateway_sort_order')
      );
    }

    return $method_data;
  }
}

?>
