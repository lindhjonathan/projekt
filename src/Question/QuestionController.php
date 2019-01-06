<?php

namespace Jodn14\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Jodn14\User\HTMLForm\CreateQuestionForm;
use Jodn14\User\HTMLForm\DeleteUserForm;
use Jodn14\Question\HTMLForm\PostQuestionForm;
use Jodn14\Question\HTMLForm\PostAnswerForm;
use Jodn14\Question\HTMLForm\PostAnswerCommentForm;
use Jodn14\Question\HTMLForm\PostQuestionCommentForm;
use Jodn14\Models\Gravatar;
use Jodn14\Models\Checker;
use Jodn14\User\User;
use Jodn14\Question\Comment;
use Jodn14\Question\Answer;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var gravatar Gravatar model for profile picture
     * @var checker  Checks session for active user
     */
    private $gravatar;
    private $checker;


    /**
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->gravatar = new Gravatar();
        $this->checker = new Checker();
    }


    /**
     * Index action route handler.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        $page->add("question/questions", [
            "items" => $question->findAll(),
            "activeUser" => $this->checker->loginStatus($this->di),
        ]);

        return $page->render([
            "title" => "Questions",
        ]);
    }



    /**
     * Post a new question
     *
     * @return object as a response object
     */
    public function postAction() : object
    {
        if ($this->checker->loginStatus($this->di) == null) {
            $page = $this->di->get("page");

            $page->add("user/crud/landing", [
            ]);

            return $page->render([
                "title" => "Log in/Create User",
            ]);
        }
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->findById($session->get("activeUserId"));

        $form = new PostQuestionForm($this->di, $user);
        $form->check();

        $page->add("question/post", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }


    /**
     * Handler to view question
     *
     * @return object as a response object
     */
    public function questionAction(int $id) : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findById($id);

        $asker = new User();
        $asker->setDb($this->di->get("dbqb"));
        $asker->findById($question->userId);

        $users = new User();
        $users->setDb($this->di->get("dbqb"));
        $answers = new Answer();
        $answers->setDb($this->di->get("dbqb"));
        $comments = new Comment();
        $comments->setDb($this->di->get("dbqb"));

        $page->add("question/question", [
            "question" => $question,
            "asker" => $asker,
            "tags" => explode(" ", $question->tags),
            "users" => $users->findAll(),
            "answers" => $answers->findAll(),
            "comments" => $comments->findAll(),
            "gravatar" => $this->gravatar,
        ]);

        return $page->render([
            "title" => "Question view",
        ]);
    }


    /**
     * Post a answer
     *
     * @return object as a response object
     */
    public function answerAction(int $id) : object
    {
        if ($this->checker->loginStatus($this->di) == false) {
            $page = $this->di->get("page");

            $page->add("user/crud/landing", [
            ]);

            return $page->render([
                "title" => "Log in/Create User",
            ]);
        }
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findById($id);

        $form = new PostAnswerForm($this->di, $session->get("activeUserId"), $id);
        $form->check();

        $page->add("question/answer", [
            "form" => $form->getHTML(),
            "question" => $question,
        ]);

        return $page->render([
            "title" => "Post an answer",
        ]);
    }


    /**
     * Post a comment to an answer
     *
     * @return object as a response object
     */
    public function acommentAction(int $id) : object
    {
        $page = $this->di->get("page");

        if ($this->checker->loginStatus($this->di) == null) {
            $page->add("user/crud/landing", [
            ]);

            return $page->render([
                "title" => "Log in/Create User",
            ]);
        }

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->findById($id);

        $form = new PostAnswerCommentForm($this->di, $id);
        $form->check();

        $page->add("question/acomment", [
            "form" => $form->getHTML(),
            "answer" => $answer,
        ]);

        return $page->render([
            "title" => "Post a comment",
        ]);
    }


    /**
     * Post a comment to an answer
     *
     * @return object as a response object
     */
    public function qcommentAction(int $id) : object
    {
        $page = $this->di->get("page");

        if ($this->checker->loginStatus($this->di) == null) {
            $page->add("user/crud/landing", [
            ]);

            return $page->render([
                "title" => "Log in/Create User",
            ]);
        }

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findById($id);

        $form = new PostQuestionCommentForm($this->di, $id);
        $form->check();

        $page->add("question/qcomment", [
            "form" => $form->getHTML(),
            "question" => $question,
        ]);

        return $page->render([
            "title" => "Post a comment",
        ]);
    }
}
