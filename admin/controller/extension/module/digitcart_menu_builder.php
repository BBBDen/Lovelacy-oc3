<?php
class ControllerExtensionModuleDigitCartMenuBuilder extends Controller {
	private $error = array();
	private $moduleName = 'digitcart_menu_builder';
	private $moduleFilePath = 'extension/module/digitcart_menu_builder';
	private $moduleModelPath = 'model_extension_module_digitcart_menu_builder';
	private $eventFilePath = 'setting/event';
	private $eventModel = 'model_setting_event';
	private function moduleEvents() {
		return array(
			array(
				'trigger' => 'catalog/view/*/after',
				'action' => $this->moduleFilePath . '/displayMenus'
			),
			array(
				'trigger' => 'catalog/controller/common/menu/after',
				'action' => $this->moduleFilePath . '/overrideMenu'
			),
			array(
				'trigger' => 'catalog/view/common/header/after',
				'action' => $this->moduleFilePath . '/inHead'
			)
		);
	}
	public function index() {
		$lang = $this->load->language($this->moduleFilePath);
		foreach ($lang as $k => $v) {
			$data[$k] = $v;
		}
		$data['heading_title'] = $this->language->get('heading_title');
		$this->document->setTitle(STRIP_TAGS($this->language->get('heading_title')));
		$this->document->addStyle('view/javascript/codemirror/lib/codemirror.css');
		$this->document->addScript('view/javascript/codemirror/lib/codemirror.js');
		$this->document->addStyle('view/javascript/digitcart_menu_builder/bs-iconpicker/css/bootstrap-iconpicker.min.css');
		$this->document->addScript('view/javascript/digitcart_menu_builder/bs-iconpicker/js/iconset/iconset-fontawesome-4.7.0.min.js');
		$this->document->addScript('view/javascript/digitcart_menu_builder/bs-iconpicker/js/bootstrap-iconpicker.js');
		$this->document->addScript('view/javascript/digitcart_menu_builder/jquery-menu-editor.min.js');
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_' . $this->moduleName, $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/' . $this->moduleName, 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['action'] = $this->url->link('extension/module/' . $this->moduleName, 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		$vars = array(
			'status' => 0,
			'override' => 0,
			'css' => '/* ' . $this->language->get('entry_css') . ' */'
		);
		foreach ($vars as $var => $default) {
			if (isset($this->request->post['module_' . $this->moduleName . '_' . $var])) {
				$data['module_' . $this->moduleName . '_' . $var] = $this->request->post['module_' . $this->moduleName . '_' . $var];
			} elseif ($this->config->get('module_' . $this->moduleName . '_' . $var)) {
				$data['module_' . $this->moduleName . '_' . $var] = $this->config->get('module_' . $this->moduleName . '_' . $var);
			} else {
				$data['module_' . $this->moduleName . '_' . $var] = $default;
			}
		}
		$data['user_token'] = $this->session->data['user_token'];
		$this->load->model($this->moduleFilePath);
		$menus = $this->{$this->moduleModelPath}->getMenus();
		$this->load->model('localisation/language');
		$data['menus'] = array();
		if ($menus) {
			$multi_language_data = array();
			foreach ($menus as $menu) {
				$multi_language_data[$menu['menu_id']][$menu['language_id']] = array(
					'name' => $menu['name'],
					'data' => html_entity_decode($menu['data'], ENT_QUOTES, 'utf-8'),
				);
				$language = $this->model_localisation_language->getLanguage($menu['language_id']);
				$data['menus'][$menu['menu_id']] = array(
					'menu_id' => $menu['menu_id'],
					'status' => $menu['status'],
					'class' => $menu['class'],
					'type' => $menu['type'],
					'date_added' => date($this->language->get('datetime_format'), strtotime($menu['date_added'])),
					'date_modified' => date($this->language->get('datetime_format'), strtotime($menu['date_modified'])),
					'language' => $language,
					'multi_language_data' => $multi_language_data[$menu['menu_id']],
				);
			}
		}
		$data['module_path'] = $this->moduleFilePath;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['config_language_id'] = $this->config->get('config_language_id');
		$this->response->setOutput($this->load->view($this->moduleFilePath, $data));
	}
	public function addMenu() {
		$json = array();
		$post = $this->request->post;
		$lang = $this->load->language($this->moduleFilePath);
		if (!empty($post)) {
			if ((utf8_strlen($post['name']) < 3) || (utf8_strlen($post['name']) > 255)) {
				$json['error']['name'] = $lang['error_name'];
			}
			if (empty($post['data']) || $post['data'] == '[]') {
				$json['error']['data'] = $lang['error_data'];
			}
			if (!empty($post['menu_id'])) {
				if(!$json) {
					$this->load->model($this->moduleFilePath);
					$json['menu_id'] = $this->{$this->moduleModelPath}->editMenu($post['menu_id'], $post);
					$json['success']['edit'] = $lang['text_success_edit'];
				}
			} else {
				if (!$json) {
					$this->load->model($this->moduleFilePath);
					$json['menu_id'] = $this->{$this->moduleModelPath}->addMenu($post);
					$json['success']['add'] = $lang['text_success_add'];
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function toggleMenuStatus() {
		$json = array();
		$lang = $this->load->language($this->moduleFilePath);
		$post = $this->request->post;
		if (!empty($post)) {
			if (!empty($post['menu_id'])) {
				$this->load->model($this->moduleFilePath);
				$this->{$this->moduleModelPath}->toggleMenuStatus($post['menu_id']);
				$json['success'] = true;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function deleteMenu() {
		$json = array();
		$lang = $this->load->language($this->moduleFilePath);
		$post = $this->request->post;
		if (!empty($post['menu_id'])) {
			$this->load->model($this->moduleFilePath);
			$this->{$this->moduleModelPath}->deleteMenu($post['menu_id']);
			$json['success'] = $lang['text_success_delete'];
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function deleteMenuByLanguage() {
		$json = array();
		$lang = $this->load->language($this->moduleFilePath);
		$post = $this->request->post;
		if (!empty($post['menu_id']) && !empty($post['language_id'])) {
			$this->load->model($this->moduleFilePath);
			$this->{$this->moduleModelPath}->deleteMenuByLanguage($post);
			$json['success'] = $lang['text_success_delete'];
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function install() {
		$this->load->model($this->eventFilePath);
		$this->load->model($this->moduleFilePath);
		$this->{$this->moduleModelPath}->createDBTables();
		foreach ($this->moduleEvents() as $event) {
			$this->{$this->eventModel}->addEvent($this->moduleName, $event['trigger'], $event['action']);
		}
	}
	public function uninstall() {
		$this->load->model($this->eventFilePath);
		$this->{$this->eventModel}->deleteEventByCode($this->moduleName);
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/' . $this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}