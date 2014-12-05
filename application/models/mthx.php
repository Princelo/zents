<?php
/**
 *
 **/
class MThx extends CI_Model
{
    private $objDB;

    function __construct()
    {
        parent::__construct();
        $this->objDB = $this->load->database("default", true);
    }

    public function objGetThx( $limit = '')
    {
        $query_sql = "";
        $query_sql = "
            select
                *
                from
                thxlist
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

    public function boolAdd($data){
        if(!isset($data['pic']))
            return false;
        $insert_sql = $this->objDB->insert_string("thxlist", $data);


        $result = $this->objDB->query($insert_sql);

        if($result !== false) {
            return true;
        }else {
            return false;
        }
    }


    public function objGetThxInfo($id){
        $query_sql = "";
        $query_sql .= "
            select
                *
                from
                thxlist
            where 1 = 1
            and
            id = {$id}
        ";
        $data = array();
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        return $data[0];

    }


    public function boolUpdateThxInfo($data){
        $update_data = array();
        if(isset($_POST['link']))
            $update_data['link'] = $_POST['link'];
        $update_sql =  $this->objDB->update_string('thxlist', $update_data, array("id"=>$_POST['id']));
        $result = $this->objDB->query($update_sql);
        if($result === true)
            return true;
        else
            return false;

    }

    public function boolDelete($id){
        $this->db->from("thxlist");
        $this->db->where("id", $id);
        $this->db->delete();

        return ($this->objDB->affected_rows() > 0 );
    }
}