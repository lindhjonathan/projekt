<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\UpdateUserForm;
use Anax\Models\Gravatar;
use Anax\Models\Checker;
use Anax\Question\Question;
use Anax\Question\Answer;
use Anax\User\User;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
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
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $page->add("anax/user/crud/users", [
            "items" => $user->findAll(),
            "activeUser" => $this->checker->loginStatus($this->di),
            "activeUserId" => $this->checker->getUserId($this->di),
        ]);

        return $page->render([
            "title" => "Show All Users",
        ]);
    }



    /**
     * Route handler for login
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("anax/user/crud/login", [
            "content" => $form->getHTML(),
            "userLoggedIn" => $this->checker->loginStatus($this->di),
        ]);

        return $page->render([
            "title" => "A login page",
        ]);
    }



    /**
     * Create a new User
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/user/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }


    /**
     * Update a User
     *
     * @return object as a response object
     */
    public function updateAction(int $id) : object
    {
        if ($this->checker->loginStatus($this->di) == null) {
            $page = $this->di->get("page");

            $page->add("anax/user/crud/landing", [
            ]);

            return $page->render([
                "title" => "Log in/Create User",
            ]);
        }
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di, $id);
        $form->check();

        $page->add("anax/user/crud/update", [
            "form" => $form->getHTML(),
            "id" => $id,
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }


    /**
     * Handler to view profile
     *
     * @return object as a response object
     */
    public function profileAction(int $id = 0) : object
    {
        if ($id == 0) {
            if ($this->checker->loginStatus($this->di) == null) {
                $page = $this->di->get("page");

                $page->add("anax/user/crud/landing", [
                ]);

                return $page->render([
                    "title" => "Log in/Create User",
                ]);
            } else if ($this->checker->loginStatus($this->di) !== null) {
                $id = $this->checker->getUserId($this->di);
            }
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        $profilePicture = $this->gravatar->getGravatar($user->email);

        $questions = new Question();
        $questions->setDb($this->di->get("dbqb"));
        $answers = new Answer();
        $answers->setDb($this->di->get("dbqb"));

        $page->add("anax/user/crud/profile", [
            "info" => $user,
            "profilePicture" => $profilePicture,
            "activeUser" => $this->checker->loginStatus($this->di),
            "activeUserId" => $this->checker->getUserId($this->di),
            "questions" => $questions->findAll(),
            "answers" => $answers->findAll(),
        ]);

        return $page->render([
            "title" => "User Profile",
        ]);
    }


    /**
     * Log out page
     *
     * @return object as a response object
     */
    public function logoutAction() : object
    {
        $session = $this->di->get("session");
        $session->set("userLoggedIn", false);
        $session->delete("activeUser");
        $session->delete("activeUserId");
        $page = $this->di->get("page");

        $page->add("anax/user/crud/logout", [
        ]);

        return $page->render([
            "title" => "Log in/Create User",
        ]);
    }

    /**
     * Landing page for unidentified users
     *
     * @return object as a response object
     */
    public function landingAction() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/user/crud/landing", [
        ]);

        return $page->render([
            "title" => "Log in/Create User",
        ]);
    }
}
