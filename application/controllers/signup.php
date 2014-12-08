<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('MFlash', 'MFlash');
        $this->load->model('MPlayer', 'MPlayer');
        session_start();
    }

    public function index($error = '')
    {
        $data = array();
        $data['error'] = $error;
        $data['token'] = md5(date('YmdHis').rand(0, 32000));
        $_SESSION['token'] = $data['token'];
        $data['flash'] = $this->MFlash->objGetFlashInfo();
        //$data['thxlist'] = $this->MThx->objGetThx(" limit 0, 10 ");
        $data['current'] = "signup";
        $this->load->view('templates/header', $data);
        $this->load->view('signup/index', $data);
        $this->load->view('templates/footer');
    }

    public function add(){
        if (isset($_POST) && $_POST != ""){
            $_POST = $this->security->xss_clean($_POST);
            if(isset($_POST['token']) && $_POST['token'] != $_SESSION['token']){
                echo "<script>alert('您的操作已过期');</script>";
                $this->index('您的操作已过期');
                return false;
            }else if(!isset($_POST['token'])){
                echo "<script>alert('您的操作已过期');</script>";
                $this->index('您的操作已过期');
                return false;
            }
            if(!isset($_POST['name_chi']) || !isset($_POST['name_en']) || !isset($_POST['age']) || !isset($_POST['tel'])
                || !isset($_POST['prcid']) || !isset($_POST['address']) || !isset($_POST['song']) || !isset($_POST['link'])){
                echo "<script>alert('您提交的信息不完整');</script>";
                $error = '您提交的信息不完整';
                $this->index($error);
                return false;
            }
            if(strlen($_POST['tel']) > 20){
                echo "<script>alert('您提交的电话不正确');</script>";
                $error = '您提交的电话不正确';
                $this->index($error);
                return false;
            }
            if(strlen($_POST['prcid']) > 20){
                echo "<script>alert('您提交的身份证不正确');</script>";
                $error = '您提交的身份证不正确';
                $this->index($error);
                return false;
            }
            if(strlen($_POST['age']) > 2){
                echo "<script>alert('您提交的年龄不正确');</script>";
                $error = '您提交的年龄不正确';
                $this->index($error);
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
                $this->index($error['error']);
                return false;
            }
            else
            {
                $data = $_POST;
                $upload_data = array('upload_data' => $this->upload->data());
                if(isset($data['token']))
                    unset($data['token']);
                if(isset($data['crop_token']))
                    unset($data['crop_token']);
                $data['avatardir'] = $upload_data['upload_data']['full_path'];
                $data['pic'] = $upload_data['upload_data']['file_name'];
                if(isset($data['token']))
                    unset($data['token']);
                if(isset($data['crop_token']))
                    unset($data['crop_token']);
                if(isset($data['userfile']))
                    unset($data['userfile']);
                if(isset($data['error']))
                    unset($data['error']);
                $result = $this->MPlayer->boolAddPlayer($data);
                if($result === true){
                    echo "<script>alert('报名成功');</script>";
                    $error = '报名成功';
                }else{
                    //@unlink($src); //crop image
                    //@unlink($save_path); //circle image
                    @unlink($data['avatardir']);
                    echo "<script>alert('报名失败 DATABASE ERROR');</script>";
                    $error = '报名失败 DATABASE ERROR';
                }
                $this->index($error);
                /*$objImg = imagecreatefromjpeg($upload_data['upload_data']['full_path']);
                if ($objImg !== FALSE && $objImg != null) {
                    //crop by users
                    $data = array();
                    $data = $_POST;
                    $data['pic'] = $upload_data['upload_data']['file_name'];
                    $data['crop_token'] = md5(date('YmdHis').rand(0, 32000));
                    $_SESSION['crop_token'] = $data['crop_token'];
                    $_SESSION[$data['pic']] = $upload_data['upload_data']['full_path'];
                    $_SESSION[$data['pic'].'post'] = $_POST;
                    $this->load->view('signup/crop', $data);
                    //exit();
                }*/
            }
            /*
            $data = $_POST;
            unset($data['token']);
            $this->MPlayer->boolAddPlayer($data);
            */
        }
    }

    /*public function upload(){
        $data['error'] = ' ';
        $this->load->view('templates/header.php', $data);
        $this->load->view('signup/upload.php', $data);
        $this->load->view('templates/footer.php');
    }*/

    /*public function do_upload(){
        $data = array();
        $data['error'] = ' ';
        $config['upload_path'] = './uploads/';
        $config['file_name'] = uniqid();
        $config['allowed_types'] = array('jpg', 'jpeg');
        $config['max_size']	= '500000';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload())
        {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('templates/header.php', $data);
            $this->load->view('signup/upload', $error);
            $this->load->view('templates/footer.php', $data);
        }
        else
        {
            $upload_data = array('upload_data' => $this->upload->data());
            $objImg = imagecreatefromjpeg($upload_data['upload_data']['full_path']);
            if ($objImg !== FALSE && $objImg != null) {
                //crop by users
                $data = array();
                $data['pic'] = $upload_data['upload_data']['full_path'];
                $this->load->view('signup/crop', $data);
            }
        }
    }*/

    public function crop(){
        /**
         * Jcrop image cropping plugin for jQuery
         * Example cropping script
         * @copyright 2008-2009 Kelly Hallman
         * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
         */

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST != "")
        {
            if(isset($_POST['crop_token']) && $_POST['crop_token'] != $_SESSION['crop_token']){
                $error = '您的操作已过期';
                $this->index($error);
                return false;
            }else if(!isset($_POST['crop_token'])){
                $_SESSION['crop_token'] = md5(date('YmdHis').rand(0, 32000));
                $error = '您的操作已过期';
                $this->index($error);
                return false;
            }
            $targ_w = $targ_h = 190;
            //$jpeg_quality = 90;
            $quality = 9;

            $pic = $_POST['pic'];
            $picname = $_POST['picname'];
            //debug($picname);exit;
            $src = $_SESSION[$picname];

            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
            $save_path = substr($src, 0, strpos($src, ".")) . "_crop.png";
            //$result = imagecopyresampled($save_path, imagejpeg($this->dst_img), 0, 0, 0, 0, $this->dst_w, $this->dst_h, $this->src_w, $this->src_h);
            $result = imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
                $targ_w,$targ_h,$_POST['w'],$_POST['h']);

            //header('Content-type: image/jpeg');
            $result = imagepng($dst_r,$save_path,$quality);

            //exit;
            $error = "";
            if($result === true){
                //$this->load->library('CircleCrop');
                include('application/libraries/CircleCrop.php');
                $objCrop = new CircleCrop(imagecreatefrompng($save_path), $save_path);
                $result = $objCrop->crop()->save();
                if($result === true){
                    $data = $_SESSION[$picname.'post'];
                    $data['pic'] = $pic;
                    if(isset($data['token']))
                        unset($data['token']);
                    if(isset($data['crop_token']))
                        unset($data['crop_token']);
                    $result = $this->MPlayer->boolAddPlayer($data);
                    if($result === true){
                        $error = '报名成功';
                    }else{
                        @unlink($src); //crop image
                        @unlink($save_path); //circle image
                        $error = '报名失败 DATABASE ERROR';
                    }
                }else{
                    @unlink($src); //crop image
                    @unlink($save_path); //circle image
                    $error = '报名失败 IMAGE CREATING ERROR';
                }
            }else{
                @unlink($src); //crop image
                $error = '报名失败 头像编辑失败';
            }
            $this->index($error);
            return false;
        }
        redirect('signup/index');
    }
}
