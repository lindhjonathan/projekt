<?php

namespace Anax\View;

$questions = isset($questions) ? $questions : null;
$allTags = [];

foreach ($questions as $question) {
    if ($question->tags != null) {
        $tags = explode(" ", $question->tags);
        $allTags = array_merge($allTags, $tags);
    }
}

$countedTags = array_count_values($allTags);
?>

<h2>All Tags</h2>

<ul class="liststyle">
<?php foreach ($countedTags as $key => $value) :
    if (substr($key, 0, 1) == "#") {
        $key = substr($key, 1);
    } ?>
    <li class="listCell">
        <a class="nostyle" href="<?= url("tags/tag/$key") ?>"><span><?= $key ?></span></a>
        <div style="float: right;"><?= $value ?></div>
    </li>
<?php endforeach; ?>
</ul>
