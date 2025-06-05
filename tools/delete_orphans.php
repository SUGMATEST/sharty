<?php
require_once 'inc/bootstrap.php';

$boardList = listBoards(true);
foreach ($boardList as $boardName) {
	openBoard($boardName);

	echo "Deleting orphaned posts from {$boardName}...\n";
	delete_orphaned_posts();

	echo "Deleting orphaned html from {$boardName}...\n";
	delete_orphaned_html();

 	echo "Deleting orphaned files from {$boardName}...\n";
	delete_orphaned_files();
}

echo "Finished!\n";
