<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Mahasiswa extends REST_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $mahasiswa = $this->mahasiswa->getMahasiswa();
        } else {
            $mahasiswa = $this->mahasiswa->getMahasiswa($id);
        }

        if ($mahasiswa) {
            $this->response([
                'status' => TRUE,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'data' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) {
            $this->response([
                'status' => FALSE,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->mahasiswa->deleteMahasiswa($id) > 0) {
                //ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id,
                    'message' => 'deleted.'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                //id not found
                $this->response([
                    'status' => FALSE,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
