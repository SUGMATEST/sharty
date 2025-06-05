<?php
require 'inc/bootstrap.php';

/*
CREATE TABLE IF NOT EXISTS `polls` (
   `poll_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
   `time` INT(11) NOT NULL,
   `creator_ip` VARCHAR(39) CHARACTER SET ascii NOT NULL,
   `expires` INT(11) DEFAULT NULL,
   `hide_results` TINYINT(1) NOT NULL DEFAULT 0,
   `reveal_on_expiration` TINYINT(1) NOT NULL DEFAULT 0,
   `multiple_choice` TINYINT(1) NOT NULL DEFAULT 0,
   PRIMARY KEY (`poll_id`),
   KEY `creator_ip` (`creator_ip`),
   KEY `time` (`time`),
   KEY `expires` (`expires`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `poll_options` (
   `poll_id` INT(11) UNSIGNED NOT NULL,
   `option_id` INT(11) UNSIGNED NOT NULL,
   `option_text` TEXT NOT NULL,
   PRIMARY KEY (`poll_id`, `option_id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `poll_votes` (
   `poll_id` INT(11) UNSIGNED NOT NULL,
   `option_id` INT(11) UNSIGNED NOT NULL,
   `ip` VARCHAR(39) CHARACTER SET ascii NOT NULL,
   `pass_id`INT(11) UNSIGNED DEFAULT NULL,
   `time` INT(11) NOT NULL,
   UNIQUE KEY (`poll_id`, `option_id`, `ip`),
   UNIQUE KEY (`poll_id`, `option_id`, `pass_id`),
   KEY (`poll_id`, `ip`),
   KEY (`poll_id`, `pass_id`),
   KEY `time` (`time`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
*/

global $config, $mod;

check_login(false);

if (isset($_POST['vote'])) {
    $poll_id = $_POST['poll-id'];
    if (!is_numeric($poll_id)) {
        error("Invalid poll ID.");
    }

    $choices = $_POST['choices'];
    if (!is_array($choices)) {
        error("Invalid vote data.");
    }

    vote_poll($poll_id, $choices);

    header("Location: ?id=$poll_id&results", 303);
}

elseif (isset($_POST['reveal'])) {
    $poll_id = $_POST['poll-id'];
    if (!is_numeric($poll_id)) {
        error("Invalid poll ID.");
    }

    $query = prepare("SELECT * FROM `polls` WHERE `poll_id` = :poll_id");
    $query->bindValue(':poll_id', $poll_id);
    $query->execute() or error(db_error($query));

    $poll = $query->fetch(PDO::FETCH_ASSOC);
    if (!$poll) {
        error("Poll not found.");
    }

    if ($_SERVER['REMOTE_ADDR'] != $poll['creator_ip']) {
        error("You didn't create this poll.");
    }

    $query = prepare("UPDATE `polls` SET `hide_results` = 0 WHERE `poll_id` = :poll_id");
    $query->bindValue(':poll_id', $poll_id);
    $query->execute() or error(db_error($query));

    header("Location: ?id=$poll_id&results", 303);
}

elseif (isset($_GET['id'])) {
    $poll_id = $_GET['id'];
    if (!is_numeric($poll_id)) {
        error("Invalid poll ID.");
    }

    $query = prepare("SELECT * FROM `polls` WHERE `poll_id` = :poll_id");
    $query->bindValue(':poll_id', $poll_id);
    $query->execute() or error(db_error($query));

    $poll = $query->fetch(PDO::FETCH_ASSOC);
    if (!$poll) {
        error("Poll not found.");
    }

    $query = prepare("SELECT * FROM `poll_options` WHERE `poll_id` = :poll_id");
    $query->bindValue(':poll_id', $poll_id);
    $query->execute() or error(db_error($query));
    $options = $query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['results'])) {
        $is_creator = $_SERVER['REMOTE_ADDR'] == $poll['creator_ip'];

        if (!$poll['hide_results'] || $is_creator || hasPermission($config['mod']['poll_snooping'])) {
            $total = 0;

            foreach($options as &$option) {
                $query = prepare("SELECT COUNT(*) FROM `poll_votes` WHERE `option_id` = :option_id AND `poll_id` = :poll_id");
                $query->bindValue(':poll_id', $poll_id);
                $query->bindValue(':option_id', $option['option_id']);
                $query->execute() or error(db_error($query));

                $option['votes'] = $query->fetch(PDO::FETCH_NUM)[0];
                $total += $option['votes'];

                if (hasPermission($config['mod']['show_poll_ips'])) {
                    $query = prepare("SELECT `ip` FROM `poll_votes` WHERE `option_id` = :option_id AND `poll_id` = :poll_id");
                    $query->bindValue(':poll_id', $poll_id);
                    $query->bindValue(':option_id', $option['option_id']);
                    $query->execute() or error(db_error($query));

                    $option['ips'] = $query->fetchAll(PDO::FETCH_COLUMN, 0);
                }
            }

            $voters = null;
            if ($poll['multiple_choice']) {
                $query = prepare("SELECT COUNT(DISTINCT `ip`) FROM `poll_votes` WHERE `poll_id` = :poll_id");
                $query->bindValue(':poll_id', $poll_id);
                $query->execute() or error(db_error($query));

                $voters = $query->fetch(PDO::FETCH_NUM)[0];
            }

            $votes = array_column($options, 'votes');
            array_multisort($votes, SORT_DESC, $options);
        }

        echo Element(
            $config['file_poll_result'],
            array(
                'config' => $config,
                'mod' => $mod,
                'poll' => $poll,
                'options' => $options,
                'creator' => $is_creator,
                'total' => $total,
                'voters' => $voters
            )
        );
    }

    else {
        $pass_id = null;
        if (isset($_COOKIE['pass']) && verify_pass($_COOKIE['pass'])) {
            $pass = fetch_pass($_COOKIE['pass']);
            if ($pass) {
                $pass_id = $pass['pass_id'];
            }
        }

        $query = prepare("SELECT COUNT(*) FROM `poll_votes` WHERE (`ip` = :ip OR (`pass_id` = :pass_id AND `pass_id` IS NOT NULL)) AND `poll_id` = :poll_id");
        $query->bindValue(':poll_id', $poll_id);
        $query->bindValue(':ip', $_SERVER['REMOTE_ADDR']);
        $query->bindValue(':pass_id', $pass_id);
        $query->execute() or error(db_error($query));

        $voted = $query->fetch(PDO::FETCH_NUM)[0] != 0;

        echo Element(
            $config['file_poll_vote'],
            array(
                'config' => $config,
                'poll' => $poll,
                'options' => $options,
                'voted' => $voted
            )
        );
    }
}

else {
    error("No poll provided.");
}
