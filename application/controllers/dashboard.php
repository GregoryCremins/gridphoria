<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

//        $this->output->enable_profiler(TRUE);
    }

    public function index() {
//        redirect(base_url());
        echo "Dashboard";
    }

}