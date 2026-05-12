<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model
{

    public $table = 'tbl_user';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    public function fetch_data()
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('id != 1');
        $this->db->order_by('is_aktif', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function check_email($email)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function fetch_data_aktif()
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('id != 1');
        $this->db->where('is_aktif !=', 'n');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    //Get nama user untuk isi data otomatis ke tabel
    function user()
    {
        return $this->db->query("select * from tbl_user");
    }

    // datatables
    function json()
    {

        $this->datatables->select('tbl_user.id,tbl_user.nama_pengguna,tbl_user.username,tbl_user.email, tbl_user.no_hp,tbl_user_level.nama,tbl_user.is_aktif');
        $this->datatables->from('tbl_user');
        if ($this->session->userdata('tbl_user_level_id') != 1) {
            $this->datatables->where('tbl_user.id !=1 ');
        }
        $this->datatables->add_column('is_aktif', '$1', 'rename_string_is_aktif(is_aktif)');
        //add this line for join
        $this->datatables->join('tbl_user_level', 'tbl_user.tbl_user_level_id = tbl_user_level.id');
        // $this->datatables->join('tbl_unit_kerja', 'tbl_user.tbl_unit_kerja_id_unit_kerja = tbl_unit_kerja.id_unit_kerja');
        $this->datatables->add_column('action', anchor(site_url('C_user/update/$1'), '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-success btn-sm')) . " 
                " . anchor(site_url('C_user/reset_password/$1'), '<i class="fa fa-key" aria-hidden="true"></i>', 'class="btn btn-warning btn-sm" onclick="javasciprt: return confirm(\'Yakin reset password ?\')"') . " 
                " . anchor(site_url('C_user/delete/$1'), '<i class="fa fa-trash-o" aria-hidden="true"></i>', 'class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Yakin delete data ?\')"'), 'id');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_user a');
        // $this->db->join('tbl_unit_kerja b', 'a.tbl_unit_kerja_id_unit_kerja=b.id_unit_kerja', 'LEFT');
        $this->db->where('a.id', $id);
        return $this->db->get()->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id', $q);
        $this->db->or_like('username', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('no_hp', $q);
        $this->db->or_like('is_aktif', $q);

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
        $this->db->or_like('username', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('no_hp', $q);
        $this->db->or_like('is_aktif', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    public function get_by_id2($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_user a');
        $this->db->where('a.id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */
