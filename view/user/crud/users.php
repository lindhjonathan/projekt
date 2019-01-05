<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
$active_user = isset($active_user) ? $active_user : null;
$active_user_id = isset($active_user_id) ? $active_user_id : null;


// Create urls for navigation
$urlToCreate = url("user/create");
$urlToLogin = url("user/login");
$urlToProfile = url("user/profile/$active_user_id");

?><h1>Users</h1>

<?php if (!$items) : ?>
    <p>There are no users currently registered to the website :(.</p>
    <p>
        <a href="<?= $urlToCreate ?>"><button>Create new User</button></a>
        <a href="<?= $urlToLogin ?>"><button>Log in</button></a>
    </p>

    <?php
    return;
endif;
?>

<?php if ($active_user == true) : ?>
    <a href="<?= $urlToProfile ?>"><button>Your Profile</button></a>
<?php else : ?>
    <p>
        <a href="<?= $urlToLogin ?>"><button>Log in</button></a>
    </p>
<?php endif; ?>
<table id="table1">
    <tr>
        <th style="width: 50%">Acronym</th>
        <th style="width: 50%">Email</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td>
            <a href="<?= url("user/profile/{$item->id}"); ?>"><?= $item->name ?></a>
        </td>
        <td><?= $item->email ?></td>
    </tr>
    <?php endforeach; ?>
</table>
