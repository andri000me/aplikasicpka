<?php

function is_logged_in() {
    $ci =& get_instance();
    $ci->load->library('session');

    if ($ci->session->userdata('logged_in')) {
        return true;
    }
    return false;
}

function is_admin() {
    $ci =& get_instance();
    $ci->load->library('session');
    $ci->load->database();
    $id_user = $ci->session->userdata('id_user');
    $query = $ci->db->query("select id_role from user where id = ? limit 1",$id_user);
    if ($query->row()->id_role == 1){
        return true;
    }
    return false;
}