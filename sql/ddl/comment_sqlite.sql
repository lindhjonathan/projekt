--
-- Creating a Comment table.
--



--
-- Table Comment
--
DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "user_id" INTEGER NOT NULL,
    "answer_id" INTEGER,
    "question_id" INTEGER,
    "content" TEXT,
    FOREIGN KEY(answer_id) REFERENCES Answer(id),
    FOREIGN KEY(question_id) REFERENCES Question(id)
);
