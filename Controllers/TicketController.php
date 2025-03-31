<?php
namespace Controllers;

class TicketController {
    private $db_controller;

    function __construct() {
        $this->db_controller = new DBController("ticket");
    }
    public function List($params) {
        //we can use $params filter in here
        $data = $this->db_controller->list();
        return $data;
    }

    public function show($id) {
        return $this->db_controller->get($id);
    }

    public function create($data) {
        //Would be better as a model
        $new_ticket = [
            "title" => $data["title"],
            "description" => $data["description"],
            "department" => $data["department"],
            "created_at" => date("Y-m-d h:i:sa"),
            "status" => "Open",
            "id" => uuidv4()
        ];
        $this->db_controller->add($new_ticket);
    }

    //Would be sick if we had some fillable shit to validate stuff.
    //ran out of time to get some model going.
    public function update($id, $params) {
        $ticket = $this->show($id);
        $ticket['description'] = $params['description'] ?? "";
        $ticket['department'] = $params['department'] ?? "";
        $ticket['status'] = $params['status'] ?? "";
        $this->db_controller->update($id, $ticket);
    }
    public function delete($id) {
        $this->db_controller->remove($id);
    }
}