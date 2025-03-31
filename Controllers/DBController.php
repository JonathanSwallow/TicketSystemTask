<?php
namespace Controllers;

class DBController {
    private $name; 
    private $path;
    private $db;
    private $db_root = __DIR__ . "/../DB/";

    public function __construct(string $name){
        $name = strtolower($name);
        $this->name = $name;
        $this->path = $this->db_root . $name . ".json";
        $this->read();
    }

    public function list() {
        return $this->db();
    }

    public function get($id) {
        $found = null;
        foreach ($this->db() as $index => $ticket) {
            if (is_array($ticket) && isset($ticket['id']) && $ticket['id'] === $id) {
                $found = $ticket;
            }
        }
        return $found;
    }

    public function update($id, $data) {
        foreach ($this->db() as $index => $ticket) {
            if (is_array($ticket) && isset($ticket['id']) && $ticket['id'] === $id) {
                $this->db["{$this->name}s"][$index] = $data;
                $this->write();
                break;
            }
        }
    }

    public function add($data) {
        $this->db()[] = $data;
        $this->write();
        return $data;
    }

    public function remove($id) {
        //Imagine a world where we'd keyed it properly
        foreach ($this->db() as $index => $ticket) {
            if (is_array($ticket) && isset($ticket['id']) && $ticket['id'] === $id) {
                unset($this->db["{$this->name}s"][$index]);
                $this->db["{$this->name}s"] = array_values($this->db["{$this->name}s"]);
                $this->write();
                break;
            }
        }
    }

    //Just makes it abit easier to interactive with instead of having to always get the first layer.
    private function &db() { 
        return $this->db["{$this->name}s"];
    }

    private function write() {
        file_put_contents($this->path, json_encode($this->db));
    }
    private function read() {
        if (!file_exists($this->path)){
            file_put_contents($this->path, json_encode(["{$this->name}s" => []]));
        }
        $this->db = json_decode(file_get_contents($this->path), true);
    }
}