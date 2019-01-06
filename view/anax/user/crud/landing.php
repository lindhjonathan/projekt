<?php

namespace Anax\View;

/**
 * Landing page for unidentified users.
 */

// Create urls for navigation
$urlToCreate = url("user/create");
$urlToLogin = url("user/login");
?>

<p>To view this page you must be <a href="<?= $urlToLogin ?>">logged in</a></p>
<p>To create a new user <a href="<?= $urlToCreate ?>" style="">here</a></p>
