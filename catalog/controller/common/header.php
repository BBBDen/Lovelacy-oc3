<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonHeader extends Controller {
	public function index() {
		// Analytics
		$this->load->model('setting/extension');

		$data['analytics'] = array();

		$analytics = $this->model_setting_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get('analytics_' . $analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get('analytics_' . $analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['category_url'] = $this->url->link('product/category', 'path=' . $this->__get_main_category_id__());
		$data['underwear_url'] = $this->url->link('product/category', 'path=' . $this->__get_category_id__()['underwear']);
		$data['accessories_url'] = $this->url->link('product/category', 'path=' . $this->__get_category_id__()['accessories']);
		$data['dress_url'] = $this->url->link('product/category', 'path=' . $this->__get_category_id__()['dress']);
		$data['swimwear_url'] = $this->url->link('product/category', 'path=' . $this->__get_category_id__()['swimwear']);
		$data['sales_url'] = $this->url->link('product/category', 'path=' . $this->__get_category_id__()['sales']);
        $data['contact_url'] = $this->url->link('information/contact');
		$data['certificate_url'] = $this->url->link('information/category', 'information_id=13');
        $data['subscribe_url'] = $this->url->link('information/category', 'information_id=14');
		$data['size_url'] = $this->url->link('information/category', 'information_id=12');
		$data['care_url'] = $this->url->link('information/category', 'information_id=11');
		$data['return_url'] = $this->url->link('information/category', 'information_id=10');
		$data['proj_url'] = $this->url->link('information/category', 'information_id=8');
		$data['about_url'] = $this->url->link('information/category', 'information_id=4');
		$data['delivery_url'] = $this->url->link('information/category', 'information_id=6');
		$data['ofer_url'] = $this->url->link('information/category', 'information_id=7');
		$data['policy_url'] = $this->url->link('information/category', 'information_id=3');
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['robots'] = $this->document->getRobots();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts('header');
		$data['lang'] = $this->language->get('code');
		$data['lang_code'] = isset($this->session->data['language']) ? $this->session->data['language'] : 'ru-ru';
		$data['direction'] = $this->language->get('direction');

		$data['categories_all_wear'] = [];
		$data['categories_all_accessories'] = [];
		$data['categories_all_dress'] = [];
		$data['categories_all_swimwear'] = [];
		$this->load->model('catalog/category');
		$results = $this->model_catalog_category->getRelatedCategories($this->__get_category_id__()['underwear']);

		if ($results) {
            foreach ($results as $result) {
                $data['categories_all_wear'][] = [
                    'name' => $result['name'],
                    'href' => $this->url->link('product/category', 'path=' . $result['category_id'])
                ];
		    }
        }

        $results = $this->model_catalog_category->getRelatedCategories($this->__get_category_id__()['accessories']);

        if ($results) {
            foreach ($results as $result) {
                $data['categories_all_accessories'][] = [
                    'name' => $result['name'],
                    'href' => $this->url->link('product/category', 'path=' . $result['category_id'])
                ];
            }
        }

        $results = $this->model_catalog_category->getRelatedCategories($this->__get_category_id__()['dress']);

        if ($results) {
            foreach ($results as $result) {
                $data['categories_all_dress'][] = [
                    'name' => $result['name'],
                    'href' => $this->url->link('product/category', 'path=' . $result['category_id'])
                ];
            }
        }

        $results = $this->model_catalog_category->getRelatedCategories($this->__get_category_id__()['swimwear']);

        if ($results) {
            foreach ($results as $result) {
                $data['categories_all_swimwear'][] = [
                    'name' => $result['name'],
                    'href' => $this->url->link('product/category', 'path=' . $result['category_id'])
                ];
            }
        }

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

        $data['text_error_email'] = $this->language->get('text_error_email');
        $data['text_error_email_empty'] = $this->language->get('text_error_email_empty');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['language_id'] = $this->config->get('config_language_id');
        $data['current_currency'] = isset($this->session->data['currency']) ? $this->session->data['currency'] : '';
		
		$host = isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER;
		if ($this->request->server['REQUEST_URI'] == '/') {
			$data['og_url'] = $this->url->link('common/home');
		} else {
			$data['og_url'] = $host . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
		}
		
		$data['og_image'] = $this->document->getOgImage();

		$data['text_wishlist'] = '';

        if ($this->customer->isLogged()) {
            $this->load->model('account/wishlist');
            if (!empty($this->model_account_wishlist->getWishlist())) {

                $data['text_wishlist'] = ' added';
            }
        } else if (isset($this->session->data['wishlist']) && count($this->session->data['wishlist'])) {
            $data['text_wishlist'] = ' added';
        }

		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));
		
		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['version'] = date('YmdHms');
        $data['action_auth'] = $this->url->link('account/login/authorization', '', true);

        $data['added'] = $this->cart->countProducts() ? ' added' : '';
		
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		if ($this->config->get('configblog_blog_menu')) {
			$data['blog_menu'] = $this->load->controller('blog/menu');
		} else {
			$data['blog_menu'] = '';
		}
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		$data['menu'] = $this->load->controller('common/menu');

		return $this->load->view('common/header', $data);
	}
}
