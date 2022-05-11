<?php
class ModelExtensionShippingPostalCdek extends Model {
	function getQuote($address) {
		$this->load->language('extension/shipping/postal_cdek');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('shipping_postal_cdek_geo_zone_id') . "' AND country_id = '" . (isset($address['country_id']) ? (int)$address['country_id'] : '20') . "' AND (zone_id = '" . (isset($address['zone_id']) ? (int)$address['zone_id'] : '339') . "' OR zone_id = '0')");

		if (!$this->config->get('shipping_postal_cdek_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();
        $coast = $this->config->get('shipping_postal_cdek_cost');

		if ($status) {
			$quote_data = array();

			$quote_data['postal_cdek'] = array(
				'code'         => 'postal_cdek.postal_cdek',
				'title'        => $this->language->get('text_description'),
				'cost'         => $coast,
				'tax_class_id' => 0,
				'text'         => $this->currency->format($coast, $this->session->data['currency'])
			);

			$method_data = array(
				'code'       => 'postal_cdek',
				'title'      => ((int)$coast > 0 ? $this->language->get('text_title') . '— ' . $this->__get_converted_currency__($this->__get_url_api__('rub'), $coast) : $this->language->get('text_title')),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('shipping_postal_cdek_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}
