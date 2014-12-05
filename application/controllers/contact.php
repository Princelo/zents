<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('MFlash', 'MFlash');
        //$this->load->model('MPlayer', 'MPlayer');
        //$this->load->model('MThx', 'MThx');
    }

    public function index()
    {
        $data = array();
        $data['flash'] = $this->MFlash->objGetFlashInfo();
        //$data['playerlist'] = $this->MPlayer->objGetPlayers(" limit 0, 7 ");
        //$data['thxlist'] = $this->MThx->objGetThx(" limit 0, 10 ");
        $data['current'] = "contact";
        $this->load->view('templates/header', $data);
        $this->load->view('contact/index', $data);
        $this->load->view('templates/footer');
    }
}

