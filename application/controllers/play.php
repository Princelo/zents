<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Play extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('MPlayer', 'MPlayer');
    }

    public function index($id)
    {

        $data = array();
        $v = $this->MPlayer->objGetPlayerInfo($id);
        $data['link'] = $v->link;
        if(!empty($data['link'])){
            $this->load->view('templates/simpleheader', $data);
            $this->load->view('play/index', $data);
            $this->load->view('templates/simplefooter');
        }else{
            echo "<script>alert('播放失败');</script>";
        }
    }

}

