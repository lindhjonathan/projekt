--
-- Creating a Answer table.
--



--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userId" INTEGER NOT NULL,
    "questionId" INTEGER NOT NULL,
    "content" TEXT,
    FOREIGN KEY(userId) REFERENCES User(id),
    FOREIGN KEY(questionId) REFERENCES Question(id)
);
