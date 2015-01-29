<?php
/**
 *
 **/
class MComment extends CI_Model
{
    private $objDB;

    function __construct()
    {
        parent::__construct();
        $this->objDB = $this->load->database("default", true);
    }

    function intGetCommentsCount($id)
    {
        $query_sql = "";
        $query_sql .= "
            select
                count(1) as count
                from
                comment
            where 1 = 1
                and player_id = ?
        ";
        $binds = array($id);
        $query = $this->objDB->query($query_sql, $binds);


        if($query->num_rows() > 0) {
            $count = $query->row()->count;
        }

        $query->free_result();

        return $count;
    }

    function objGetComments($limit, $id)
    {
        $query_sql = "";
        $query_sql .= "
            select
                *
                from
                comment
            where 1 = 1
            and player_id = ?
            order by floor DESC
        ";
        $binds = array($id);
        $data = array();
        $query = $this->objDB->query($query_sql, $binds);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        return $data;
    }

    function boolAddComment($id, $data)
    {
        $data['player_id'] = $id;
        $data['time'] = date('Y-m-d H:i:s');
        $data['floor'] = $this->intGetCommentsCount($id) + 1;
        $insert_sql = $this->objDB->insert_string("comment", $data);
        $result = $this->objDB->query($insert_sql);
        if($result === true){
            return true;
        }
        else{
            return false;
        }
    }
}
