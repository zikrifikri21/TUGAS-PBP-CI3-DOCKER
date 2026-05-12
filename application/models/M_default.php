<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_default extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  public function fetch_data($options)
  {
    $select = false;
    $table = false;
    $join = false;
    $order = false;
    $limit = false;
    $offset = false;
    $where = false;
    $or_where = false;
    $single = false;
    $where_not_in = false;
    $like = false;
    $group = false;

    extract($options);

    if ($select != false)
      $this->db->select($select);

    if ($table != false)
      $this->db->from($table);

    if (!empty($join)) {
      foreach ($join as $key => $value) {
        if (is_array($value)) {
          if (count($value) == 3) {
            $this->db->join($value[0], $value[1], $value[2], 'LEFT');
          } else {
            foreach ($value as $key1 => $value1) {
              $this->db->join($key1, $value1, 'LEFT');
            }
          }
        } else {
          $this->db->join($key, $value, 'LEFT');
        }
      }
    }

    if ($where != false)
      $this->db->where($where);

    if ($order != false) {
      foreach ($order as $key => $value) {
        if (is_array($value)) {
          foreach ($order as $orderby => $orderval) {
            $this->db->order_by($orderby, $orderval);
          }
        } else {
          $this->db->order_by($key, $value);
        }
      }
    }

    if ($group != false)
      $this->db->group_by($group);

    $query = $this->db->get();
    if ($single) {
      return $query->row();
    }

    return $query->result();
  }

  public function input($table_name, $data)
  {
    $this->db->insert($table_name, $data);
    $insert_id = $this->db->insert_id();
    return  $insert_id;
  }

  public function edit($table_name, $data, $where)
  {
    $this->db->update($table_name, $data, $where);
  }

  public function delete($table_name, $data)
  {
    $this->db->delete($table_name, $data);
  }
}
