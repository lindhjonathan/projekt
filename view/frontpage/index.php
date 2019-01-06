<?php

namespace Anax\View;

$questions = isset($questions) ? $questions : null;
$users = isset($users) ? $users : null;
$allTags = [];
$allUsers = [];
$userActive = [];

foreach ($questions as $question) {
    if ($question->tags != null) {
        $tags = explode(" ", $question->tags);
        $allTags = array_merge($allTags, $tags);
    }
    foreach ($users as $user) {
        if ($question->userId == $user->id) {
            array_push($userActive, $user->name);
        }
    }
}
$countedUsers = array_count_values($userActive);
$countedTags = array_count_values($allTags);
?>

<h1>Kaffekompaniet</h1>
<p>Välkommen Kaffekompaniets inofficiella superspektakulära diskussionsforum.</p>

<div class="displayrow">
    <ul class="liststyle" style="width: 25%;">
        <li class="listHeader" style="width: 100%;"><h3>Popular Tags</h3></li>
    <?php foreach ($countedTags as $key => $value) :
        if (substr($key, 0, 1) == "#") {
            $key = substr($key, 1);
        } ?>
        <li class="listCell" style="width: 100%;">
            <a class="nostyle" href="<?= url("tags/tag/$key") ?>"><span><?= $key ?></span></a>
            <div style="float: right;"><?= $value ?></div>
        </li>
    <?php endforeach; ?>
    </ul>

    <ul class="liststyle" style="width: 42%; padding-left: 20px;">
        <li class="listHeader" style="width: 100%;"><h3>Latest Questions</h3></li>
    <?php foreach ($questions as $question) : ?>
        <li class="listCell" style="width: 100%; padding-left: 12px;">
            <a class="nostyle" href="<?= url("question/question/$question->id") ?>"><span><?= $question->content ?></span></a>
        </li>
    <?php endforeach; ?>
    </ul>

    <ul class="liststyle" style="width: 27%; padding-left: 20px;">
        <li class="listHeader" style="width: 100%;"><h3>Active Users</h3></li>
    <?php foreach ($countedUsers as $key => $value) :
        foreach ($users as $user) :
            if ($key == $user->name) {
                $id = $user->id;
            } ?>
            <li class="listCell" style="width: 100%;">
                <a class="nostyle" href="<?= url("user/profile/$id") ?>"><span><?= $key ?></span></a>
                <div style="float: right;"><?= $value ?></div>
            </li>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </ul>
</div>
