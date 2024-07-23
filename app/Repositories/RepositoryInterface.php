<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function index(?array $params = array());
    public function show(mixed $id);
    public function store(array $modelData);
    public function update(mixed $id, array $modelData);
    public function destroy(mixed $id);
}
