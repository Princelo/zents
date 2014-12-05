<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include('application/libraries/MY_Controller.php');
class Unvadmin extends CI_Controller {

    private $objDB;
    public function __construct(){
        parent::__construct();
        $this->load->model('MFlash', 'MFlash');
        $this->load->model('MPlayer', 'MPlayer');
        $this->load->model('MThx', 'MThx');
        $this->objDB = $this->load->database('default', true);
        $this->load->model('MAdmin', 'MAdmin');
        $this->load->helper('captcha');
        $this->load->library('pagination');
        $this->load->helper('string');
        session_start();
    }

    public function index($error = '')
    {
        if(isset($_SESSION['admin']))
            redirect('unvadmin/manage');
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
        $data['captcha'] = $cap['image'];
        $data['error'] = $error;
        $this->load->view('unvadmin/index', $data);
    }

    public function login(){
        if(isset($_POST['captcha']) && isset($_POST['login_id']) && isset($_POST['password'])){
            $_POST['password'] = md5($_POST['password']);
            if($this->__validate_captcha() === true){
                if($this->MAdmin->boolVerify($_POST['login_id'], $_POST['password'])){
                    $_SESSION['admin'] = $_POST['login_id'];
                    redirect('unvadmin/manage', 'refresh');
                }else{
                    $this->index('用戶或密码错误');
                }
            }else{
                $this->index('验证码错误');
            }
        }
    }

    public function manage(){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $data = array();
        $data['playerlist'] = $this->MPlayer->objGetPlayers("", "");
        $this->load->view('unvadmin/header', $data);
        $this->load->view('unvadmin/manage', $data);
    }

    public function singer($offset = 0){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        if(isset($_POST['search'])){
            $config['base_url'] = base_url()."index.php/unvadmin/singer/";
            $config['total_rows'] =
                $this->MPlayer->intGetPlayersCount(" and (name_chi like '%{$_POST['search']}%' or name_en like '%{$_POST['search']}%' or song like '%{$_POST['search']}%')");
            $config['per_page'] = 12;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            if($offset > 0){
                $limit .= " limit {$offset}, " . ($config['per_page']) . " ";
            }else{
                $limit .= " limit 0, {$config['per_page']} ";
            }
            $where = " and ( name_chi like '%{$_POST['search']}%'";
            $where .= " or name_en like '%{$_POST['search']}%'";
            $where .= " or song like '%{$_POST['search']}%' )";
            $data['valid'] = "all";
            $data['playerlist'] = $this->MPlayer->objGetPlayers(" order by id desc ".$limit, $where);
            $this->load->view('unvadmin/header', $data);
            $this->load->view('unvadmin/singer', $data);
            return true;
        }
        $config['base_url'] = base_url()."index.php/unvadmin/singer/";
        $config['total_rows'] = $this->MPlayer->intGetPlayersCount("");
        $config['per_page'] = 12;
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();
        $limit = '';
        if($offset > 0){
            $limit .= " limit {$offset}, " . ($config['per_page']) . " ";
        }else{
            $limit .= " limit 0, {$config['per_page']} ";
        }
        $data['playerlist'] = $this->MPlayer->objGetPlayers(" order by id desc, sort desc ".$limit, "");
        $data['valid'] = "all";
        $this->load->view('unvadmin/header', $data);
        $this->load->view('unvadmin/singer', $data);
    }

    public function invalid($offset = 0){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        if(isset($_POST['search'])){
            $config['base_url'] = base_url()."index.php/unvadmin/invalid/";
            $where = " and ( name_chi like '%{$_POST['search']}%'";
            $where .= " or name_en like '%{$_POST['search']}%'";
            $where .= " or song like '%{$_POST['search']}%' ) and is_valid = 0 ";
            $config['total_rows'] =
                $this->MPlayer->intGetPlayersCount($where);
            $config['per_page'] = 12;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            if($offset > 0){
                $limit .= " limit {$offset}, " . ($config['per_page']) . " ";
            }else{
                $limit .= " limit 0, {$config['per_page']} ";
            }
            $data['playerlist'] = $this->MPlayer->objGetPlayers(" order by id desc ".$limit, $where);
            $data['valid'] = "invalid";
            $this->load->view('unvadmin/header', $data);
            $this->load->view('unvadmin/singer', $data);
            return true;
        }
        $config['base_url'] = base_url()."index.php/unvadmin/invalid/";
        $config['total_rows'] = $this->MPlayer->intGetPlayersCount(" and is_valid = 0");
        $config['per_page'] = 12;
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();
        $limit = '';
        if($offset > 0){
            $limit .= " limit {$offset}, " . ($config['per_page']) . " ";
        }else{
            $limit .= " limit 0, {$config['per_page']} ";
        }
        $data['playerlist'] = $this->MPlayer->objGetPlayers(" order by id desc, sort desc ".$limit, " and is_valid = 0 ");
        $data['valid'] = "invalid";
        $this->load->view('unvadmin/header', $data);
        $this->load->view('unvadmin/singer', $data);
    }

    public function singeredit($id, $error = ''){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $data = array();
        $data['v'] = $this->MPlayer->objGetPlayerInfo($id, "");
        $data['error'] = $error;
        $this->load->view('unvadmin/header', $data);
        $this->load->view('unvadmin/singeredit', $data);

    }

    public function singerupdate(){
        $result = false;
        if(isset($_POST) && $_POST != "" && isset($_POST['id']) && $_POST['id'] != ""){
            $result = $this->MPlayer->boolUpdatePlayerInfo($_POST);
        }
        if($result === true){
            echo "<script>alert('SUCCESS');</script>";
            if(isset($_POST['id']) && $_POST['id'] != "")
                $this->singeredit($_POST['id']);
            else
                $this->singer();
        }else{
            echo "<script>alert('ERROR');</script>";
            if(isset($_POST['id']) && $_POST['id'] != "")
                $this->singeredit($_POST['id']);
            else
                $this->singer();
        }
    }

    public function singerdelete($id){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $result = $this->MPlayer->boolDelete($id);
        if($result === true){
            echo "<script>alert('SUCCESS');</script>";
            $this->singer();
        }else{
            echo "<script>alert('ERROR');</script>";
            $this->singer();
        }
    }

    public function flash($error = ''){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $data['flashlist'] = $this->MFlash->objGetFlashInfo();
        $data['token'] = md5(date('YmdHis').rand(0, 32000));
        $data['error'] = $error;
        $_SESSION['token'] = $data['token'];
        $this->load->view('unvadmin/header', $data);
        $this->load->view('unvadmin/flash', $data);
    }

    public function flashadd(){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        if (isset($_POST) && $_POST != ""){
            if(isset($_POST['token']) && $_POST['token'] != $_SESSION['token']){
                $this->flash('您的操作已过期');
                return false;
            }else if(!isset($_POST['token'])){
                $this->flash('您的操作已过期');
                return false;
            }
            $data['token'] = md5(date('YmdHis').rand(0, 32000));
            $_SESSION['token'] = $data['token'];
            $data = array();
            $data['error'] = ' ';
            $config['upload_path'] = './uploads/';
            $config['file_name'] = uniqid();
            $config['allowed_types'] = 'jpg';
            $config['max_size']	= '5000000';

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload())
            {
                $error = array('error' => $this->upload->display_errors());
                $this->flash($error['error']);
                return false;
            }
            else
            {
                $data = array();
                $upload_data = array('upload_data' => $this->upload->data());
                $data['pic'] = base_url().'uploads/'.$upload_data['upload_data']['file_name'];
                if(isset($_POST['url']))
                    $data['url'] = $_POST['url'];

                $result = $this->MFlash->boolAdd($data);
                if($result === true){
                    echo "<script>alert('SUCCESS');</script>";
                    $this->flash();
                }else{
                    echo "<script>alert('ERROR');</script>";
                    $this->flash();
                }
            }
        }
    }


    public function flashedit($id){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $data = array();
        $data['v'] = $this->MFlash->objGetFlash($id, "");
        $this->load->view('unvadmin/header', $data);
        $this->load->view('unvadmin/flashedit', $data);

    }

    public function flashupdate(){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $result = false;
        if(isset($_POST) && $_POST != "" && isset($_POST['id']) && $_POST['id'] != ""){
            $result = $this->MFlash->boolUpdateFlashInfo($_POST);
        }
        if($result === true){
            echo "<script>alert('SUCCESS');</script>";
            if(isset($_POST['id']) && $_POST['id'] != "")
                $this->flashedit($_POST['id']);
            else
                $this->flash();
        }else{
            echo "<script>alert('ERROR');</script>";
            if(isset($_POST['id']) && $_POST['id'] != "")
                $this->flashedit($_POST['id']);
            else
                $this->flash();
        }
    }

    public function flashdelete($id){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $result = false;
        $result = $this->MFlash->boolDelete($id);
        if($result === true){
            echo "<script>alert('SUCCESS');</script>";
            $this->flash();
        }else{
            echo "<script>alert('ERROR');</script>";
            $this->flash();
        }

    }


    public function thx($error = ''){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $data['thxlist'] = $this->MThx->objGetThx();
        $data['token'] = md5(date('YmdHis').rand(0, 32000));
        $data['error'] = $error;
        $_SESSION['token'] = $data['token'];
        $this->load->view('unvadmin/header', $data);
        $this->load->view('unvadmin/thx', $data);
    }

    public function thxadd(){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        if (isset($_POST) && $_POST != ""){
            if(isset($_POST['token']) && $_POST['token'] != $_SESSION['token']){
                $this->thx('您的操作已过期');
                return false;
            }else if(!isset($_POST['token'])){
                $this->thx('您的操作已过期');
                return false;
            }
            $data['token'] = md5(date('YmdHis').rand(0, 32000));
            $_SESSION['token'] = $data['token'];
            $data = array();
            $data['error'] = ' ';
            $config['upload_path'] = './uploads/';
            $config['file_name'] = uniqid();
            $config['allowed_types'] = 'jpg';
            $config['max_size']	= '500000';

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload())
            {
                $error = array('error' => $this->upload->display_errors());
                $this->thx($error['error']);
                return false;
            }
            else
            {
                $data = array();
                $upload_data = array('upload_data' => $this->upload->data());
                $data['pic'] = base_url().'uploads/'.$upload_data['upload_data']['file_name'];
                if(isset($_POST['url']))
                    $data['url'] = $_POST['url'];

                $result = $this->MThx->boolAdd($data);
                if($result === true){
                    echo "<script>alert('SUCCESS');</script>";
                    $this->thx();
                }else{
                    echo "<script>alert('ERROR');</script>";
                    $this->thx();
                }
            }
        }
    }


    public function thxedit($id){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $data = array();
        $data['v'] = $this->MThx->objGetThxInfo($id, "");
        $this->load->view('unvadmin/header', $data);
        $this->load->view('unvadmin/thxedit', $data);

    }

    public function thxupdate(){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $result = false;
        if(isset($_POST) && $_POST != "" && isset($_POST['id']) && $_POST['id'] != ""){
            $result = $this->MThx->boolUpdateThxInfo($_POST);
        }
        if($result === true){
            echo "<script>alert('SUCCESS');</script>";
            if(isset($_POST['id']) && $_POST['id'] != "")
                $this->thxedit($_POST['id']);
            else
                $this->thx();
        }else{
            echo "<script>alert('ERROR');</script>";
            if(isset($_POST['id']) && $_POST['id'] != "")
                $this->thxedit($_POST['id']);
            else
                $this->thx();
        }
    }

    public function thxdelete($id){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $result = false;
        $result = $this->MThx->bootDelete($id);
        if($result === true){
            echo "<script>alert('SUCCESS');</script>";
            $this->thx();
        }else{
            echo "<script>alert('ERROR');</script>";
            $this->thx();
        }

    }

    public function logout(){
        session_destroy();
        $this->index();
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

    public function password($error = ''){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        $data = array();
        $data['error'] = $error;
        $this->load->view('unvadmin/header', $data);
        $this->load->view('unvadmin/password', $data);
    }

    public function passwordupdate(){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        if(isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] != "" && $_POST['password2'] != ""
            && $_POST['password'] == $_POST['password2']){
            $_POST['password'] = md5($_POST['password']);
            $_POST['password2'] = md5($_POST['password2']);
            $result = $this->MAdmin->boolUpdatePassword($_POST['password'], $_SESSION['admin']);
            if($result === true)
                $this->password('更改密码成功');
            else
                $this->password('未知错误');
        }else{
            $this->password('请输入完整信息並保证输入相同密码');
        }
    }

    public function crop($id){
        if(!isset($_SESSION['admin'])){
            redirect('unvadmin', 'refresh');
        }
        if(isset($_POST) && $_POST != "" && isset($_POST['pic'])){
            if(isset($_POST['crop_token']) && $_POST['crop_token'] != $_SESSION['crop_token']){
                $error = '您的操作已过期';
                $this->singeredit($id, $error);
                return false;
            }else if(!isset($_POST['crop_token'])){
                $_SESSION['crop_token'] = md5(date('YmdHis').rand(0, 32000));
                $error = '您的操作已过期';
                $this->singeredit($id, $error);
                return false;
            }
            $v = $this->MPlayer->objGetPlayerInfo($id, "");
            $targ_w = $targ_h = 190;
            $quality = 9;
            $pic = $_POST['pic'];
            $picname = $_POST['picname'];
            //debug($picname);exit;
            $src = $v->avatardir;

            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
            $save_path = substr($src, 0, strpos($src, ".")) . "_crop.png";
            $result = imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
                $targ_w,$targ_h,$_POST['w'],$_POST['h']);

            $result = imagepng($dst_r,$save_path,$quality);
            $error = "";
            if($result === true){
                include('application/libraries/CircleCrop.php');
                $objCrop = new CircleCrop(imagecreatefrompng($save_path), $save_path);
                $result = $objCrop->crop()->save();
                if($result === true){
                    $error = '裁剪成功';
                }else{
                    @unlink($save_path); //crop image
                    @unlink($objCrop->strGetSavePath()); //circle image
                    $error = '裁剪失败';
                }
            }else{
                @unlink($save_path); //crop image
                $error = '裁剪失败';
            }
            $this->singeredit($id, $error);
            return false;
        }
        $data = array();
        $data['crop_token'] = md5(date('YmdHis').rand(0, 32000));
        $_SESSION['crop_token'] = $data['crop_token'];
        $v = $this->MPlayer->objGetPlayerInfo($id, "");
        $data['pic'] = $v->pic;
        $data['id'] = $v->id;
        $this->load->view('unvadmin/crop', $data);
    }
}

