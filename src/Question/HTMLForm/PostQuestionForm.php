<?php

namespace Jodn14\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Jodn14\User\User;
use Jodn14\Question\Question;


use Anax\Database\Exception\Exception;

/**
 * Example of FormModel implementation.
 */
class PostQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $user)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "user_id" => [
                    "type"        => "hidden",
                    "value"       => $user->id,
                ],

                "question" => [
                    "type"        => "textarea",
                    "placeholder" => "Question",
                ],

                "tags" => [
                    "type"        => "text",
                    "placeholder" => "#Tags",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Post question",
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
        $user_id   = $this->form->value("user_id");
        $content   = $this->form->value("question");
        $tags      = $this->form->value("tags");

        // Save to database
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->user_id = $user_id;
        $question->content = $content;
        $question->tags = $tags;

        try {
            $question->save();
        } catch (Exception $e) {
            $this->form->rememberValues();
            $this->form->addOutput("Acronym already exists.");
            return false;
        }

        $this->form->addOutput("Question successfully posted.");
        return true;
    }
}
