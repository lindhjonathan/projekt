<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$answer = isset($answer) ? $answer : null;
$user = isset($user) ? $user : null;

// Create urls for navigation

?><h1>Post a comment</h1>

<p><?= $answer->content ?></p>

<?= $form ?>
