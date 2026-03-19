<?php
require_once . './models/Cities.php';

class CitiesController {

    private $model;

    public function __construct() {
        $this->model = new Cities();
    }

    public function handleRequest() {

        if (isset($_POST['add_city'])) {
            $name = $_POST['name'];
            $region = $_POST['region'];

            $this->model->create($name, $region);
            header("Location: ../views/manage_cities.php");
            exit();
        }

        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];

            $this->model->delete($id);
            header("Location: ../views/manage_cities.php");
            exit();
        }
    }

    public function getAll() {
        return $this->model->getAll();
    }
}
?>
