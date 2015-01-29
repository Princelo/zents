<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller {

    public function index($id, $offset = 0)
    {
        $this->load->model('MComment', 'MComment');
        $this->load->library('pagination');
        $data = array();
        $config['base_url'] = base_url()."index.php/comment/index/";
        $config['total_rows'] = $this->MComment->intGetCommentsCount($id);
        /*$config['per_page'] = 3;
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();
        */
        $limit = '';
        /*if($offset > 0){
            $limit .= " limit {$offset}, " . ($config['per_page']) . " ";
        }else{
            $limit .= " limit 0, {$config['per_page']} ";
        }*/
        $data['commentlist'] = $this->MComment->objGetComments($limit, $id);
        $data['id'] = $id;
        $data['offset'] = $offset;
        $this->load->view('templates/simpleheader', $data);
        $this->load->view('comment/index', $data);
        $this->load->view('templates/simplefooter');
    }

    public function add($id)
    {
        if(isset($_POST) && $_POST != "")
        {
            $_POST = $this->security->xss_clean($_POST);
            $this->load->model('MComment', 'MComment');
            if(strlen($_POST['content']) > 255)
            {
                echo '<script>alert("content too long!");</script>';
                return false;
            }
            if(strlen($_POST['name']) > 45)
            {
                echo '<script>alert("name too long!");</script>';
                return false;
            }
            if(strlen($_POST['email']) > 45)
            {
                echo '<script>alert("email too long!");</script>';
                return false;
            }
            if($_POST['email'] == "" || $_POST['name'] == "" || $_POST['content'] == "")
                return false;
            $data = $_POST;
            $result = $this->MComment->boolAddComment($id, $data);
            if($result === true)
            {
                echo '<script>alert("submit successfully");</script>';
                redirect("comment/index/{$id}");
            }
            if($result === false)
            {
                echo '<script>alert("submit failed");</script>';
                redirect("comment/index/{$id}");
            }
        }
    }
}
