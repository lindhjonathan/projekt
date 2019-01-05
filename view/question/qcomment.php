<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$question = isset($question) ? $question : null;
$user = isset($user) ? $user : null;

// Create urls for navigation

?><h1>Post a comment</h1>

<p><?= $question->content ?></p>

<?= $form ?>
