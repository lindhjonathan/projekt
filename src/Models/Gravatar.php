<?php

namespace Jodn14\Models;

/**
 * Model for getting gravatar profile picture
 */
class Gravatar
{

    /**
     * calls gravatar with email
     *
     * @param string email
     * @return string
     */
    public function getGravatar($email) : string
    {
        $url = "https://www.gravatar.com/avatar/";
        $default = "https://novare.se/wp-content/uploads/2017/04/blank-profile-picture-973460_960_720.png";
        $size = 40;

        $gravUrl = $url . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;

        return $gravUrl;
    }
}
