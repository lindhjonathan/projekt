--
-- Creating a Question table.
--



--
-- Table Question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userId" INTEGER NOT NULL,
    "content" TEXT,
    "tags" TEXT,
    FOREIGN KEY(userId) REFERENCES User(id)
);
