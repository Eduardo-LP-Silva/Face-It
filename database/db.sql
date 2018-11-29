CREATE TABLE client
(
    username TEXT PRIMARY KEY,
    pw TEXT NOT NULL,
    karma INTEGER NOT NULL
);

CREATE TABLE user_profile
(   
    client INTEGER REFERENCES client PRIMARY KEY,
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
    client INTEGER REFERENCES client,
    channel INTEGER REFERENCES channel,
    PRIMARY KEY (client, channel)
);

CREATE TABLE story
(
    story INTEGER PRIMARY KEY,
    client INTEGER REFERENCES client,
    title TEXT NOT NULL,
    content TEXT,
    points INTEGER NOT NULL,
    channel INTEGER REFERENCES channel
);

CREATE TABLE comment
(
    comment INTEGER PRIMARY KEY,
    client INTEGER REFERENCES client,
    story INTEGER REFERENCES story, -- Maybe add reference to comment
    content TEXT NOT NULL,
    points INTEGER NOT NULL
);

INSERT INTO client VALUES ('3duardo_S', 1234, 500);
