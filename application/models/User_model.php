<?php

class User_model extends CI_Model
{

    public function data_submit($table , $data){
        $submit = $this->db->insert($table, $data);
        return $submit;
    }

    function data_update($table, $data, $where){
        $update = $this->db->update($table, $data, $where);
        return $update;
    }
    function data_delete($table, $where){
        $update = $this->db->delete($table, $where);
        return $update;
    }

    function data_select($table, $data){
        $select = $this->db->get_where($table, $data)->result();
        return $select;
    }

    function check_exist($table ='', $column='', $value=''){
        $this->db->where($column, $value);
        $select = $this->db->get($table)->row();
        if(empty($select)){
            return false;
        }else{
            return true;
        }
    }

}