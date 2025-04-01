<?php
namespace Controllers;
class ReplyController extends ModelController {

    public function List($id) {
        $data = $this->db_controller->list();
        $candidates = [];
        foreach ($data as $index => $reply) {
            if (is_array($reply) && isset($reply['ticket_id']) && $reply['ticket_id'] === $id) {
                $candidates[] = $reply;
            }
        }
        return $candidates;
    }

    public function create($data) {
        //Would be better as a model
        $new_reply = [
            "name" => $data["name"],
            "message" => $data["message"],
            "ticket_id" => $data["ticket_id"],
            "id" => uuidv4()
        ];
        return $this->db_controller->add($new_reply);
    }
}