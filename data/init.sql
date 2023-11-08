DROP TABLE Answer;

DROP TABLE Question;

CREATE TABLE IF NOT EXISTS Question
(
    id INTEGER PRIMARY KEY,
    score INTEGER NOT NULL,
    ground STRING NOT NULL,
    team STRING NOT NULL
);

CREATE TABLE IF NOT EXISTS Answer
(
    id INTEGER PRIMARY KEY,
    question_id INTEGER NOT NULL,
    player STRING NOT NULL,
    season STRING NOT NULL,
    FOREIGN KEY (question_id) REFERENCES Question(id)
);

INSERT INTO Question (score, ground, team)
VALUES
    (1, "Turf Moor", "Manchester City"),
    (1, "Emirates Stadium", "Nottingham Forest"),
    (2, "Craven Cottage", "Liverpool"),
    (2, "Amex Stadium", "Luton Town"),
    (3, "Selhurst Park", "Arsenal"),
    (3, "Old Trafford", "Leeds United");

INSERT INTO Answer (question_id, player, season)
VALUES
    (1, "Erling Haaland", "2023/24"),
    (1, "Rodri", "2023/24"),
    (2, "Taiwo Awoniyi", "2023/24"),
    (3, "Darwin Nunez", "2022/23"),
    (4, "Carlton Morris", "2023/24"),
    (5, "Gabriel Martinelli", "2022/23"),
    (6, "Luke Ayling", "2021/22");
