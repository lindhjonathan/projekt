<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$info = isset($info) ? $info : null;
$active_user = isset($active_user) ? $active_user : null;
$profile_picture = isset($profile_picture) ? $profile_picture : null;
// $questions = [];
// $answers = [];
$urlToUpdate = url("user/update/$info->id");
$urlToLogOut = url("user/logout");
?>
<h1>User Profile</h1>

<?php if (!$info) : ?>
    <p>The user you're looking for does not exist.</p>
    <?php
    return;
endif;
?>
<?php if($active_user) : ?>
    <p>
        <a href="<?= $urlToUpdate ?>"><button>Update</button></a>
        <a href="<?= $urlToLogOut ?>"><button>Log out</button></a>
    </p>
<?php endif; ?>

<div class="profile">
    <div class="profile-picture">
        <img src="<?= $profile_picture ?>" alt="User Picture" width="200" height="200">
    </div>
    <div class="stats">
        <p>Questions asked: </p>
        <p>Questions answered: </p>
    </div>
</div>

<table id="table1">
    <tr>
        <th style="width: 30%">Acronym</th>
        <th style="width: 30%">Name</th>
        <th>Email</th>
    </tr>
    <tr>
        <td><?= $info->acronym ?></td>
        <td><?= $info->name ?></td>
        <td><?= $info->email ?></td>
    </tr>
</table>

<!--  Styla i en större div
En ruta för Questions och en för Answers
HTMLkod finns i textdokumentet tills dess att du behöver den-->
