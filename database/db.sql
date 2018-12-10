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
    email TEXT NOT NULL,
    karma INTEGER NOT NULL
);

CREATE TABLE user_profile
(   
    client TEXT REFERENCES client PRIMARY KEY,
    personal_description TEXT,
    picture TEXT -- Might have to replace with text containing path
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

-- INSERT INTO client(username, pw, email, karma) VALUES ('3duardo_S', 1234, '123@feup.pt',500);
-- INSERT INTO client(username, pw, email, karma) VALUES ('Des_locado', 4321, '165@feup.pt',100);
-- INSERT INTO client(username, pw, email, karma) VALUES ('FF7', 5678, '199@feup.pt',212);
INSERT INTO client(username, pw, email, karma) VALUES ('edu', '$2y$12$7w2lRpjB5JBiN.nukd8TueDZoC/tekNtGsaHGVyQ.Gj5ka9RFllKS', 'joao-carlos.alves@hotmail.com', 30);
INSERT INTO client(username, pw, email, karma) VALUES ('joao', '$2y$12$Tz2igae3zaGPp2MZE/f2VuvR.sp1M8c8tAguPwPVsyZ2.xxTRNCIW', 'joao-carlos.alves@hotmail.com', 10);
INSERT INTO user_profile(client, personal_description, picture) VALUES ('edu', 'O Marinheiro', 'https://scontent.flis7-1.fna.fbcdn.net/v/t1.0-1/p160x160/28379613_1425786984197475_7671652175703607841_n.jpg?_nc_cat=103&_nc_ht=scontent.flis7-1.fna&oh=bebf7289651fd1f8a4b077f378b1a47d&oe=5CA6507D');
INSERT INTO user_profile(client, personal_description, picture) VALUES ('joao', 'O Marinheiro', 'https://scontent.flis7-1.fna.fbcdn.net/v/t1.0-9/24993344_1632481790124350_4765604731530085149_n.jpg?_nc_cat=100&_nc_ht=scontent.flis7-1.fna&oh=ee96951c81ee47104586f7da14b5f7d8&oe=5CAF13C9');
-- INSERT INTO user_profile(client, personal_description, picture) VALUES ('FF7', 'O Marinheiro', 'https://scontent.flis7-1.fna.fbcdn.net/v/t1.0-1/p160x160/47252887_2485383431488395_7276177372590637056_n.jpg?_nc_cat=106&_nc_ht=scontent.flis7-1.fna&oh=230ee2703db93c913eca2b893da2f219&oe=5C9E9060');
INSERT INTO channel(channel_name, channel_description) VALUES ('WatchPeopleDie', 'A place for morbid curiosity');
INSERT INTO client_channel(client, channel) VALUES ('joao', 'WatchPeopleDie');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES 
    (1, 'edu', 'Hello World', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'https://i0.wp.com/blog.yen.io/wp-content/uploads/2017/11/hello-world.png?fit=2000%2C1062&ssl=1', 1, 0, '2018-12-02 14:29:30.0000', 'WatchPeopleDie');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES 
    (2, 'joao', 'O Deslocado é mesmo cabaça', NULL, NULL, 1, 0, '2018-12-02 14:45:00.0000', 'WatchPeopleDie');
INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES 
    (1, 'edu', 1, NULL, 'Wrong channel', '2018-12-02 14:30:00.0000', 2);
INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES 
    (2, 'joao', 1, 1, 'True', '2018-12-02 14:31:00.0000', 1);
INSERT INTO likes_story(client, story, points) VALUES ('joao', 1, 1);
INSERT INTO likes_comment(client, comment, points) VALUES ('edu', 1, 1);