<?php

namespace Jodn14\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Jodn14\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "user" => [
                    "type"        => "text",
                ],

                "password" => [
                    "type"        => "password",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
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
        $acronym       = $this->form->value("user");
        $password      = $this->form->value("password");

        // Try to login
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $res = $user->verifyPassword($acronym, $password);

        if (!$res) {
           $this->form->rememberValues();
           $this->form->addOutput("User or password did not match.");
           return false;
        }

        $session = $this->di->get("session");
        $session->set("user_logged_in", true);
        $session->set("active_user", $user->acronym);
        $session->set("active_user_id", $user->id);


        $this->form->addOutput("User " . $user->acronym . " logged in.");
        $this->di->get("response")->redirect("user");
        return true;
    }
}
