<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller {
    var $data;
    var $paging_config;
    public $user;

    public function __construct($need_auth = true, $need_profiler = true) {
        parent::__construct();
        session_start();
        //header('Pragma: private'); //allow cache page
        $this->checkAuth();
    }



    private function checkAuth() {
        if(isset($_SESSION['admin']))
            $user = $_SESSION['admin'];
        if(!$user) {
            redirect('unvadmin');
        }
    }
}
