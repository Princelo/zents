<?php
/**
 *
 **/
class MFlash extends CI_Model
{
    private $objDB;

    function __construct()
    {
        parent::__construct();
        $this->objDB = $this->load->database("default", true);
    }

    public function objGetFlashInfo( $limit = '')
    {
        $query_sql = "";
        $query_sql .= "
            select
                *
                from
                flash
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

    public function objGetFlash($id){
        $query_sql = "";
        $query_sql .= "
            select
                *
                from
                flash
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

    public function boolAdd($data){
        if(!isset($data['pic']))
            return false;
        $insert_sql = $this->objDB->insert_string("flash", $data);


        $result = $this->objDB->query($insert_sql);

        if($result !== false) {
            return true;
        }else {
            return false;
        }
    }

    public function boolDelete($id){
        $this->objDB->from("flash");
        $this->objDB->where("id", $id);
        $this->objDB->delete();

        return ($this->objDB->affected_rows() > 0 );
    }


    public function boolUpdateFlashInfo($data){
        $update_data = array();
        if(isset($_POST['url']))
            $update_data['url'] = $_POST['url'];
        $update_sql =  $this->objDB->update_string('flash', $update_data, array("id"=>$_POST['id']));
        $result = $this->objDB->query($update_sql);
        if($result === true)
            return true;
        else
            return false;

    }
}