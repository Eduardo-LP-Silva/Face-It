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
    picture TEXT,
    points INTEGER NOT NULL,
    comment_number INTEGER NOT NULL CHECK(comment_number >= 0),
    post_date TEXT NOT NULL,
    channel TEXT REFERENCES channel
);

CREATE TABLE comment
(
    comment INTEGER PRIMARY KEY AUTOINCREMENT,
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
    WHERE story.story = New.story;

    UPDATE client
    SET karma = karma + New.points
    WHERE username IN 
    (
        SELECT username
        FROM client, story
        WHERE client.username = story.client
        AND story.story = New.story
    );
END;

CREATE TRIGGER update_story_points_on_delete
AFTER DELETE ON likes_story
FOR EACH ROW
BEGIN
    UPDATE story
    SET points = points - Old.points
    where story.story = Old.story;

    UPDATE client
    SET karma = karma - Old.points
    WHERE username IN 
    (
        SELECT username
        FROM client, story
        WHERE client.username = story.client
        AND story.story = Old.story
    );
END;

CREATE TRIGGER update_comment_points_on_insert
AFTER INSERT ON likes_comment
FOR EACH ROW
BEGIN
    UPDATE comment
    SET points = points + New.points
    where comment.comment = New.comment;

    UPDATE client
    SET karma = karma + New.points
    WHERE username IN 
    (
        SELECT username
        FROM client, comment
        WHERE client.username = comment.client
        AND comment.comment = New.comment
    );
END;

CREATE TRIGGER update_comment_points_on_delete
AFTER DELETE ON likes_comment
FOR EACH ROW
BEGIN
    UPDATE comment
    SET points = points - Old.points
    where comment.comment = Old.comment;

    UPDATE client
    SET karma = karma - Old.points
    WHERE username IN 
    (
        SELECT username
        FROM client, comment
        WHERE client.username = comment.client
        AND comment.comment = Old.comment
    );
END;

-- Insert
INSERT INTO client(username, pw, email, karma) VALUES ('edu', 
    '$2y$12$7w2lRpjB5JBiN.nukd8TueDZoC/tekNtGsaHGVyQ.Gj5ka9RFllKS', 'eduardo__lps@hotmail.com', 0);
INSERT INTO client(username, pw, email, karma) VALUES ('joao', 
    '$2y$12$Tz2igae3zaGPp2MZE/f2VuvR.sp1M8c8tAguPwPVsyZ2.xxTRNCIW', 
    'joao-carlos.alves@hotmail.com', 0);

INSERT INTO user_profile(client, personal_description, picture) VALUES ('edu', 'O Marinheiro', 
    'https://scontent.flis7-1.fna.fbcdn.net/v/t1.0-1/p160x160/28379613_1425786984197475_7671652175703607841_n.jpg?_nc_cat=103&_nc_ht=scontent.flis7-1.fna&oh=bebf7289651fd1f8a4b077f378b1a47d&oe=5CA6507D');
INSERT INTO user_profile(client, personal_description, picture) VALUES ('joao', 'O Deslocado', 
    'https://scontent.flis7-1.fna.fbcdn.net/v/t1.0-9/24993344_1632481790124350_4765604731530085149_n.jpg?_nc_cat=100&_nc_ht=scontent.flis7-1.fna&oh=ee96951c81ee47104586f7da14b5f7d8&oe=5CAF13C9');
-- INSERT INTO user_profile(client, personal_description, picture) VALUES ('FF7', 'O Marinheiro', 'https://scontent.flis7-1.fna.fbcdn.net/v/t1.0-1/p160x160/47252887_2485383431488395_7276177372590637056_n.jpg?_nc_cat=106&_nc_ht=scontent.flis7-1.fna&oh=230ee2703db93c913eca2b893da2f219&oe=5C9E9060');

INSERT INTO channel(channel_name, channel_description) VALUES ('WatchPeopleDie', 'A place for morbid curiosity');
INSERT INTO channel(channel_name, channel_description) VALUES ('Pics', 'A place to share photographs and pictures.');
INSERT INTO channel(channel_name, channel_description) VALUES ('Programming', 'Computer Programming');
INSERT INTO channel(channel_name, channel_description) VALUES ('FEUP', 'The Faculdade de Engenharia da Universidade do 
Porto is the engineering faculty of the University of Porto, in Porto, Portugal. With its origins in the 18th century, 
the institution became known as Faculty of Engineering in 1926. It awards degrees from the licentiate to doctorate, 
in several engineering fields.');
INSERT INTO channel(channel_name, channel_description) VALUES ("History", "History is a place for discussions about 
history. Feel free to submit interesting articles, tell us about this cool book you just read, or start a discussion 
about who everyone's favorite figure of minor French nobility is!");
INSERT INTO channel(channel_name, channel_description) VALUES ('Dankmemes', 'A Place to Post the Dankest Memes');
INSERT INTO channel(channel_name, channel_description) VALUES ('100yearsAgo', 'This channel was formed in late 2013 to 
document World War I, day by day as it developed. It covers social, political, military and cultural 
developments in combatant countries and noncombatants alike. Its particular emphasis is on pointing out 
the most striking similarities and differences from the problems humanity faces today.');
INSERT INTO channel(channel_name, channel_description) VALUES ('Android', 'Android news, reviews, tips, and discussions 
about rooting, tutorials, and apps. Generic discussion about phones/tablets is allowed, but technical-support and 
carrier-related issues should be asked in their respective subreddits!');
INSERT INTO channel(channel_name, channel_description) VALUES ('Aviation', 'Anything related to aircraft, airplanes, 
aviation and flying. Helicopters & rotorcraft, airships, balloons, parachutes & skydiving, paragliders, winged suits 
and anything that sustains you in the air is acceptable to post here.');
INSERT INTO channel(channel_name, channel_description) VALUES ('Comics', 'Everything related to print comics 
(comic books, graphic novels, and strips) and web comics. Artists are encouraged to post their own work. News and media 
for adaptations based on comic books are welcome. Read [the subreddit wiki](https://www.reddit.com/r/comics/wiki/index) 
for more information about the subreddit.');
INSERT INTO channel(channel_name, channel_description) VALUES ('Conspiracy', "**The conspiracy channel is a thinking ground. 
Above all else, we respect everyone's opinions and ALL religious beliefs and creeds. We hope to challenge issues which 
have captured the public’s imagination, from JFK and UFOs to 9/11. This is a forum for free thinking, not hate speech. 
Respect other views and opinions, and keep an open mind.** **Our intentions are aimed towards a fairer, more transparent
 world and a better future for everyone.**");
INSERT INTO channel(channel_name, channel_description) VALUES ('CrazyIdeas', 'Is your idea too crazy to work? So crazy it 
might work? Perfect.');

INSERT INTO client_channel(client, channel) VALUES ('joao', 'Pics');
INSERT INTO client_channel(client, channel) VALUES ('joao', 'FEUP');
INSERT INTO client_channel(client, channel) VALUES ('joao', 'Programming');
INSERT INTO client_channel(client, channel) VALUES ('joao', 'Dankmemes');
INSERT INTO client_channel(client, channel) VALUES ('joao', 'Comics');
INSERT INTO client_channel(client, channel) VALUES ('joao', 'CrazyIdeas');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'History');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'WatchPeopleDie');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'FEUP');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Programming');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Dankmemes');
INSERT INTO client_channel(client, channel) VALUES ('edu', '100yearsAgo');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Android');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Aviation');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Conspiracy');

INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES 
    (1, 'joao', 'Hello World', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. 
    O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os 
    caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto 
    para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a 
    disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os 
    programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.',
    NULL, 1, 0, '2018-12-02 14:29:30.0000', 'WatchPeopleDie');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES 
    (2, 'edu', 'O Deslocado é mesmo cabaça', NULL, NULL, 1, 0, '2018-12-02 14:45:00.0000', 'WatchPeopleDie');

INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES 
    (NULL,'edu', 1, NULL, 'Wrong channel', '2018-12-02 14:30:00', 2);
INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES 
    (NULL,'joao', 1, 1, 'True', '2018-12-02 14:31:00', 1);
INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES 
    (NULL,'joao', 1, NULL, 'Teste', '2018-12-02 14:31:00.0000', 1);

INSERT INTO likes_story(client, story, points) VALUES ('joao', 1, 1);

INSERT INTO likes_comment(client, comment, points) VALUES ('edu', 1, 1);