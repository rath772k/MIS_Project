<?php
class Report_model extends CI_Model
{
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getAllRows(){
        $query ="
                SELECT a.*,b.* FROM stu_details_project AS a 
                JOIN
                stu_fee_structure AS b
                ON a.session_year = b.session_year AND a.session = b.session AND a.category = b.category 
                AND b.is_deleted='NO';
                ";
        $rows = $this->db->query($query);
        return $rows->result_array();
    }

    function getRequiredRows($session_year, $session){
        $query ="
                SELECT a.*,b.* FROM stu_details_project AS a 
                JOIN
                stu_fee_structure AS b
                ON a.session_year = b.session_year AND a.session = b.session AND a.category = b.category 
                AND a.session_year='".$session_year
                ."' AND a.session='".$session."' AND b.is_deleted='NO';";

        $rows = $this->db->query($query);
        return $rows->result_array();
    }
}

?>