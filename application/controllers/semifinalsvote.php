<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Semifinalsvote extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //$this->load->model('MFlash', 'MFlash');
        $this->load->model('MPlayer', 'MPlayer');
        $this->load->model('MVotelog', 'MVotelog');
        //$this->load->model('MThx', 'MThx');
        $this->load->helper('captcha');
        $this->load->helper('cookie');
        $this->load->helper('string');
        $this->objDB = $this->load->database("default", true);
        session_start();
        if(get_cookie("voted") == "0"){
            set_cookie("voted", "0", 60*24);
        }
    }

    public function index($id)
    {
        /* for view
            $vals = array(
            'word' => 'Random word',
            'img_path' => './captcha/',
            'img_url' => 'http://example.com/captcha/',
            'font_path' => './path/to/fonts/texb.ttf',
            'img_width' => '150',
            'img_height' => 30,
            'expiration' => 7200
            );

            $cap = create_captcha($vals);
            echo $cap['image'];
         */
        $vals = array(
            'word' => random_string('alnum', 5),
            'img_path' => './captcha/',
            'img_url' => base_url().'captcha/',
        );

        $cap = create_captcha($vals);

        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
        );

        $query = $this->objDB->insert_string('captcha', $data);
        $this->objDB->query($query);

        $data['playerinfo'] = $this->MPlayer->objGetPlayerInfo($id);
        $data['vote_token'] = md5(date('YmdHis').rand(0, 32000));
        $_SESSION['vote_token'] = $data['vote_token'];
        $data['captcha'] = $cap['image'];
        if(!empty($data['playerinfo'])){
            $this->load->view('templates/simpleheader', $data);
            $this->load->view('vote/index', $data);
            $this->load->view('templates/simplefooter');
        }else{
            redirect('playerlist');
        }
    }

    public function vote(){
        if(isset($_POST) && $_POST != ""){
            $result = $this->__validate_token('vote_token');
            if (!$result)
                return false;
            //$this->__validate_token('validate_token', '验证错误!');
            if($this->__validate_captcha() === true){
                $data['ip'] = $_SERVER['REMOTE_HOST'];
                $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $data['id'] = $_POST['id'];
                if($this->__validate_logcount($data) === true){
                    $this->error('您疑似投票次数过多，请检测您的操作环境。');
                }
                $result = false;
                if(isset($_POST['id'])){
                    $result = $this->MPlayer->boolSemiFinalsVote($_POST['id']);
                    $this->input->set_cookie(array('voted'=> ( $this->input->cookie('voted') + 1 ) ));
                    $data['vote_datetime'] = time();
                    $this->MVotelog->boolLog($data);
                }
                if($result === true)
                    $this->success();
                else
                    $this->error('投票失败 DATABASE ERROR');
                return false;
            }else{
                $this->error('验证错误！');
            }

        }
    }

    private function  __validate_token($token = 'token', $error = '您的操作已过期'){
        if(isset($_POST[$token]) && $_POST[$token] != $_SESSION[$token]){
            $_SESSION[$token] = md5(date('YmdHis').rand(0, 32000));
            $this->error($error);
            return false;
        }else if(!isset($_POST[$token])){
            $_SESSION[$token] = md5(date('YmdHis').rand(0, 32000));
            $this->error($error);
            return false;
        }else if($_POST[$token] == $_SESSION[$token]){
            return true;
        }

    }

    public function error($error){
        $data = array();
        $data['error'] = $error;
        $this->load->view('vote/error', $data);
        exit(0);
    }

    public function success(){
        $this->load->view('vote/success');
        exit(0);
    }

    private function __validate_captcha(){
        // 首先删除旧的验证码
        $expiration = time()-7200; // 2小时限制
        $this->objDB->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

        // 然后再看是否有验证码存在:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
        $query = $this->objDB->query($sql, $binds);
        $row = $query->row();

        if ($row->count == 0)
        {
            return false;
        }else{
            return true;
        }
    }

    private function __validate_logcount($data){
        if(intval($this->input->cookie('voted')) > 2)
            return true;

        $expiration = time() - 3600 * 24;
        $sql = "SELECT COUNT(1) AS count FROM vote_log WHERE ip = ? AND vote_datetime > ?";
        $binds = array($data['ip'], $expiration);
        $query = $this->objDB->query($sql, $binds);
        $row = $query->row();

        if($row->count > 2)
            return true;

        $sql = "SELECT COUNT(1) as count FROM vote_log WHERE user_agent = ? AND vote_datetime > ?";
        $binds = array($data['user_agent'], $expiration);
        $query = $this->objDB->query($sql, $binds);

        $row = $query->row();

        if($row->count > 10)
            return true;

        return false;

    }
}

