<?php

defined('TINYBOARD') or exit;
require_once 'inc/bootstrap.php';
require_once 'inc/functions.php';
class GFilters
{
    public static function findAll()
    {
        // Fetch all filters from the database
        return query("SELECT * FROM `filters`")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        // Fetch a specific filter by ID
        $stmt = prepare("SELECT * FROM `filters` WHERE `id` = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        // Insert a new filter into the database
        $stmt = prepare("INSERT INTO `filters` (`regex`, `action`, `duration`, `message`, `board`) VALUES (:regex, :action, :duration, :message, :board)");
        $stmt->bindValue(':regex', $data['regex']);
        $stmt->bindValue(':action', $data['action']);
        $stmt->bindValue(':duration', $data['duration']);
        $stmt->bindValue(':message', $data['message']);
        $stmt->bindValue(':board', $data['board']);
        $stmt->execute();
    }

    public static function update($id, $data)
    {
        // Update an existing filter
        $stmt = prepare("UPDATE `filters` SET `regex` = :regex, `action` = :action, `duration` = :duration, `message` = :message, `board` = :board WHERE `id` = :id");
        $stmt->bindValue(':regex', $data['regex']);  
        $stmt->bindValue(':action', $data['action']);
        $stmt->bindValue(':duration', $data['duration']);
        $stmt->bindValue(':message', $data['message']);
        $stmt->bindValue(':board', $data['board']);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public static function delete($id)
    {
        // Delete a filter from the database
        $stmt = prepare("DELETE FROM `filters` WHERE `id` = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }    
    public static function check($post)
    {
        // Fetch all filters
        $filters = self::findAll();
        // Check each filter against the sanitized post
        foreach ($filters as $filter) {
            if (preg_match($filter['regex'], $post['body'])) {
                // If a match is found, call the action method
                self::action($filter, $post);
            }
        }
    }
    public static function action($filter, $post) {
        switch ($filter['action'])
        {
            case 'move':
                if ($post['thread'] == null)
                    $post['board'] = $filter['board'];
                break;
            case 'reject':
                error($filter['message']);
                break;
            case 'ban':
				Bans::new_ban($_SERVER['REMOTE_ADDR'], $filter['message'], $filter['duration'], false, -1, $post);
                die();
                break;
                
        }
    }

}