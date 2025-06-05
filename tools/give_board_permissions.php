<?php

require_once 'inc/bootstrap.php';

$group = 10;
$board = "korn";

$query = prepare('SELECT * FROM ``mods`` WHERE `type` >= :group');
$query->bindValue(':group', $group);
$query->execute() or error(db_error($query));

foreach($query->fetchAll(PDO::FETCH_ASSOC) as $mod) {
        if ($mod['boards'] == '*') {
                continue;
        }

        $boards = explode(',', $mod['boards']);

        // Don't give board managers access
        if (count($boards) < 5) {
                continue;
        }

        $boards[] = $board;

        $query = prepare('UPDATE ``mods`` SET `boards` = :boards WHERE `id` = :id');
        $query->bindValue(':boards', implode(',', $boards));
        $query->bindValue(':id', $mod['id']);
        $query->execute() or error(db_error($query));
}
