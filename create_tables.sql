CREATE DATABASE memesapi;
USE memesapi;

CREATE TABLE memes(
    idMeme int PRIMARY KEY auto_increment,
    nombre VARCHAR(300),
    titulo_superior VARCHAR(300),
    titulo_inferior VARCHAR(300),
    url VARCHAR(300)
);


CREATE TABLE tag(
    idTag int PRIMARY KEY auto_increment,
    texto VARCHAR(300) UNIQUE
);

CREATE TABLE meme_tag(
    idMeme int, 
    idTag int, 
    PRIMARY KEY (idMeme,idTag)
    FOREIGN KEY(idTag) REFERENCES tag(idTag),
    FOREIGN KEY(idMeme) REFERENCES memes(idMeme)
);

INSERT INTO meme (idMeme,nombre,titulo_superior,titulo_inferior,url) VALUES (1,'asa','asda','asd','https://s1.eestatic.com/2016/12/16/social/memes-humor-redes_sociales_178744040_23538138_1706x960.jpg');

INSERT INTO tag (idTag,texto) VALUES (1,"Ocio");

INSERT INTO meme_tag (idMeme,idTag) VALUES (1,1);

