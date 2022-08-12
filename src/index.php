<?php

require './../vendor/autoload.php';

// include controller / libs

use Smjlabs\Grid\Table;

$table = new Table;

// testing default using table

// set header labeling
$table = $table->setHeader([
    'Name', 'Username'
]);

// testing default using data
$table = $table->setData([
    [ 'name' => 'User 1', 'username' => 'user1'],
    [ 'name' => 'User 2', 'username' => 'user1'],
    [ 'name' => 'User 3', 'username' => 'user1'],
    [ 'name' => 'User 4', 'username' => 'user1'],
    [ 'name' => 'User 5', 'username' => 'user1'],
    [ 'name' => 'User 6', 'username' => 'user1'],
    [ 'name' => 'User 7', 'username' => 'user1'],
    [ 'name' => 'User 8', 'username' => 'user1'],
    [ 'name' => 'User 9', 'username' => 'user1'],
    [ 'name' => 'User 10', 'username' => 'user1'],
    [ 'name' => 'User 11', 'username' => 'user1'],
    [ 'name' => 'User 12', 'username' => 'user1'],
    [ 'name' => 'User 13', 'username' => 'user1'],
    [ 'name' => 'User 14', 'username' => 'user1'],
    [ 'name' => 'User 15', 'username' => 'user1'],
    [ 'name' => 'User 16', 'username' => 'user1'],
    [ 'name' => 'User 17', 'username' => 'user1'],
    [ 'name' => 'User 18', 'username' => 'user1'],
    [ 'name' => 'User 19', 'username' => 'user1'],
    [ 'name' => 'User 20', 'username' => 'user1'],
    [ 'name' => 'User 21', 'username' => 'user1'],
    [ 'name' => 'User 22', 'username' => 'user1'],
    [ 'name' => 'User 23', 'username' => 'user1'],
    [ 'name' => 'User 24', 'username' => 'user1'],
    [ 'name' => 'User 25', 'username' => 'user1'],
    [ 'name' => 'User 26', 'username' => 'user1'],
    [ 'name' => 'User 27', 'username' => 'user1'],
    [ 'name' => 'User 28', 'username' => 'user1'],
    [ 'name' => 'User 29', 'username' => 'user1'],
    [ 'name' => 'User 30', 'username' => 'user1'],
    [ 'name' => 'User 31', 'username' => 'user1'],
    [ 'name' => 'User 32', 'username' => 'user1'],
    [ 'name' => 'User 33', 'username' => 'user1'],
    [ 'name' => 'User 34', 'username' => 'user1'],
    [ 'name' => 'User 35', 'username' => 'user1'],
    [ 'name' => 'User 36', 'username' => 'user1'],
    [ 'name' => 'User 37', 'username' => 'user1'],
    [ 'name' => 'User 38', 'username' => 'user1'],
    [ 'name' => 'User 39', 'username' => 'user1'],
    [ 'name' => 'User 40', 'username' => 'user1'],
    [ 'name' => 'User 41', 'username' => 'user1'],
    [ 'name' => 'User 42', 'username' => 'user1'],
    [ 'name' => 'User 43', 'username' => 'user1'],
    [ 'name' => 'User 44', 'username' => 'user1'],
    [ 'name' => 'User 45', 'username' => 'user1'],
    [ 'name' => 'User 46', 'username' => 'user1'],
    [ 'name' => 'User 47', 'username' => 'user1'],
    [ 'name' => 'User 48', 'username' => 'user1'],
    [ 'name' => 'User 49', 'username' => 'user1'],
    [ 'name' => 'User 50', 'username' => 'user1'],
    [ 'name' => 'User 51', 'username' => 'user1'],
    [ 'name' => 'User 52', 'username' => 'user1'],
    [ 'name' => 'User 53', 'username' => 'user1'],
    [ 'name' => 'User 54', 'username' => 'user1'],
    [ 'name' => 'User 55', 'username' => 'user1'],
    [ 'name' => 'User 56', 'username' => 'user1'],
    [ 'name' => 'User 57', 'username' => 'user1'],
    [ 'name' => 'User 58', 'username' => 'user1'],
    [ 'name' => 'User 59', 'username' => 'user1'],
    [ 'name' => 'User 60', 'username' => 'user1'],
],[
    'name' => 'Name',
    'username' => 'Username'
]);


// include view 
include './test/index.php';