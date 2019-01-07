<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

use Anax\Database\Exception\Exception;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "acronym" => [
                    "type"        => "text",
                ],

                "name" => [
                    "type"        => "text",
                ],

                "email" => [
                    "type"        => "email",
                ],

                "password" => [
                    "type"        => "password",
                ],

                "password-again" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create user",
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
        $acronym       = $this->form->value("acronym");
        $name          = $this->form->value("name");
        $email         = $this->form->value("email");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        // Save to database
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->acronym = $acronym;
        $user->name = $name;
        $user->email = $email;
        $user->setPassword($password);

        try {
            $user->save();
        } catch (Exception $e) {
            $this->form->rememberValues();
            $this->form->addOutput("Acronym already exists.");
            return false;
        }



        $this->form->addOutput("User was created.");
        return true;
    }
}
