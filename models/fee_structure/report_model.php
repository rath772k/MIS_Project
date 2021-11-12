<?php
class Report_model extends CI_Model
{
    public $numeric;
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->numeric = array(
                "tution_fees","annual_charge","medical_fund",
                "sports_subscription_fee","house_rent",
                "semester_registration_fee","examination_fee",
                "computer_and_internet_charges","electricity_charges",
                "library_fee","training_and_placement_support_fee",
                "miscellaneous_fee");
    }

    function getAllRows(){
        $sum_part = "";
        foreach($this->numeric as $column)
        {
            $sum_part .= "b.".$column."+";
        }
        $sum_part .="a.late_fine 
                    + a.pending_amount 
                    - a.refundable_amount
                    AS total_fee";

        $query ="
                SELECT a.*,"
                .$sum_part
                .",b.* FROM stu_details_project AS a 
                JOIN
                stu_fee_structure AS b
                ON a.session_year = b.session_year AND a.session = b.session AND
                (a.category = b.category OR (b.category = 'PWD' AND a.pwd_status = 'YES')) 
                AND  b.is_deleted='NO';";
        $rows = $this->db->query($query);
        return $rows->result_array();
    }

    function getRequiredRows($session_year, $session){
        
        $rows = $this->db->get_where('stu_details_full', 
            array('session' => $session, 'session_year' => $session_year));
        $rows = $rows->result_array();
        foreach ($rows as $key => $value) {
            if (empty($value)) {
                unset($rows[$key]);
            }
        }
        if(!empty($rows)) return $rows;
        //echo "hi";
        //exit();

        $sum_part = "";
        foreach($this->numeric as $column)
        {
            $sum_part .= "b.".$column."+";
        }
        $sum_part .="a.late_fine 
                    + a.pending_amount 
                    - a.refundable_amount
                    AS total_fee";

        $query ="
                SELECT *,"
                .$sum_part
                ." FROM 
                stu_fee_structure AS b 
                JOIN
                stu_details_project AS a
                ON a.session_year = b.session_year AND a.session = b.session AND
                ((b.category = 'PWD' AND a.pwd_status = 'YES') 
                OR (a.category = b.category AND a.pwd_status = 'NO')) 
                AND a.session_year='".$session_year
                ."' AND a.session='".$session."' AND b.is_deleted='NO';";
        //echo $query;
        //exit();
        $rows = $this->db->query($query);
        $rows = $rows->result_array();
        
        foreach($rows as $row){
            $this->db->replace('stu_details_full',$row);   
        }
        return $rows;
    }

    /*$rows - an array of $row where $row contains all the
     *          columns of 'stu_details_full'
     *          table (same as the ones displayed in frontend) as keys.
     *          
     */
    function saveAllRows($rows){
        foreach($rows as $row){
            $this->db->replace('stu_details_full',$row);   
        }
    }
}

?>
