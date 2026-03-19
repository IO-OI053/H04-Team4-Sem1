<?php
require_once . './models/Doctors.php';

class DoctorsController {

    private $model;

    public function __construct() {
        $this->model = new Doctors();
    }

    public function handleRequest() {


        if (isset($_POST['add'])) {

            $username = $_POST['username'];
            $email    = $_POST['email'];
            $password = $_POST['password'];
            $fullname = $_POST['fullname'];
            $phone    = $_POST['phone'];

            $this->model->create($username, $email, $password, $fullname, $phone);

            header("Location: ./views/admin/manage_doctors.php");
            exit();
        }


        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];

            $this->model->delete($id);

            header("Location: ./views/admin/manage_doctors.php");
            exit();
        }
    }

    public function getAll() {
        return $this->model->getAll();
    }
}
?>
