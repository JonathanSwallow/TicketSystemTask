<?php
namespace Controllers;
class TicketController extends ModelController {
    public function List($params) {
        $data = $this->db_controller->list();
        return $data;
    }

    public function show($id) {
        return $this->db_controller->get($id);
    }

    public function create($data) {
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