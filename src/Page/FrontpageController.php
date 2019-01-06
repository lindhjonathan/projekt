<?php

namespace Jodn14\Page;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Jodn14\User\User;
use Jodn14\Question\Question;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class FrontpageController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

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

        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $page->add("frontpage/index", [
            "questions" => $question->findAll(),
            "users" => $user->findAll(),
        ]);

        return $page->render([
            "title" => "Show All Users",
        ]);
    }
}
