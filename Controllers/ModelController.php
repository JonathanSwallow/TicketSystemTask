<?php
namespace Controllers;

use Controllers\DBController;
use Interfaces\IModelController;

class ModelController implements IModelController{
    protected $db_controller;

    function __construct(DBController $db_controller) {
        $this->db_controller = $db_controller;
    }

    public function List($params) { return ["List not implemented"]; }
    public function show($id) { return ["show not implemented"]; } 
    public function create($data) { return ["create not implemented"]; }
    public function update($id, $params) {  return ["update not implemented"]; }
    public function delete($id) { return ["delete not implemented"]; }
}