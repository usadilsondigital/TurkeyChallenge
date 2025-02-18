<?php
class TurkeyController {
    private $repository;

    public function __construct($repository) {
        $this->repository = $repository;
    }

    public function listTurkeys() {
        return $this->repository->getAllTurkeys();
    }

    public function createTurkey($name, $status, $size, $color, $gender) {
        return $this->repository->addTurkey($name, $status, $size, $color, $gender);
    }

    public function editTurkey($id, $name, $status, $size, $color, $gender) {
        return $this->repository->updateTurkey($id, $name, $status, $size, $color, $gender);
    }

    public function removeTurkey($id) {
        return $this->repository->deleteTurkey($id);
    }
    
    public function getAllTurkeysOrder() {
        return $this->repository->getAllTurkeysOrder();
    }

}

?>