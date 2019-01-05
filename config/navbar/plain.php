<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "class" => "my-navbar",

    // Here comes the menu items/structure
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "Kaffekompaniet",
        ],
        [
            "text" => "Questions",
            "url" => "question",
            "title" => "Question forum",
        ],
        [
            "text" => "Tags",
            "url" => "tags",
            "title" => "Tagged questions",
        ],
        [
            "text" => "Users",
            "url" => "user",
            "title" => "Login and overview",
        ],
        [
            "text" => "Profile",
            "url" => "user/profile",
            "title" => "Profile overview",
        ],
        [
            "text" => "About",
            "url" => "about",
            "title" => "Om Kaffekompaniet",
        ],
    ],
];
