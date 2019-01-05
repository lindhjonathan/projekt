<?php

namespace Jodn14\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Jodn14\User\User;
use Jodn14\Question\Question;
use Jodn14\Question\Answer;

use Anax\Database\Exception\Exception;

/**
 * Example of FormModel implementation.
 */
class PostAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $user, $question)
    {
        parent::__construct($di);
        // $id = $this->di->get("session")->get($active_user_id);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "user_id" => [
                    "type"        => "hidden",
                    "value"       => "$user"
                ],

                "question_id" => [
                    "type"        => "hidden",
                    "value"       => "$question"
                ],

                "answer" => [
                    "type"        => "textarea",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Post answer",
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
        $question_id   = $this->form->value("question_id");
        $content       = $this->form->value("answer");


        // Save to database
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->user_id = $user_id;
        $answer->question_id = $question_id;
        $answer->content = $content;

        try {
            $answer->save();
        } catch (Exception $e) {
            $this->form->rememberValues();
            $this->form->addOutput("Error answering question" . $e);
            return false;
        }


        $this->form->addOutput("Answer successfully posted.");
        return true;
    }
}
