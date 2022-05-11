<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCheckoutSuccess extends Controller {
	public function index() {
        if (isset($this->session->data['certificate_code'])) {
            $this->load->model('catalog/product');
            $promo = $this->model_catalog_product->getProductCertificate($this->session->data['certificate_code']);

            if ($promo) {
                $this->load->language('mail/voucher');

                $data['title'] = sprintf($this->language->get('text_subject'), '');

                $data['text_greeting'] = sprintf($this->language->get('text_greeting'), $this->currency->format($promo['price'], $promo['current_currency'], $promo['currency_value']));
                $data['text_from'] = sprintf($this->language->get('text_from'), '');
                $data['text_message'] = $this->language->get('text_message');
                $data['text_redeem'] = sprintf($this->language->get('text_redeem'), $promo['certificate_key']);
                $data['text_footer'] = $this->language->get('text_footer');

                $mail = new Mail($this->config->get('config_mail_engine'));
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

                $mail->setTo($promo['customer_email']);
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
                $mail->setSubject(html_entity_decode(sprintf($this->language->get('text_subject'), ''), ENT_QUOTES, 'UTF-8'));
                $mail->setHtml($this->load->view('mail/voucher', $data));
                $mail->send();
            }
        }
		$this->load->language('checkout/success');

        if (isset($this->session->data['payment_method']) && isset($this->session->data['payment_method']['code']) && $this->session->data['payment_method']['code'] === $this->__get_bank_transfer_payment__() && isset($this->session->data['order_id'])) {
            $order_id = $this->session->data['order_id'];
            $shipping_method = '';
            $shipping_code = '';
            if (isset($this->session->data['shipping_method'])) {
                $shipping_method = $this->session->data['shipping_method']['title'];
                $shipping_code = $this->session->data['shipping_method']['code'];
            }
            $this->db->query("UPDATE `". DB_PREFIX ."order` SET order_status_id = 1, shipping_method = '" . $shipping_method . "', shipping_code = '". $shipping_code ."' WHERE order_id = '". $order_id ."'");
        }

		if (isset($this->session->data['order_id'])) {
			$this->session->data['last_order_id'] = $this->session->data['order_id'];
			$this->cart->clear();


		}

        unset($this->session->data['shipping_method']);
        unset($this->session->data['shipping_methods']);
        unset($this->session->data['shipping_address']);
        unset($this->session->data['payment_address']);
        unset($this->session->data['payment_method']);
        unset($this->session->data['payment_methods']);
        unset($this->session->data['guest']);
        unset($this->session->data['comment']);
        unset($this->session->data['order_id']);
        unset($this->session->data['coupon']);
        unset($this->session->data['reward']);
        unset($this->session->data['voucher']);
        unset($this->session->data['vouchers']);
        unset($this->session->data['totals']);
        unset($this->session->data['promo']);
        unset($this->session->data['certificate_code']);

		if (!empty($this->session->data['last_order_id']) ) {
			$this->document->setTitle(sprintf($this->language->get('heading_title_customer'), $this->session->data['last_order_id']));
			$this->document->setRobots('noindex,follow');
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
			$this->document->setRobots('noindex,follow');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_success'),
			'href' => $this->url->link('checkout/success')
		);

		if (!empty($this->session->data['last_order_id'])) {
			$data['heading_title'] = sprintf($this->language->get('heading_title_customer'), $this->session->data['last_order_id']);
		} else {
			$data['heading_title'] = $this->language->get('heading_title');
		}

		if ($this->customer->isLogged() && !empty($this->session->data['last_order_id'])) {
			$data['text_message'] = sprintf($this->language->get('text_customer'), '№' . $this->session->data['last_order_id'], $this->url->link('account/order/info&order_id=' . $this->session->data['last_order_id'], '', true), $this->url->link('account/account', '', true), $this->url->link('account/order', '', true), $this->url->link('information/contact'), $this->url->link('product/special'), $this->session->data['last_order_id'], $this->url->link('account/download', '', true));
		} else {
			$data['text_message'] = sprintf($this->language->get('text_guest'), '№' . $this->session->data['last_order_id'], $this->url->link('information/contact'));
		}
		
		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = sprintf($this->load->controller('common/content_top'), '№' . $this->session->data['last_order_id']);
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('product/success', $data));
	}
}
