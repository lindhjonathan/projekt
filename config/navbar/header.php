<?php
/**
 * Supply the basis for the navbar as an array.
 */


return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "Kaffekompaniet",
        ],
        [
            "text" => "Questions",
            "url" => "question",
            "title" => "Frågeforum",
        ],
        [
            "text" => "Tags",
            "url" => "tags",
            "title" => "Taggar och Kategorier",
        ],
        [
            "text" => "Users",
            "url" => "user",
            "title" => "Inlogg och överblick",
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
