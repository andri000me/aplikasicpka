<?php

class User_model extends CI_Model {
    public function get_user($username,$password)
    {
        return $this->db->query("select * from user where username = ? and password = ? limit 1",[$username,$password])->row_array();
    }

    public function get_all_user()
    {

    	$query = $this->db->query("select * from user");
    	return $query->result_array();
    }

    public function get_user_by_id($id)
    {

    	$query = $this->db->query("select * from user where id = ?", $id);
    	return $query->row_array();
    }

    public function create($data)
    {
    	$this->db->insert('user', $data);
    }

    public function update($id, $data)
    {
    	$this->db->where('id', $id);
    	$this->db->update('user', $data);
    }

    public function delete($id)
    {
    	$this->db->where('id', $id);
    	$this->db->delete('user');
    }

}
