<?php

namespace Jodn14\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class Comment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comment";

    /**
     * Columns in the table.
     *
     */
    public $id;
    public $user_id;
    public $question_id;
    public $answer_id;
    public $content;
}
