--
-- Creating a Answer table.
--



--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "user_id" INTEGER NOT NULL,
    "question_id" INTEGER NOT NULL,
    "content" TEXT,
    FOREIGN KEY(user_id) REFERENCES User(id),
    FOREIGN KEY(question_id) REFERENCES Question(id)
);
