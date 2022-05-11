<?php
class ModelExtensionModuleDigitCartMenuBuilder extends Model {
	public function addMenu($data = array()) {
		$sql = "INSERT INTO " . DB_PREFIX . "digitcart_menu_builder SET
		`status` = '" . (int)$data['status'] . "',
		`class` = '" . $this->db->escape($data['class']) . "',
		`type` = '" . (int)$data['type'] . "',
		date_added = NOW(),
		date_modified = NOW()
		";
		$this->db->query($sql);
		$menu_id = $this->db->getLastId();
		$sql = "INSERT INTO " . DB_PREFIX . "digitcart_menu_builder_description SET
		menu_id = '" . (int)$menu_id . "',
		language_id = '" . (int)$data['language_id'] . "',
		name = '" . $this->db->escape($data['name']) . "',
		data = '" . $this->db->escape($data['data']) . "'
		";
		$this->db->query($sql);
		return $menu_id;
	}
	public function editMenu($menu_id, $data = array()) {
		$sql = "UPDATE " . DB_PREFIX . "digitcart_menu_builder SET
		`status` = '" . (int)$data['status'] . "',
		`class` = '" . $this->db->escape($data['class']) . "',
		`type` = '" . (int)$data['type'] . "',
		date_modified = NOW()
		WHERE menu_id = '" . (int)$menu_id . "'
		";
		$this->db->query($sql);
		$query = $this->db->query("SELECT mb.menu_id FROM " . DB_PREFIX . "digitcart_menu_builder mb LEFT JOIN " . DB_PREFIX . "digitcart_menu_builder_description mbd ON (mbd.menu_id = mb.menu_id) WHERE mb.menu_id = '" . (int)$menu_id . "' AND mbd.language_id = '" . (int)$data['language_id'] . "'");
		if ($query->num_rows) {
			$sql = "Update " . DB_PREFIX . "digitcart_menu_builder_description mbd SET
			name = '" . $this->db->escape($data['name']) . "',
			`data` = '" . $this->db->escape($data['data']) . "'
			WHERE mbd.menu_id = '" . (int)$menu_id . "'
			AND mbd.language_id = '" . (int)$data['language_id'] . "'
			";
			$this->db->query($sql);
		} else {
			$sql = "INSERT INTO " . DB_PREFIX . "digitcart_menu_builder_description SET
			menu_id = '" . (int)$menu_id . "',
			language_id = '" . (int)$data['language_id'] . "',
			name = '" . $this->db->escape($data['name']) . "',
			`data` = '" . $this->db->escape($data['data']) . "'
			";
			$this->db->query($sql);
		}
		return $menu_id;
	}
	public function toggleMenuStatus($menu_id) {
		$sql = "UPDATE " . DB_PREFIX . "digitcart_menu_builder SET
		status = IF (status = 1, 0, 1)
		WHERE menu_id = '" . (int)$menu_id . "'
		";
		$this->db->query($sql);
	}
	public function getMenus($data = array()) {
		$sql = "SELECT 
		* FROM " . DB_PREFIX . "digitcart_menu_builder mb
		LEFT JOIN " . DB_PREFIX . "digitcart_menu_builder_description mbd ON(mbd.menu_id = mb.menu_id)
		";
		$sql .= " ORDER BY ";
		$sql .= " mb.date_modified ";
		$sql .= " DESC ";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
	}
	public function deleteMenu($menu_id) {
		$sql = "DELETE FROM " . DB_PREFIX . "digitcart_menu_builder WHERE menu_id = '" . (int)$menu_id . "'";
		$this->db->query($sql);
		$sql = "DELETE FROM " . DB_PREFIX . "digitcart_menu_builder_description WHERE menu_id = '" . (int)$menu_id . "'";
		$this->db->query($sql);
	}
	public function deleteMenuByLanguage($data) {
		$sql = "DELETE FROM " . DB_PREFIX . "digitcart_menu_builder_description WHERE menu_id = '" . (int)$data['menu_id'] . "' AND language_id = '" . (int)$data['language_id'] . "'";
		$this->db->query($sql);
		$query = $this->db->query("SELECT menu_id FROM " . DB_PREFIX . "digitcart_menu_builder_description WHERE menu_id = '" . (int)$data['menu_id'] . "'");
		if (!$query->num_rows) {
			$this->deleteMenu($data['menu_id']);
		}
	}
	public function createDBTables() {
		$sql = "
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "digitcart_menu_builder` (
			`menu_id` int(11) AUTO_INCREMENT NOT NULL,
			`status` tinyint(1) NOT NULL,
			`class` varchar(128) NOT NULL,
			`type` tinyint(1) NOT NULL,
			`date_added` datetime NOT NULL,
			`date_modified` datetime NOT NULL,
			PRIMARY KEY (`menu_id`)
			);
		";
		$this->db->query($sql);
		$sql = "
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "digitcart_menu_builder_description` (
			`menu_id` int(11) NOT NULL,
			`language_id` int(3) NOT NULL,
			`name` varchar(255) CHARACTER SET utf8 NOT NULL,
			`data` text CHARACTER SET utf8 NOT NULL
			);
		";
		$this->db->query($sql);
	}
}