<?php
/**
 *
 **/
class MPlayer extends CI_Model
{
    private $objDB;

    function __construct()
    {
        parent::__construct();
        $this->objDB = $this->load->database("default", true);
    }

    public function objGetPlayers($limit = '', $where = " and is_valid = 1 ")
    {
        $query_sql = "";
        $query_sql .= "
            select
                *
                from
                playerlist
            where 1 = 1
            {$where}
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

    public function objGetPlayerInfo($id, $where = " and is_valid = 1 "){
        $query_sql = "";
        $query_sql .= "
            select
                *
            from
                playerlist
            where 1 = 1
            and
            id = {$id}
            {$where}
        ";
        $data = array();
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        if(isset($data[0]))
            return $data[0];
        else
            return null;
    }

    public function intGetPlayersCount($where = " and is_valid = 1 ")
    {
        $query_sql = "";
        $query_sql = "
            select
                count(1) as count
                from
                playerlist
            where 1 = 1
            {$where}
        ";
        $query = $this->objDB->query($query_sql);


        if($query->num_rows() > 0) {
            $count = $query->row()->count;
        }

        $query->free_result();

        return $count;
    }

    public function boolAddPlayer($data){
        $insert_sql = $this->objDB->insert_string("playerlist", $data);
        $result = $this->objDB->query($insert_sql);
        if($result === true){
            return true;
        }
        else{
            return false;
        }
    }

    public function boolVote($id){
        $update_sql = "update playerlist set vote = vote + 1 where id = ?";
        $binds = array($id);
        $result = $this->objDB->query($update_sql, $binds);
        if($result === true){
            return true;
        }else{
            return false;
        }
    }

    public function arrGetVotedPlayers($ip, $expiration){
        $query_sql = "";
        $query_sql .= "
            select
              pid
              from
              vote_log vl
              where
              ip = '{$ip}'
              and vote_datetime > {$expiration}
        ";

        $query = $this->objDB->query($query_sql);
        return $query->result_array();
    }

    public function boolUpdatePlayerInfo($data){
        $update_data = array();
        if(isset($_POST['name_chi']))
            $update_data['name_chi'] = $_POST['name_chi'];
        if(isset($_POST['name_en']))
            $update_data['name_en'] = $_POST['name_en'];
        if(isset($_POST['prcid']))
            $update_data['prcid'] = $_POST['prcid'];
        if(isset($_POST['age']))
            $update_data['age'] = $_POST['age'];
        if(isset($_POST['tel']))
            $update_data['tel'] = $_POST['tel'];
        if(isset($_POST['motto']))
            $update_data['motto'] = $_POST['motto'];
        if(isset($_POST['is_valid']))
            $update_data['is_valid'] = $_POST['is_valid'];
        if(isset($_POST['link']))
            $update_data['link'] = $_POST['link'];
        if(isset($_POST['address']))
            $update_data['address'] = $_POST['address'];
        if(isset($_POST['sort']))
            $update_data['sort'] = $_POST['sort'];
        $update_sql =  $this->objDB->update_string('playerlist', $update_data, array("id"=>$_POST['id']));
        $result = $this->objDB->query($update_sql);
        if($result === true)
            return true;
        else
            return false;

    }

    public function boolDelete($id){
        $this->objDB->from("playerlist");
        $this->objDB->where("id", $id);
        $this->objDB->delete();

        return ($this->objDB->affected_rows() > 0 );
    }
}