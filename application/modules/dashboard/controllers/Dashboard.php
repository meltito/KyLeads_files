<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	/**
     * Class constructor
     *
     * Loads required models, check if user has right to access this class, loads the hook class and add a hook point
     *
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();

		$model_list = [
		'user/Users_model' => 'MUsers',
		'sites/Sites_model' => 'MSites',
		'sites/Pages_model' => 'MPages',
		'settings/Apps_settings_model' => 'MApps',
		'settings/Payment_settings_model' => 'MPayments',
		'settings/Core_settings_model' => 'MCores'
		];
		$this->load->model($model_list);

		if ( ! $this->session->has_userdata('user_id'))
		{
			redirect('auth', 'refresh');
		}

		$this->hooks =& load_class('Hooks', 'core');

        /** Hook point */
        $this->hooks->call_hook('settings_construct');
	}

	/**
	 * Load the settings page
	 *
	 * @return 	void
	 */
	public function index()
	{
       error_reporting(-1);

        $this->data['title'] = 'KyLeads Dashboard';
        $this->data['content'] = 'dashboard';
        $this->data['page'] = 'site';
        

        $this->load->view('layout', $this->data);
    }
	

	/**
	 * Updates the apps settings
	 *
	 * @return 	void
	 */
	public function update()
	{
		
	}

	/**
	 * Update the payment settings
	 *
	 * @return 	void
	 */
	public function update_payment()
	{
		
	}

	/**
	 * Update the core settings
	 *
	 * @return 	void
	 */
	public function update_core()
	{
	
	}

	

}