--
-- Creating a Question table.
--



--
-- Table Question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "user_id" INTEGER NOT NULL,
    "content" TEXT,
    "tags" TEXT,
    FOREIGN KEY(user_id) REFERENCES User(id)
);
