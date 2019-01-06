--
-- Creating a Comment table.
--



--
-- Table Comment
--
DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userId" INTEGER NOT NULL,
    "answerId" INTEGER,
    "questionId" INTEGER,
    "content" TEXT,
    FOREIGN KEY(answerId) REFERENCES Answer(id),
    FOREIGN KEY(questionId) REFERENCES Question(id)
);
