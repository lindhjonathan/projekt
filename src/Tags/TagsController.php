<?php

namespace Jodn14\Tags;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Jodn14\Models\Gravatar;
use Jodn14\Models\Checker;
use Jodn14\User\User;
use Jodn14\Question\Question;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagsController implements ContainerInjectableInterface
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

        $page->add("tags/view-all", [
            "questions" => $question->findAll(),
        ]);

        return $page->render([
            "title" => "Show All Users",
        ]);
    }


    /**
     * Handler to view a tag
     *
     * @return object as a response object
     */
    public function tagAction(string $tag) : object
    {
        $page = $this->di->get("page");
        $questions = new Question();
        $questions->setDb($this->di->get("dbqb"));

        $page->add("tags/tag", [
            "questions" => $questions->findAll(),
            "tag" => $tag,
        ]);

        return $page->render([
            "title" => "Tag view",
        ]);
    }
}
