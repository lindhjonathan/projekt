<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToPost = url("question/post");
$urlToQuestion = url("question");

?>
<h1>Questions</h1>

<?php if (!$items) : ?>
    <p>There are no questions posted on the website :(.</p>

    <p>
        <a href="<?= $urlToPost ?>"><button>Post a new Question</button></a>
    </p>
    <?php
    return;
endif;

foreach ($items as $item) : ?>
<div class="questionCell">
    <a class="nostyle" href="<?= url("question/question/{$item->id}"); ?>"><?= $item->content ?></a>
</div>
<?php endforeach; ?>
<p>
    <a href="<?= $urlToPost ?>"><button style="margin-left: 0;">Post a new Question</button></a>
</p>
