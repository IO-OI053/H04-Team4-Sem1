<?php
require_once .'./models/Specializations.php';

class SpecializationsController {

    private $model;

    public function __construct() {
        $this->model = new Specializations();
    }

    public function handleRequest() {

     
        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $desc = $_POST['description'];

            $this->model->create($name, $desc);
            header("Location: ../views/manage_specializations.php");
            exit();
        }

     
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];

            $this->model->delete($id);
            header("Location: ../views/manage_specializations.php");
            exit();
        }
    }

    public function getAll() {
        return $this->model->getAll();
    }
}
?>
