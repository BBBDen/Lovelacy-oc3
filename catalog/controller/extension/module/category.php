<?php
class ControllerExtensionModuleCategory extends Controller {
	public function index() {
		$this->load->language('extension/module/category');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories($this->__get_main_category_id__());

		foreach ($categories as $category) {

			if ($category['top']) {

                $filter_data = array(
                    'filter_category_id'  => $category['category_id'],
                    'filter_sub_category' => true
                );

                $data['categories'][] = array(
                    'child_id' => $data['child_id'],
                    'class' => (int)$data['child_id'] === (int)$category['category_id'] ? ' catalog__link_active' : '',
                    'category_id' => $category['category_id'],
                    'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                    'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
                );
            }
		}

		return $this->load->view('extension/module/category', $data);
	}
}
