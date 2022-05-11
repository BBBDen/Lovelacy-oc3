<?php
class ModelExtensionModuleDigitCartMenuBuilder extends Model {
	private $moduleName = 'digitcart_menu_builder';
	public function getMenu($menu_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "digitcart_menu_builder mb LEFT JOIN " . DB_PREFIX . "digitcart_menu_builder_description mbd ON (mbd.menu_id = mb.menu_id) WHERE mb.menu_id = '" . (int)$menu_id . "' And mb.status = '" . (int)1 . "' AND mbd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		if($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
}