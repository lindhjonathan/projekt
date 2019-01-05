<?php

namespace Jodn14\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
// use Jodn14\User\User;
// use Jodn14\Question\Question;
// use Jodn14\Question\Answer;
use Jodn14\Question\Comment;

use Anax\Database\Exception\Exception;

/**
 * Example of FormModel implementation.
 */
class PostAnswerCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $parent_id)
    {
        parent::__construct($di);
        $id = $this->di->get("session")->get("active_user_id");
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "user_id" => [
                    "type"        => "hidden",
                    "value"       => "$id"
                ],

                "answer_id" => [
                    "type"        => "hidden",
                    "value"       => "$parent_id",
                ],

                "comment" => [
                    "type"        => "textarea",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Submit comment",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $user_id       = $this->form->value("user_id");
        $answer_id     = $this->form->value("answer_id") ?? null;
        $content       = $this->form->value("comment");

        // Save to database
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->user_id = $user_id;
        $comment->question_id = null;
        $comment->answer_id = $answer_id;
        $comment->content = $content;

        try {
            $comment->save();
        } catch (Exception $e) {
            $this->form->rememberValues();
            $this->form->addOutput("Could not post question." . $e);
            return false;
        }


        $this->form->addOutput("Successfully posted comment.");
        $this->di->get("response")->redirect("question");
        return true;
    }
}
