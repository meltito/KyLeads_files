<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends MY_Controller {

    /**
     * Class constructor
     *
     * Loads required models, check if user has right to access this class, load the hook class and add a hook point
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();

        $model_list = [
        'user/Users_model' => 'MUsers',
        'package/Packages_model' => 'MPackages',
        'settings/Payment_settings_model' => 'MPayments',
        'sites/Sites_model' => 'MSites',
        'sites/Pages_model' => 'MPages',
        'shared/Revision_model' => 'MRevisions',
        'shared/Ftp_model' => 'MFtp'
        ];
        $this->load->model($model_list);

        if ( ! $this->session->has_userdata('user_id') && $this->uri->segment(1) != 'loadsinglepage')
        {
            redirect('auth', 'refresh');
        }

        $this->hooks =& load_class('Hooks', 'core');

        
    }

    /**
     * Loads site's dashboard
     *
     * @return  void
     */
    public function index()
    {
        /** Hook point */
        $this->hooks->call_hook('sites_index_pre');

        $this->data['title'] = $this->lang->line('sites_index_title');
        $this->data['content'] = 'sites';
        $this->data['page'] = 'site';
        /** Grab us some sites */
        $this->data['sites'] = $this->MSites->all();
        /** Get all users */
        $this->data['users'] = $this->MUsers->get_all();
        $gateway = $this->MPayments->get_by_name('payment_gateway');
        $this->data['packages'] = $this->MPackages->get_all($gateway[0]->value);
        $package = $this->MPackages->get_by_id($this->session->userdata('package_id'));
        $sites = $this->MSites->site_by_user($this->session->userdata('user_id'));
        if (count($package) > 0)
        {
            $user_sites = count($sites);
            $package_sites = (int)$package['sites_number'];
            if ($user_sites > 0)
            {
                /** User's site is more or equal to its package number */
                if ($user_sites >= $package_sites)
                {
                    $this->data['site_limitation'] = $this->lang->line('sites_index_reach_site_number');
                }
                else if ($user_sites + 2 >= $package_sites)
                {
                    $this->data['site_limitation'] = $this->lang->line('sites_index_almost_reach_site_number');
                }
            }
        }

        /** Hook point */
        $this->hooks->call_hook('sites_index_post');

        $this->load->view('layout', $this->data);
    }


}