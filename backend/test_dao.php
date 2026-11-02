<?php
require_once __DIR__ . '/dao/StoneTypeDao.php';
header('Content-Type: text/plain; charset=utf-8');

$dao = new StoneTypeDao();

echo "GET ALL:\n";
print_r($dao->getAll());

$id = $dao->create(['name' => 'Test kamen', 'description' => 'Test', 'image' => null]);
echo "CREATED id=$id\n";

$dao->update($id, ['name' => 'Test kamen izmijenjen']);
echo "UPDATED:\n";
print_r($dao->getById($id));

$dao->delete($id);
echo "DELETED, getById => ";
var_dump($dao->getById($id));