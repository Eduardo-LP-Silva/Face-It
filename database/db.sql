.mode columns
.headers on
.nullvalue NULL

PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS user_profile;
DROP TABLE IF EXISTS channel;
DROP TABLE IF EXISTS client_channel;
DROP TABLE IF EXISTS story;
DROP TABLE IF EXISTS comment_story;
DROP TABLE IF EXISTS comment_reply;
DROP TABLE IF EXISTS likes_story;
DROP TABLE IF EXISTS likes_comment;

CREATE TABLE client
(
    username TEXT PRIMARY KEY,
    pw TEXT NOT NULL,
    karma INTEGER NOT NULL
);

CREATE TABLE user_profile
(   
    client TEXT REFERENCES client PRIMARY KEY,
    personal_description TEXT,
    picture IMAGE -- Might have to replace with text containing path
);

CREATE TABLE channel
(
    channel_name TEXT PRIMARY KEY,
    channel_description TEXT
);

CREATE TABLE client_channel
(
    client TEXT REFERENCES client,
    channel TEXT REFERENCES channel,
    PRIMARY KEY (client, channel)
);

CREATE TABLE story
(
    story INTEGER PRIMARY KEY,
    client TEXT REFERENCES client,
    title TEXT NOT NULL,
    content TEXT,
    picture IMAGE, -- Might have to replace with text containing path
    points INTEGER NOT NULL,
    comment_number INTEGER NOT NULL CHECK(comment_number >= 0),
    post_date TEXT NOT NULL,
    channel TEXT REFERENCES channel
);

CREATE TABLE comment
(
    comment INTEGER PRIMARY KEY,
    client TEXT REFERENCES client,
    story INTEGER REFERENCES story,
    parent_comment INTEGER REFERENCES comment,
    content TEXT NOT NULL,
    comment_date TEXT NOT NULL,
    points INTEGER NOT NULL
);

CREATE TABLE likes_story
(
    client TEXT REFERENCES client,
    story INTEGER REFERENCES story,
    points INTEGER CHECK(points = 1 or points = -1),
    PRIMARY KEY (client, story)
);

CREATE TABLE likes_comment
(
    client TEXT REFERENCES client,
    comment INTEGER REFERENCES comment,
    points INTEGER CHECK(points = 1 or points = -1),
    PRIMARY KEY (client, comment)
);

-- Triggers

DROP TRIGGER IF EXISTS update_comment_number_on_insert;
DROP TRIGGER IF EXISTS update_comment_number_on_delete;
DROP TRIGGER IF EXISTS update_story_points_on_insert;
DROP TRIGGER IF EXISTS update_story_points_on_delete;
DROP TRIGGER IF EXISTS update_comment_points_on_insert;
DROP TRIGGER IF EXISTS update_comment_points_on_delete;

CREATE TRIGGER update_comment_number_on_insert
AFTER INSERT ON comment
FOR EACH ROW
BEGIN
    UPDATE story
    SET comment_number = comment_number + 1
    where story.story = New.story;
END;

CREATE TRIGGER update_comment_number_on_delete
AFTER DELETE ON comment
FOR EACH ROW
BEGIN
    UPDATE story
    SET comment_number = comment_number - 1
    where story.story = Old.story;
END;

CREATE TRIGGER update_story_points_on_insert
AFTER INSERT ON likes_story
FOR EACH ROW
BEGIN
    UPDATE story
    SET points = points + New.points
    where story.story = New.story;
END;

CREATE TRIGGER update_story_points_on_delete
AFTER DELETE ON likes_story
FOR EACH ROW
BEGIN
    UPDATE story
    SET points = points - Old.points
    where story.story = Old.story;
END;

CREATE TRIGGER update_comment_points_on_insert
AFTER INSERT ON likes_comment
FOR EACH ROW
BEGIN
    UPDATE comment
    SET points = points + New.points
    where comment.comment = New.comment;
END;

CREATE TRIGGER update_comment_points_on_delete
AFTER DELETE ON likes_comment
FOR EACH ROW
BEGIN
    UPDATE comment
    SET points = points - Old.points
    where comment.comment = Old.comment;
END;

-- Insert

INSERT INTO client(username, pw, karma) VALUES ('3duardo_S', 1234, 500);
INSERT INTO client(username, pw, karma) VALUES ('Des_locado', 4321, 100);
INSERT INTO client(username, pw, karma) VALUES ('FF7', 5678, 212);
INSERT INTO user_profile(client, personal_description, picture) VALUES ('3duardo_S', 'O Marinheiro', NULL);
INSERT INTO channel(channel_name, channel_description) VALUES ('WatchPeopleDie', 'A place for morbid curiosity');
INSERT INTO client_channel(client, channel) VALUES ('Des_locado', 'WatchPeopleDie');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES 
    (1, '3duardo_S', 'Hello World', NULL, NULL, 1, 0, '2018-12-02 14:29:30.0000', 'WatchPeopleDie');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES 
    (2, 'FF7', 'O Deslocado é mesmo cabaça', NULL, NULL, 1, 0, '2018-12-02 14:45:00.0000', 'WatchPeopleDie');
INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES 
    (1, '3duardo_S', 1, NULL, 'Wrong channel', '2018-12-02 14:30:00.0000', 2);
INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES 
    (2, 'FF7', NULL, 1, 'True', '2018-12-02 14:31:00.0000', 1);
INSERT INTO likes_story(client, story, points) VALUES ('Des_locado', 1, 1);
INSERT INTO likes_comment(client, comment, points) VALUES ('3duardo_S', 1, 1);