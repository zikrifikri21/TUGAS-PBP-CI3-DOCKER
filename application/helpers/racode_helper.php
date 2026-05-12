<?php
function cmb_dinamis($name, $table, $field, $pk, $selected = null, $order = null)
{
    $ci = get_instance();
    $cmb = "<select name='$name' class='custom-select'>";
    if ($order) {
        $ci->db->order_by($field, $order);
    }
    $data = $ci->db->get($table)->result();
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$pk . "'";
        $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
        $cmb .= ">" .  strtoupper($d->$field) . "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function cmb_dinamis_textarea($name, $table, $field, $pk, $selected = null, $order = null)
{
    $ci = get_instance();
    $cmb = "<select name='$name' class='form-control form-control-sm'>";
    if ($order) {
        $ci->db->order_by($field, $order);
    }
    $data = $ci->db->get($table)->result();
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$pk . "'";
        $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
        $cmb .= ">" .  strtoupper($d->$field) . "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function select2_dinamis($name, $table, $field, $placeholder)
{
    $ci = get_instance();
    $select2 = '<select name="' . $name . '" class="form-control js-example-basic-single" multiple="" 
               data-placeholder="' . $placeholder . '" style="width: 100%;" tabindex="-1" aria-hidden="true">';
    $data = $ci->db->get($table)->result();
    foreach ($data as $row) {
        $select2 .= ' <option>' . $row->$field . '</option>';
    }
    $select2 .= '</select>';
    return $select2;
}

function datalist_dinamis($name, $table, $field, $value = null)
{
    $ci = get_instance();
    $string = '<input value="' . $value . '" name="' . $name . '" list="' . $name . '" class="custom-select">
    <datalist id="' . $name . '">';
    $data = $ci->db->get($table)->result();
    foreach ($data as $row) {
        $string .= '<option value="' . $row->$field . '">';
    }
    $string .= '</datalist>';
    return $string;
}

function rename_string_is_aktif($string)
{
    return $string == 'y' ? 'Aktif' : 'Tidak Aktif';
}


function is_login()
{
    $ci = get_instance();
    if (!$ci->session->userdata('id_users')) {
        redirect('auth');
    } else {
        $modul = $ci->uri->segment(1);

        $tbl_user_level_id = $ci->session->userdata('tbl_user_level_id');
        // dapatkan id menu berdasarkan nama controller
        $menu = $ci->db->get_where('tbl_menu', array('url' => $modul))->row_array();
        $id_menu = $menu['id'];
        // chek apakah user ini boleh mengakses modul ini
        $hak_akses = $ci->db->get_where('tbl_hak_akses', array('tbl_menu_id' => $id_menu, 'tbl_user_level_id' => $tbl_user_level_id));
        if ($hak_akses->num_rows() < 1) {
            redirect('blokir');
            exit;
        }
    }
}

function alert($class, $title, $description)
{
    return '<div class="alert ' . $class . ' alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> ' . $title . '</h4>
                ' . $description . '
              </div>';
}

// untuk chek akses level pada modul peberian akses
function checked_akses($id_user_level, $id_menu)
{
    $ci = get_instance();
    $ci->db->where('tbl_user_level_id', $id_user_level);
    $ci->db->where('tbl_menu_id', $id_menu);
    $data = $ci->db->get('tbl_hak_akses');
    if ($data->num_rows() > 0) {
        return "checked='checked'";
    }
}

function checked_aktifitas($atasn, $bawahan)
{
    $ci = get_instance();
    $ci->db->where('jabatan_atasan_langsung', $atasn);
    $ci->db->where('jabatan_pegawai', $bawahan);
    $data = $ci->db->get('tbl_hirarki_jabatan');
    if ($data->num_rows() > 0) {
        return "checked='checked'";
    }
}


function autocomplate_json($table, $field)
{
    $ci = get_instance();
    $ci->db->like($field, $_GET['term']);
    $ci->db->select($field);
    $collections = $ci->db->get($table)->result();
    foreach ($collections as $collection) {
        $return_arr[] = $collection->$field;
    }
    echo json_encode($return_arr);
}

function nominal($angka)
{
    $jd = number_format($angka, 0, ',', '.');
    return $jd;
}
