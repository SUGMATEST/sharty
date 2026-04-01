<?php

require_once 'inc/bootstrap.php';

$queryStr = 'SELECT `ip` FROM ``posts_soy`` ORDER BY `id` DESC';

function nvm()
{
	echo "IP already voted";
}

$query = query($queryStr) or error(db_error());
foreach ($query->fetchAll(PDO::FETCH_COLUMN, 0) as $ip) {
	query(sprintf('INSERT INTO ``poll_votes`` VALUES (16991, 0, "%s", NULL, 0)', $ip)) or nvm();
	sleep(120);
}
