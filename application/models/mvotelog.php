<?php
/**
 *
 **/
class MVotelog extends CI_Model
{
    private $objDB;

    function __construct()
    {
        parent::__construct();
        $this->objDB = $this->load->database("default", true);
    }

    public function objGetLog( $limit = '')
    {
        $query_sql = "";
        $query_sql = "
            select
                *
                from
                vote_log
            {$limit}
        ";
        $data = array();
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        return $data;
    }

    public function boolLog($data){
        $insert_sql = $this->objDB->insert_string("vote_log", $data);
        $result = $this->objDB->query($insert_sql);
        if($result === true){
            return true;
        }
        else{
            return false;
        }
    }
}