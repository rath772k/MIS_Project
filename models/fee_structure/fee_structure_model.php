<?php
class Fee_structure_model extends CI_Model
{
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getAllRows(){

        $query = $this->db->get_where('stu_fee_structure',array("is_deleted" => "NO"));
        return $query->result_array();
    }

    function getRow($data){
        $query = $this->db->get_where('stu_fee_structure',$data);
        return $query->row_array();
    }

    function insert($data){
        $data['is_deleted'] = "NO";
        return $this->db->replace('stu_fee_structure',$data);
    }

    function update($data){
        return $this->db->replace('stu_fee_structure',$data);
    }

    function delete($data){
        $res = $this->getRow($data);
        $res["is_deleted"] = "YES";
        return $this->update($res);
    }
}

?>