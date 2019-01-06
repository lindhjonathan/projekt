<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$question = isset($question) ? $question : null;
$tags = isset($tags) ? $tags : [];
$users = isset($users) ? $users : [];
$answers = isset($answers) ? $answers : [];
$comments = isset($comments) ? $comments : [];

// Navigation links
$urlToQuestions = url("question");
$urlToAnswer = url("question/answer/$question->id");
$urlToQuestionComment = url("question/qcomment/$question->id");

// $urlToAnswerComment = url("question/acomment/$answer->id");
?>
<?php if (!$question) : ?>
    <p>The user you're looking for does not exist.</p>
    <?php
    return;
endif;
?>

<h1>Question asked by <?= $asker->acronym ?></h1>

<div class="objectCell">
    <table class="imagefield">
        <td class="tablerow">
            <img style="margin: 4px;" src="<?= $gravatar->getGravatar($asker->email) ?>" alt="User Picture" width="32" height="32">
        </td>
        <td class="tablerow"><p>Asked: </p></td>
    </table>
    <div class="question">
         <p><?= $this->di->get("textfilter")->markdown($question->content); ?></p>
    </div>
    <div class="linkfield">
        <?php foreach ($tags as $tag) :
            if (substr($tag, 0, 1) == "#") {
                $tag = substr($tag, 1);
            } ?>
            <a class="nostyle" href="<?= url("tags/tag/$tag") ?>">#<?= $tag ?></a>
        <?php endforeach; ?>
        <a class="nostyle" href="<?= $urlToAnswer ?>">Answer</a>
        <a class="nostyle" href="<?= $urlToQuestionComment ?>">Comment</a>
    </div>
</div>
<?php foreach ($comments as $comment) : ?>
    <?php if ($question->id == $comment->questionId) : ?>
        <div class="objectCell comment">
        <?php foreach ($users as $user) : ?>
            <?php if ($user->id == $comment->userId) : ?>
                <table class="imagefield">
                    <td class="tablerow">
                        <img style="margin: 4px; min-width: 32px;" src="<?= $gravatar->getGravatar($user->email) ?>" alt="User Picture" width="32" height="32">
                    </td>
                    <td class="tablerow"><p>Commented: </p></td>
            <?php endif ?>
        <?php endforeach ?>
                    <td class="tablerow"><p><?= $this->di->get("textfilter")->markdown($comment->content); ?></p></td>
                </table>
            </div>
    <?php endif; ?>
<?php endforeach; ?>


<?php if ($answers) : ?>
    <?php foreach ($answers as $answer) : ?>
        <?php if ($answer->questionId == $question->id) : ?>
            <div class="objectCell answer">
            <?php foreach ($users as $user) : ?>
                <?php if ($user->id == $answer->userId) : ?>
                    <table class="imagefield">
                        <td class="tablerow">
                            <img style="margin: 4px;" src="<?= $gravatar->getGravatar($user->email) ?>" alt="User Picture" width="32" height="32">
                        </td>
                        <td class="tablerow"><p>Answered: </p></td>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if ($answer->questionId == $question->id) : ?>
                    <td class="tablerow"><p><?= $this->di->get("textfilter")->markdown($answer->content); ?></p></td>
                </table>
            <?php endif; ?>
                <div class="linkfield">
                    <a class="nostyle" href="<?= url("question/acomment/$answer->id") ?>">Comment</a>
                </div>
            </div>

            <?php foreach ($comments as $comment) : ?>
                <?php if ($answer->id == $comment->answerId) : ?>
                    <div class="objectCell comment">
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user->id == $comment->userId) : ?>
                            <table class="imagefield">
                                <td class="tablerow">
                                    <img style="margin: 4px; min-width: 32px;" src="<?= $gravatar->getGravatar($user->email) ?>" alt="User Picture" width="32" height="32">
                                </td>
                                <td class="tablerow"><p>Commented: </p></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                                <td class="tablerow"><p><?= $this->di->get("textfilter")->markdown($comment->content); ?></p></td>
                            </table>
                        </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
