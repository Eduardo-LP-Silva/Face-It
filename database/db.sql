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

    UPDATE story
    SET comment_number = comment_number + 1
    WHERE story.story in 
    (
        SELECT DISTINCT story.story
        FROM comment C1, comment C2, story
        WHERE C1.story = story.story
        AND C2.parent_comment = C1.comment
        AND C2.comment = New.comment
    );
END;

CREATE TRIGGER update_comment_number_on_delete
AFTER DELETE ON comment
FOR EACH ROW
BEGIN
    UPDATE story
    SET comment_number = comment_number - 1
    where story.story = Old.story;

    UPDATE story
    SET comment_number = comment_number -1
    WHERE story.story in 
    (
        SELECT DISTINCT story.story
        FROM comment C1, comment C2, story
        WHERE C1.story = story.story
        AND C2.parent_comment = C1.comment
        AND C2.comment = Old.comment
    );
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
INSERT INTO client_channel(client, channel) VALUES ('edu', 'FEUP');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Programming');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Dankmemes');
INSERT INTO client_channel(client, channel) VALUES ('edu', '100yearsAgo');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Android');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Aviation');
INSERT INTO client_channel(client, channel) VALUES ('edu', 'Conspiracy');

INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES 
    (1, 'edu', '[December 15th, 1918]', 'California. Cecil B. DeMille has finished filming his latest production, 
    a remake of his first film, "The Squaw Man", starring Elliot Dexter and Katherine McDonald.',
    'https://external-preview.redd.it/FAftHGbQ9hl2AIzEFK8QGTOlUEZjW3ibIKn7xEi8mEA.jpg?auto=webp&s=40d841365f7fcccf413319965784b5779a792e11', 
    0, 0, '2018-12-15 14:29:30.0000', '100yearsAgo');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES 
    (2, 'edu', '[December 14th, 1918]', '6-inch howitzer on the bank of the Rhine at Cologne, 14 December 1918.', 
    'https://external-preview.redd.it/pX7JUv_GgcRNMw7Sh_CXNWiAoHUD2hoNVNYwNlqEfak.jpg?auto=webp&s=cd877099c5f159026713af26e4136037e4118a75', 
    0, 0, '2018-12-14 14:45:00.0000', '100yearsAgo');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (3, 'joao', 'How is dark mode still not a big thing?', 'I get that some individual apps have the option, 
    but virtually none of the apps or Android phones I consistently use have this option. I think Reddit and YouTube 
    are the only exceptions here. Mainly using the Pixel, its blinding trying to browse the internet, change any 
    settings on the phone, or use any Google service. I dont want to come across as entitled or anything, Im just 
    genuinely curious how a huge majority of developers dont understand how important this is. Especially for a huge 
    company like Google. The big white screen so awful at night! Why?', NULL, 0, 0, '2018-11-02 21:00:00', 'Android');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (4, 'edu', 'Embraer L500 With a unique paint job', NULL, 'https://i.redd.it/v76m7ykdbh321.jpg', 0, 0, 
    '2018-12-12 12:00:00', 'Aviation');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (5, 'joao', 'Oslo, Norway', NULL, 'https://i.redd.it/vu5iiw6nhh421.jpg', 0, 0, '2018-10-20 22:00:00', 'Pics');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (6, 'joao', 'Fortnite should create a Wikipedia-themed skin with all proceeds donated to Wikipedia', 
    'The only way to save Wikipedia', NULL, 0, 0, '2018-12-05 16:00:00', 'CrazyIdeas');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (7, 'joao', 'Dead roach', NULL, 'https://i.redd.it/k0uv0fpaui321.jpg', 0, 0, '2018-12-04 13:00:00', 'Comics');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (8, 'joao', 'What did Hitler do in his free time?', 'When he wasnt conferring with generals or going to rallies, 
    what did he do? I know he liked to paint, but what else?', NULL, 0, 0, '2018-12-03 15:00:00', 'History');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (9, 'edu', 'cowabaguette it is', NULL, 'https://i.redd.it/e73u37xlng421.jpg', 0, 0, '2018-12-05 15:00:00', 
    'Dankmemes');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (10, 'edu', 'Friendly Reminder....', NULL, 'https://i.redd.it/3ry5ltf119321.jpg', 0, 0, '2018-12-06 16:00:00', 
    'Conspiracy');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (11, 'edu', 'Visual Studio Code (Version 1.30) Released', NULL, NULL, 0, 0, '2018-12-12 16:30:00', 'Programming');
INSERT INTO story(story, client, title, content, picture, points, comment_number, post_date, channel) VALUES
    (12, 'joao', 'LTW > PLOG', 'Só tinha isto a dizer', NULL, 0, 0, '2018-12-16 22:00:00', 'FEUP');


INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES 
    (1,'edu', 8, NULL, 'He studied Architecture, especially opera houses blueprints.', '2018-12-04 14:30:00', 0);
    
INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES
    (2, 'joao', NULL, 1, 'Thank you.', '2018-12-04 16:30:00', 0);

INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) VALUES 
    (3,'edu', 12, NULL, 'Bom dia', '2018-12-17 00:01:00', 0);

INSERT INTO likes_story(client, story, points) VALUES ('joao', 1, 1);
INSERT INTO likes_story(client, story, points) VALUES ('edu', 1, 1);
INSERT INTO likes_story(client, story, points) VALUES ('edu', 2, 1);
INSERT INTO likes_story(client, story, points) VALUES ('edu', 3, 1);
INSERT INTO likes_story(client, story, points) VALUES ('joao', 3, 1);
INSERT INTO likes_story(client, story, points) VALUES ('edu', 4, 1);
INSERT INTO likes_story(client, story, points) VALUES ('edu', 8, 1);
INSERT INTO likes_story(client, story, points) VALUES ('joao', 8, 1);
INSERT INTO likes_story(client, story, points) VALUES ('edu', 9, 1);
INSERT INTO likes_story(client, story, points) VALUES ('joao', 9, 1);
INSERT INTO likes_story(client, story, points) VALUES ('edu', 12, -1);


INSERT INTO likes_comment(client, comment, points) VALUES ('joao', 1, 1);