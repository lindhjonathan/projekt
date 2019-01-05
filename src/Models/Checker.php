<?php

namespace Jodn14\Models;

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
        if($session->get("user_logged_in") == false) {
            return false;
        }
        return true;
    }

    /**
     * Get user acronym from session if exists
     *
     * @param string email
     * @return string
     */
    public function getUser($di) : string
    {
        $session = $di->get("session");
        if(!$session->has("active_user")) {
            return false;
        }
        return $session->get("active_user");
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
        if(!$session->has("active_user_id")) {
            return false;
        }
        return $session->get("active_user_id");
    }
}
