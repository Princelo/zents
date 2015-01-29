<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dovote extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //$this->load->model('MFlash', 'MFlash');
        $this->load->model('MPlayer', 'MPlayer');
        $this->load->model('MVotelog', 'MVotelog');
        //$this->load->model('MThx', 'MThx');
        $this->load->helper('captcha');
        $this->load->helper('cookie');
        $this->objDB = $this->load->database("default", true);
        session_start();
    }


    public function index(){
        if(isset($_POST) && $_POST != ""){
            /*if(!$this->__validate_token('vote_token')){
                $this->error('您的操作已过期');
                return false;
            }*/
            //$this->__validate_token('validate_token', '验证错误!');
            if($this->__validate_captcha() === true){
                $data['ip'] = $_SERVER['REMOTE_ADDR'];
                $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $data['id'] = $_POST['id'];
                if($this->__validate_logcount($data) === true){
                    $this->error('您疑似投票次数过多，请检测您的操作环境。');
                    return false;
                }
                if($this->__validate_voted($_POST['id'])){
                    $this->error('您已为该选手投过票');
                    return false;
                }
                $result = false;
                if(isset($_POST['id'])){
                    $result = $this->MPlayer->boolVote($_POST['id']);
                    //$this->input->set_cookie(array('voted'=> ( $this->input->cookie('voted') + 1 ) ));

                    //set_cookie('voted', intval(get_cookie('voted')) + 1, 3600*24);
                    $this->voidSetVotedCookie();
                    set_cookie('voted'.$_POST['id'], '1', 3600*24);

                    $data['vote_datetime'] = time();
                    $data['pid'] = $data['id'];
                    unset($data['id']);
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

    private function  __validate_token($token = 'token'){
        if(isset($_POST[$token]) && $_POST[$token] != $_SESSION[$token]){
            $_SESSION[$token] = md5(date('YmdHis').rand(0, 32000));
            return false;
        }else if(!isset($_POST[$token])){
            $_SESSION[$token] = md5(date('YmdHis').rand(0, 32000));
            return false;
        }else if($_POST[$token] == $_SESSION[$token]){
            return true;
        }

    }

    public function error($error){
        $data = array();
        $data['error'] = $error;
        $this->load->view('vote/error', $data);
        return false;
    }

    public function success(){
        $this->load->view('vote/success');
        return true;
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
        if(intval(get_cookie('voted')) >= 3)
            return true;

        if(intval(get_cookie('votedthree')) > 0 &&
            intval(get_cookie('votedtwo')) > 0 &&
            intval(get_cookie('voted')) > 0 )
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

        if($row->count > 15 && strpos($data['user_agent'], "MicroMessenger") <= 0 ){
            $sql = "insert into failed_voted_log(user_agent, ip, pid, vote_datetime, strdate)
                values (?, ?, ?, ?, ?)";
            $binds = array($data['user_agent'], $data['ip'], $data['id'], time(), date("Y-m-d H:i:s"));
            $query = $this->objDB->query($sql, $binds);
            return true;
        }else if ($row->count > 10){
            $sql = "insert into failed_voted_log(user_agent, ip, pid, vote_datetime, strdate)
                values (?, ?, ?, ?, ?)";
            $binds = array($data['user_agent'], $data['ip'], $data['id'], time(), date("Y-m-d H:i:s"));
            $query = $this->objDB->query($sql, $binds);
            return true;
        }


        return false;

    }

    private function __validate_voted($id){
        if(get_cookie('voted'.$id) == '1')
            return true;
        $expiration = time() - 3600 * 24;
        $sql = "SELECT COUNT(1) as count FROM vote_log WHERE ip = ? AND pid = ? AND vote_datetime > ?";
        $binds = array($_SERVER['REMOTE_ADDR'], $id, $expiration);
        $query = $this->objDB->query($sql, $binds);
        $row = $query->row();
        if($row->count > 0)
            return true;

        return false;

    }

    private function voidSetVotedCookie(){
        if(intval(get_cookie('voted')) >= 1){
            if(intval(get_cookie('votedtwo')) >= 1){
                set_cookie('votedthree', intval(get_cookie('votedthree')) + 1, 3600*24);
            }else{
                set_cookie('votedtwo', intval(get_cookie('votedtwo')) + 1, 3600*24);
            }
        }else{
            set_cookie('voted', 1, 3600*24);
        }
    }
}

