<?php
class ControllerExtensionModuleDigitCartMenuBuilder extends Controller {
	private $error = array();
	private $moduleName = 'digitcart_menu_builder';
	private $moduleFilePath = 'extension/module/digitcart_menu_builder';
	private $moduleModelPath = 'model_extension_module_digitcart_menu_builder';
	public function displayMenus(&$route = false, &$data = false, &$output = false) {
		if (!$this->config->get('module_digitcart_menu_builder_status')) return;
		$regex = '/\[dcmenu (\d+)\]/';
		preg_match_all($regex, $output, $dcmenus);
		if ($dcmenus) {
			$count_menus = count($dcmenus[1]);
			for ($i = 0; $i < $count_menus; $i++) {
				$output = str_replace($dcmenus[0][$i], $this->getMenu($dcmenus[1][$i]), $output);
			}
		}
	}
	public function overrideMenu(&$route = false, &$data = false, &$output = false) {
		if (!$this->config->get('module_digitcart_menu_builder_status')) return;
		if ($this->config->get('module_digitcart_menu_builder_override')) {
			$output = $this->getMenu($this->config->get('module_digitcart_menu_builder_override'), true);
		}
	}
	public function getMenu($menu_id, $override = false) {
		if (!$this->config->get('module_digitcart_menu_builder_status')) return;
		$this->load->model($this->moduleFilePath);
		$menu = $this->model_extension_module_digitcart_menu_builder->getMenu($menu_id);
		$data = array();
		if ($menu) {
			$BootstrapMenu = DIR_SYSTEM . 'library/digitcart_menu_builder/BootstrapMenu.php';
			if (is_file($BootstrapMenu)) {
				require_once($BootstrapMenu);
				if ($menu['data']) {
					$menu_data = html_entity_decode($menu['data'], ENT_QUOTES, 'utf-8');
					$menu_data = new BootstrapMenu(
						array(
							'data' => $menu_data
						)
					);
					$menu_data->set('ul-root',
						array(
							'class'	=> "{$menu['class']} nav " . ($menu['type'] == 1 ? "navbar-nav" : "flex-column") ,
							'id'	=> "#dc-menu-" . $menu["menu_id"]
						)
					);
					$menu_data->set('a-parent',
						array(
							'class'			=> "dc-dropdown-toggle",
							'data-toggle'	=> "dc-dropdown",
							'role'			=> "button",
							'aria-haspopup'	=> "true",
							'aria-expanded'	=> "false"
						)
					);
					$menu_data = $menu_data->html();
					$data['menu_id'] = $menu['menu_id'];
					$data['type'] = $menu['type'];
					$data['class'] = $menu['class'];
					$data['name'] = $menu['name'];
					$data['menu'] = $menu_data;
					$data['override'] = $override;
					$data['view_type'] = 'menu';
				}
			}
		}
		return $this->load->view($this->moduleFilePath, $data);
	}
	public function inHead(&$route = false, &$data = false, &$output = false) {
		if (!$this->config->get('module_digitcart_menu_builder_status')) return;
		$data = array();
		if ($this->config->get('module_digitcart_menu_builder_css')) {
			$css = html_entity_decode($this->config->get('module_digitcart_menu_builder_css'), ENT_QUOTES, 'utf-8');
		} else {
			$css = '';
		}
		$data['css'] = $css;
		$data['view_type'] = 'head';
		$in_head = $this->load->view($this->moduleFilePath, $data);
		$output = str_replace('</head>', $in_head . '</head>', $output);
	}
}
