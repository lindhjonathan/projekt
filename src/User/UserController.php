<?php

namespace Jodn14\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Jodn14\User\HTMLForm\UserLoginForm;
use Jodn14\User\HTMLForm\CreateUserForm;
use Jodn14\User\HTMLForm\UpdateUserForm;
use Jodn14\User\HTMLForm\DeleteUserForm;
use Jodn14\Models\Gravatar;
use Jodn14\Models\Checker;
use Jodn14\Question\Question;
use Jodn14\Question\Answer;

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

        $page->add("user/crud/users", [
            "items" => $user->findAll(),
            "active_user" => $this->checker->loginStatus($this->di),
            "active_user_id" => $this->checker->getUserId($this->di),
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

        $page->add("user/crud/login", [
            "content" => $form->getHTML(),
            "user_logged_in" => $this->checker->loginStatus($this->di),
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

        $page->add("user/crud/create", [
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
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di, $id);
        $form->check();

        $page->add("user/crud/update", [
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

                $page->add("user/crud/landing", [
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
        $profile_picture = $this->gravatar->getGravatar($user->email);

        $questions = new Question();
        $questions->setDb($this->di->get("dbqb"));
        $answers = new Answer();
        $answers->setDb($this->di->get("dbqb"));

        $page->add("user/crud/profile", [
            "info" => $user,
            "profile_picture" => $profile_picture,
            "active_user" => $this->checker->loginStatus($this->di),
            "active_user_id" => $this->checker->getUserId($this->di),
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
        $session->set("user_logged_in", false);
        $session->delete("active_user");
        $session->delete("active_user_id");
        $page = $this->di->get("page");

        $page->add("user/crud/logout", [
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

        $page->add("user/crud/landing", [
        ]);

        return $page->render([
            "title" => "Log in/Create User",
        ]);
    }
}
