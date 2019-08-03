<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function format_size($size) {
        $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        if ($size == 0) {
            return('n/a');
        } else {
            return (round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
        }
    }

    function index() {


        $uid = $_POST['uid'];
        $target_path = './application/file_share/tmp/' . $uid . "/";

        if (!file_exists($target_path)) {
            mkdir($target_path);
        }
        $num = $_POST['num'];
        $num_chunks = $_POST['num_chunks'];
        if (!array_key_exists('upload', $_FILES)) {

            echo json_encode(array("resp" => 0, 'pro' => $num, 'total_chunks' => $num_chunks));

            return;
        }

        $file_size = $_POST['size'];
        $tmp_name = $_FILES['upload']['tmp_name'];
        $filename = $_FILES['upload']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $old_name = $filename;
        $target_file = $target_path . $filename;

        if ($_FILES["upload"]["error"]) {
            echo $_FILES["upload"]["error"];
            return false;
        }
        if (move_uploaded_file($tmp_name, $target_path . $num . "." . $ext)) {
            // sleep(1);
            $chunksUploaded = 1;
            if (file_exists($target_file . $num_chunks) == true) {
                for ($i = 1; $i < $num_chunks; $i++) {

                    if (file_exists($target_file . $i) == true) {

                        $chunksUploaded++;
                    }
                }
            }
        }

        echo json_encode(array("resp" => 0, "txt" => $target_file, 'uid' => $uid, 'old_name' => $old_name, 'ext' => $ext, 'clr' => 'green', 'pro' => $num, 'total_chunks' => $num_chunks));
    }

    function combine() {


        //$folder_id = $this->input->post('current_folder');
        $folder_id = $_POST['folder_id'];
        if ($folder_id == '') {
            $folder_id = 0;
        }
        $num_chunks = $_POST['total_chunks'];
        $uid = $_POST['uid'];
        $ext = $_POST['ext'];
        /* if(strtolower($ext)!="mp4"){
          echo json_encode(array("rsp" => 0, "txt" => "Only .JSON DATEI ZUGELASSEN ! ", 'clr' => 'red'));
          return;
          } */
        $old_name = $_POST['old_name'];
        $default_path = './application/file_share/tmp/';
        $destination = "";
        sleep(2);
        for ($i = 1; $i <= $num_chunks; $i++) {
            $source = $default_path . $uid . "/" . $i . "." . $ext;
            $destination = $default_path . $uid . "/" . $old_name;
            $src = fopen($source, 'rb');
            $dest = fopen($destination, 'ab');

            if (stream_copy_to_stream($src, $dest) != FALSE) {
                fclose($src);
                @unlink($source);
            }

            fclose($dest);
        }
        /* $dirs = glob( "./file_share/*.json");
          foreach($dirs as $vs){
          @unlink($vs);
          } */
        mt_srand();
        $file_dir = $default_path . $uid . "/";
        $filename = md5(uniqid(mt_rand())) . "." . $ext;
        sleep(1);
        rename($destination, $file_dir . $filename);

        $filename_n = md5(uniqid(mt_rand())) . "." . $ext;

        $new_path = './application/file_share/' . $filename_n;

        rename($file_dir . $filename, $new_path);

        if (file_exists($new_path)) {
            @unlink($file_dir . $filename);
            @rmdir($file_dir);
        } else {
            return;
        }

        $file_array = array(
            'file_original_name' => $old_name,
            'file_name' => $filename_n,
            'file_ext' => $ext,
            'file_size' => filesize($new_path),
            'file_type' => $this->session->userdata('file_type'),
            'users_id' => 0
        );
        $this->db->insert('file_details', $file_array);
        $file_details_id = $this->db->insert_id();



        if ($this->session->userdata('file_type') !== null && $this->session->userdata('file_type') == 'profile_pic') {
            $this->session->set_userdata('profile_pic_id', $file_details_id);
        }

        if ($this->session->userdata('file_type') !== null && $this->session->userdata('file_type') == 'task_attachment') {
            $set = [
                'file_details_id' => $file_details_id
            ];
            $this->db->insert('task_attachment', $set);
            $set = [
                'users_id' => $this->session->userdata('users_info')['id'],
                'attach_table' => 'tasks',
                'file_details_id' => $file_details_id
            ];
            $this->db->insert('temp_file_upload', $set);
        }

        if ($this->session->userdata('file_type') !== null && $this->session->userdata('file_type') == 'comment_attachment') {
            $set = [
                'file_details_id' => $file_details_id
            ];
            $this->db->insert('discussion_attachment', $set);
            $set = [
                'users_id' => $this->session->userdata('users_info')['id'],
                'attach_table' => 'discussion',
                'file_details_id' => $file_details_id
            ];
            $this->db->insert('temp_file_upload', $set);
        }

        echo json_encode(array("rsp" => 1, "txt" => "File Uploaded Successfully! ", 'clr' => 'green', 'old_name' => $old_name));
    }

    function file_download($id = '') {
        if ($id == '') {
            return;
        }
        $id = intval($id);
        $query = $this->db->get_where('file_details', array('id' => $id));
        if ($query->num_rows() == 1) {
            $row = $query->row_array();

            $name = $row['file_original_name'];
            $path = './application/file_share/' . $row['file_name'];
            // make sure it's a file before doing anything!
            if (is_file($path)) {
                my_download($name, $path);
            }
        } else {
            show_404();
        }
    }

    //end       
}
