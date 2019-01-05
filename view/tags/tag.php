<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$questions = isset($questions) ? $questions : null;
$tag = isset($tag) ? $tag : null;
$validQuestions = [];

foreach ($questions as $question) {
    if (strpos($question->tags, $tag)) {
        array_push($validQuestions, $question);
    }
}

?>

<h2>Questions related to '#<?= $tag ?>'</h2>
<?php foreach ($validQuestions as $question) : ?>
<div class="questionCell">
    <a class="nostyle" href="<?= url("question/question/{$question->id}"); ?>"><?= $question->content ?></a>
</div>
<?php endforeach; ?>
