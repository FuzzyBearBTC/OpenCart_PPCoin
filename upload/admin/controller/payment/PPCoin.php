<?php 
/*
Copyright (c) 2012 John Atkinson (jga)

Permission is hereby granted, free of charge, to any person obtaining a copy of this 
software and associated documentation files (the "Software"), to deal in the Software 
without restriction, including without limitation the rights to use, copy, modify, 
merge, publish, distribute, sublicense, and/or sell copies of the Software, and to 
permit persons to whom the Software is furnished to do so, subject to the following 
conditions:

The above copyright notice and this permission notice shall be included in all copies 
or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR 
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE 
FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR 
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER 
DEALINGS IN THE SOFTWARE.
*/
class ControllerPaymentPPCoin extends Controller {
	private $error = array();
	private $payment_module_name  = 'PPCoin';
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/'.$this->payment_module_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        if (!$this->request->post['PPCoin_rpc_username']) {
            $this->error['username'] = $this->language->get('error_username');
        }
        if (!$this->request->post['PPCoin_rpc_address']) {
            $this->error['address'] = $this->language->get('error_address');
        }
        if (!$this->request->post['PPCoin_rpc_password']) {
            $this->error['password'] = $this->language->get('error_password');
        }
        if (!$this->request->post['PPCoin_rpc_port']) {
            $this->error['port'] = $this->language->get('error_port');
        }
        if (!$this->request->post['PPCoin_prefix']) {
            $this->error['prefix'] = $this->language->get('error_prefix');
        }
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	public function index() {
		$this->load->language('payment/'.$this->payment_module_name);
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting($this->payment_module_name, $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		//edit this language code once we know all the strings we need
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['heading_title'] 		= $this->language->get('heading_title');

		$this->data['text_enabled'] 		= $this->language->get('text_enabled');
		$this->data['text_disabled'] 		= $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
				
        $this->data['entry_username']        = $this->language->get('entry_username');
        $this->data['entry_address']        = $this->language->get('entry_address');
        $this->data['entry_password']       = $this->language->get('entry_password');
        $this->data['entry_port']       = $this->language->get('entry_port');
        $this->data['entry_prefix']       = $this->language->get('entry_prefix');
        $this->data['entry_order_status'] = $this->language->get('entry_order_status');
        $this->data['entry_show_ppc']         = $this->language->get('entry_show_ppc');
        $this->data['entry_status']         = $this->language->get('entry_status');
		$this->data['entry_sort_order'] 	= $this->language->get('entry_sort_order');
		
		$this->data['button_save'] 			= $this->language->get('button_save');
		$this->data['button_cancel'] 		= $this->language->get('button_cancel');

		$this->data['tab_general'] 			= $this->language->get('tab_general');
		//end language code
		
        if (isset($this->error['username'])) {
            $this->data['error_username'] = $this->error['username'];
        } else {
            $this->data['error_username'] = '';
        }
		
        if (isset($this->error['address'])) {
            $this->data['error_address'] = $this->error['address'];
        } else {
            $this->data['error_address'] = '';
        }
        if (isset($this->error['password'])) {
            $this->data['error_password'] = $this->error['password'];
        } else {
            $this->data['error_password'] = '';
        }
        if (isset($this->error['port'])) {
            $this->data['error_port'] = $this->error['port'];
        } else {
            $this->data['error_port'] = '';
        }
        if (isset($this->error['prefix'])) {
            $this->data['error_prefix'] = $this->error['prefix'];
        } else {
            $this->data['error_prefix'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_payment'),
            'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('payment/PPCoin', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/'.$this->payment_module_name.'&token=' . $this->session->data['token'];
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];	

		$this->load->model('localisation/order_status');
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post[$this->payment_module_name.'_rpc_username'])) {
			$this->data[$this->payment_module_name.'_rpc_username'] = $this->request->post[$this->payment_module_name.'_rpc_username'];
		} else {
			$this->data[$this->payment_module_name.'_rpc_username'] = $this->config->get($this->payment_module_name.'_rpc_username');
		} 
		if (isset($this->request->post[$this->payment_module_name.'_rpc_address'])) {
			$this->data[$this->payment_module_name.'_rpc_address'] = $this->request->post[$this->payment_module_name.'_rpc_address'];
		} else {
			$this->data[$this->payment_module_name.'_rpc_address'] = $this->config->get($this->payment_module_name.'_rpc_address');
		} 
		if (isset($this->request->post[$this->payment_module_name.'_rpc_password'])) {
			$this->data[$this->payment_module_name.'_rpc_password'] = $this->request->post[$this->payment_module_name.'_rpc_password'];
		} else {
			$this->data[$this->payment_module_name.'_rpc_password'] = $this->config->get($this->payment_module_name.'_rpc_password');
		} 
		if (isset($this->request->post[$this->payment_module_name.'_rpc_port'])) {
			$this->data[$this->payment_module_name.'_rpc_port'] = $this->request->post[$this->payment_module_name.'_rpc_port'];
		} else {
			$this->data[$this->payment_module_name.'_rpc_port'] = $this->config->get($this->payment_module_name.'_rpc_port');
		} 
		if (isset($this->request->post[$this->payment_module_name.'_prefix'])) {
			$this->data[$this->payment_module_name.'_prefix'] = $this->request->post[$this->payment_module_name.'_prefix'];
		} else {
			$this->data[$this->payment_module_name.'_prefix'] = $this->config->get($this->payment_module_name.'_prefix');
		} 
        if (isset($this->request->post[$this->payment_module_name.'_show_ppc'])) {
			$this->data[$this->payment_module_name.'_show_ppc'] = $this->request->post[$this->payment_module_name.'_show_ppc'];
		} else {
			$this->data[$this->payment_module_name.'_show_ppc'] = $this->config->get($this->payment_module_name.'_show_ppc');
		}
		if (isset($this->request->post[$this->payment_module_name.'_order_status_id'])) {
			$this->data[$this->payment_module_name.'_order_status_id'] = $this->request->post[$this->payment_module_name.'_order_status_id'];
		} else {
			$this->data[$this->payment_module_name.'_order_status_id'] = $this->config->get($this->payment_module_name.'_order_status_id'); 
		} 
        if (isset($this->request->post[$this->payment_module_name.'_status'])) {
			$this->data[$this->payment_module_name.'_status'] = $this->request->post[$this->payment_module_name.'_status'];
		} else {
			$this->data[$this->payment_module_name.'_status'] = $this->config->get($this->payment_module_name.'_status');
		}
		if (isset($this->request->post[$this->payment_module_name.'_sort_order'])) {
			$this->data[$this->payment_module_name.'_sort_order'] = $this->request->post[$this->payment_module_name.'_sort_order'];
		} else {
			$this->data[$this->payment_module_name.'_sort_order'] = $this->config->get($this->payment_module_name.'_sort_order');
		}
		$this->template = 'payment/'.$this->payment_module_name.'.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
