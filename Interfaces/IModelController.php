<?php
namespace Interfaces;

interface IModelController{
    public function List($params);
    public function show($id);
    public function create($data);
    public function update($id, $params);
    public function delete($id);
}