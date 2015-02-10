<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Playerlist50 extends CI_Controller {

    public $db;
    public function __construct(){
        parent::__construct();
        $this->load->model('MFlash', 'MFlash');
        $this->load->model('MPlayer', 'MPlayer');
        //$this->load->model('MThx', 'MThx');
        $this->load->library('pagination');
        $this->db = $this->load->database('default', true);
    }

    public function index($offset = 0)
    {
        if(isset($_POST['search']) && trim($_POST['search']) != ""){
            $data['flash'] = $this->MFlash->objGetFlashInfo();
            $_POST['search'] = trim($_POST['search']);
            $search = $this->db->escape_like_str($_POST['search']);
            $config['base_url'] = base_url()."index.php/playerlist50/index/";
            $where = " and (name_chi like '%{$search}%' or name_en like '%{$search}%' ";
            if(is_numeric($_POST['search'])){
                $where .= " or id = '" . intval($search) . "' )";
            }else{
                $where .= ")";
            }
            $config['total_rows'] =
                $this->MPlayer->intGetPlayersSemiFinalsCount($where);
            $config['per_page'] = 12;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            if($offset > 0){
                $limit .= " limit {$offset}, " . ($config['per_page']) . " ";
            }else{
                $limit .= " limit 0, {$config['per_page']} ";
            }
            $data['playerlist'] = $this->MPlayer->objGetPlayersSemiFinals(" order by sort desc, id ".$limit, $where);
            $data['current'] = "playerlist";
            $expiration = time() - 3600 * 24;
            $data['votedlist'] = $this->MPlayer->arrGetVotedPlayers($_SERVER['REMOTE_ADDR'], $expiration);
            $this->load->view('templates/header', $data);
            $this->load->view('playerlist50/index', $data);
            $this->load->view('templates/footer');
            return true;
        }
        $data = array();
        $data['flash'] = $this->MFlash->objGetFlashInfo();
        $config['base_url'] = base_url()."index.php/playerlist50/index/";
        $config['total_rows'] = $this->MPlayer->intGetPlayersSemiFinalsCount();
        $config['per_page'] = 12;
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();
        $limit = '';
        if($offset > 0){
            $limit .= " limit {$offset}, " . ($config['per_page']) . " ";
        }else{
            $limit .= " limit 0, {$config['per_page']} ";
        }
        $data['playerlist'] = $this->MPlayer->objGetPlayersSemiFinals(" order by sort desc, id ".$limit);
        $expiration = time() - 3600 * 24;
        $data['votedlist'] = $this->MPlayer->arrGetVotedPlayers($_SERVER['REMOTE_ADDR'], $expiration);
        //$data['thxlist'] = $this->MThx->objGetThx(" limit 0, 10 ");
        $data['current'] = "playerlist";
        $this->load->view('templates/header', $data);
        $this->load->view('playerlist50/index', $data);
        $this->load->view('templates/footer');
    }
}
