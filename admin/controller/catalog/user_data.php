<?php

class ControllerCatalogUserData extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/user_data');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/customer');

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'fgd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/filter', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/filter/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/filter/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['user_data'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin'),
		);
        $user_data_total = $this->model_customer_customer->getTotalUsersData($filter_data);
		$results = $this->model_customer_customer->getCustomersInfo($filter_data);

        $this->load->model('tool/image');

		foreach ($results as $result) {
			$data['user_data'][] = array(
			    'id' => $result['card_subscribe_info_id'],
				'name' => $result['firstname'] . ' ' . $result['lastname'],
				'email' => $result['email'],
				'pay_status' => $result['pay_status'],
				'phone' => $result['telephone'],
                'edit' => $this->url->link('catalog/user_data/edit', 'user_token=' . $this->session->data['user_token'] . '&path_id=' . $result['card_subscribe_info_id'], true),
			);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/filter', 'user_token=' . $this->session->data['user_token'] . '&sort=fgd.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/filter', 'user_token=' . $this->session->data['user_token'] . '&sort=fg.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

        $pagination = new Pagination();
        $pagination->total = $user_data_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('catalog/user_data', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);
        $data['pagination'] = $pagination->render();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');



		$this->response->setOutput($this->load->view('catalog/user_data', $data));
	}

    public function edit()
    {
        $this->load->language('catalog/user_data');
        $this->load->model('customer/customer');
        $title = $this->language->get('heading_title');
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/user_data', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['user_data'] = [];

        $tru_false = [
            'true'  => 'Да',
            'false' => 'Нет'
        ];

        $materials = [
            'cruzhevo'  => 'Кружево',
            'chlopock'  => 'Хлопок',
            'setka'     => 'Сетка',
            'all'       => 'Нет предпочтений'
        ];

        $colors = [
            'dark'      => 'Темные',
            'light'     => 'Светлые',
            'all'       => 'Нет предпочтений',
        ];

        $config = [
            'chest'         => 'Обхват груди',
            'under_chest'   => 'Обхват под грудью',
            'hips'          => 'Обхват бедер',
            'chockers'      => 'Носит ли чокеры',
            'streps'        => 'Носит ли стрепы',
            'material'      => 'Какие материалы предпочитает',
            'color'         => 'Какие цвета нравятся больше',
            'notToAdd'      => 'Что точно не класть в мешочек',
            'requests'      => 'Есть ли какие-то особенные пожелания',
            'braSize'       => 'Размер чашки',
            'braSizeOur'    => 'Какой из комплектов уже присутствует',
        ];

        $result = $this->model_customer_customer->getData($this->request->get['path_id']);

        if ($result) {
            if ($result['firstname']) {
                $title .= '|' . $result['firstname'];
            }
            $data = [];
            if ($result['user_data']) {
                $_data_ = unserialize($result['user_data']);

                $keys = array_keys($_data_);
                foreach ($keys as $k) {
                    if ($k === 'material') {
                        if (gettype($_data_[$k]) === 'array') {
                            $vals = [];
                            foreach ($_data_[$k] as $item) {
                                $vals[] = $materials[$item];
                            }

                            $val = implode(', ', $vals);
                        } else {
                            $val = $materials[$_data_[$k]];
                        }
                    } else if ($k === 'color') {
                        $val = $colors[$_data_[$k]];
                    } else if ($k === 'chockers' || $k === 'streps') {
                        $val = $tru_false[$_data_[$k]];
                    } else {
                        $val = $_data_[$k];
                    }
                    $data[] = [
                        'key' => $config[$k],
                        'value' => $val
                    ];
                }
            }
            $status = '';
            if ($result['pay_status'] === 'successful') {
                $status = 'Подписка оформлена';
            } else if ($result['pay_status'] === 'failed') {
                $status = 'Подписка не оформлена';
            } else if ($result['pay_status'] === 'canceled') {
                $status = 'Подписка отменена';
            } else if ($result['pay_status'] === 'error') {
                $status = 'Произощла ошибка при подписке';
            }
            $data['user_data'] = [
                'email' => $result['email'],
                'pay_status' => $status,
                'status' => $result['pay_status'],
                'phone' => $result['telephone'],
                'name' => $result['firstname'] . ( $result['lastname'] ? ' ' . $result['lastname'] : '' ),
                'data' => $data
            ];
        }
        $this->document->setTitle($title);
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/user_data_form', $data));
    }
}
