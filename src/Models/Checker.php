<?php

namespace Anax\Models;

/**
 * Model for getting gravatar profile picture
 */
class Checker
{

    /**
     * Check session for an active user
     *
     * @param object di
     * @return bool
     */
    public function loginStatus($di) : bool
    {
        $session = $di->get("session");
        if (($session->get("userLoggedIn") == false) || ($session->get("userLoggedIn") == null)) {
            return false;
        }
        return true;
    }

    /**
     * Get user acronym from session if exists
     *
     * @param object di
     * @return string
     */
    public function getUser($di) : string
    {
        $session = $di->get("session");
        if (!$session->has("activeUser")) {
            return "null";
        }
        return $session->get("activeUser");
    }

    /**
     * Get user id from session if exists
     *
     * @param object di
     * @return string
     */
    public function getUserId($di) : string
    {
        $session = $di->get("session");
        if (!$session->has("activeUserId")) {
            return "null";
        }
        return $session->get("activeUserId");
    }
}
