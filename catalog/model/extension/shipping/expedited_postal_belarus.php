<?php
class ModelExtensionShippingExpeditedPostalBelarus extends Model {
	function getQuote($address) {
		$this->load->language('extension/shipping/expedited_postal_belarus');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('shipping_expedited_postal_belarus_geo_zone_id') . "' AND country_id = '" . (isset($address['country_id']) ? (int)$address['country_id'] : '20') . "' AND (zone_id = '" . (isset($address['zone_id']) ? (int)$address['zone_id'] : '0') . "' OR zone_id = '0')");

		if (!$this->config->get('shipping_expedited_postal_belarus_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();
        $coast = $this->config->get('shipping_expedited_postal_belarus_cost');

		if ($status) {
			$quote_data = array();

			$quote_data['expedited_postal_belarus'] = array(
				'code'         => 'expedited_postal_belarus.expedited_postal_belarus',
				'title'        => $this->language->get('text_description'),
				'cost'         => $coast,
				'tax_class_id' => 0,
				'text'         => $this->currency->format($coast, $this->session->data['currency'])
			);

			$method_data = array(
				'code'       => 'expedited_postal_belarus',
				'title'      => sprintf($this->language->get('text_title'), $this->currency->format($coast, $this->session->data['currency'])),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('shipping_expedited_postal_belarus_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}
