CREATE TABLE client
(
    client INTEGER PRIMARY KEY,
    username TEXT NOT NULL,
    pw TEXT NOT NULL,
    karma INTEGER NOT NULL
);

CREATE TABLE user_profile
(   
    user_profile INTEGER PRIMARY KEY,
    client INTEGER REFERENCES client,
    personal_description TEXT,
    picture IMAGE -- Might have to replace with text containing path
);

CREATE TABLE channel
(
    channel INTEGER PRIMARY KEY,
    channel_name TEXT NOT NULL,
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
    story INTEGER REFERENCES story,
    content TEXT NOT NULL,
    points INTEGER NOT NULL
);