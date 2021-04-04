CREATE TABLE `Countries` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`countryName` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
    UNIQUE INDEX `countryName` (`countryName`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

CREATE TABLE `Cities` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`cityName` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`countryId` INT(11) NOT NULL,
	`added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
    FOREIGN KEY (countryId)
        REFERENCES Countries(id)
        ON DELETE CASCADE,
    UNIQUE INDEX `cityName` (`cityName`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;


CREATE TABLE `Airports` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `airportName` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
    `cityId` INT(11) NOT NULL,
    `countryId` INT(11) NOT NULL,
    `added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (countryId)
        REFERENCES Countries(id)
        ON DELETE CASCADE,
    FOREIGN KEY (cityId)
        REFERENCES Cities(id)
        ON DELETE CASCADE
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;


CREATE TABLE `Routes` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `originAirportId` INT(11) NOT NULL,
    `destinyAirportId` INT(11) NOT NULL,
    `added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (originAirportId)
        REFERENCES Airports(id)
        ON DELETE CASCADE,
    FOREIGN KEY (destinyAirportId)
        REFERENCES Airports(id)
        ON DELETE CASCADE
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

INSERT INTO Countries (id, countryName) VALUES (1, 'Portugal');
INSERT INTO Countries (id, countryName) VALUES (2, 'Ireland');
INSERT INTO Countries (id, countryName) VALUES (3, 'England');
INSERT INTO Countries (id, countryName) VALUES (4, 'France');
INSERT INTO Countries (id, countryName) VALUES (5, 'Spain');
INSERT INTO Countries (id, countryName) VALUES (6, 'Sweden');
INSERT INTO Countries (id, countryName) VALUES (7, 'Germany');

INSERT INTO Cities (cityName, countryId) VALUES ('Oporto', 1);
INSERT INTO Cities (cityName, countryId) VALUES ('Lisbon', 1);
INSERT INTO Cities (cityName, countryId) VALUES ('London', 3);
INSERT INTO Cities (cityName, countryId) VALUES ('Manchester', 3);
INSERT INTO Cities (cityName, countryId) VALUES ('Dublin', 2);
INSERT INTO Cities (cityName, countryId) VALUES ('Belfast', 2);
INSERT INTO Cities (cityName, countryId) VALUES ('Paris', 4);
INSERT INTO Cities (cityName, countryId) VALUES ('Nice', 4);
INSERT INTO Cities (cityName, countryId) VALUES ('Madrid', 5);
INSERT INTO Cities (cityName, countryId) VALUES ('Barcelona', 5);
INSERT INTO Cities (cityName, countryId) VALUES ('Oslo', 6);
INSERT INTO Cities (cityName, countryId) VALUES ('Berlin', 7);
INSERT INTO Cities (cityName, countryId) VALUES ('Frankfurt', 7);


INSERT INTO Airports (airportName, cityId, countryId) VALUES ('a', 1, 1);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('b', 2, 1);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('c', 3, 3);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('d', 4, 3);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('e', 5, 2);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('f', 6, 2);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('g', 7, 4);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('h', 8, 4);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('i', 9, 5);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('j', 11, 6);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('k', 12, 7);
INSERT INTO Airports (airportName, cityId, countryId) VALUES ('l', 13, 7);


SELECT Airports.id INTO @airportA FROM Airports WHERE airportName = 'a';
SELECT Airports.id INTO @airportB FROM Airports WHERE airportName = 'b';
SELECT Airports.id INTO @airportC FROM Airports WHERE airportName = 'c';
SELECT Airports.id INTO @airportD FROM Airports WHERE airportName = 'd';
SELECT Airports.id INTO @airportE FROM Airports WHERE airportName = 'e';
SELECT Airports.id INTO @airportF FROM Airports WHERE airportName = 'f';
SELECT Airports.id INTO @airportG FROM Airports WHERE airportName = 'g';
SELECT Airports.id INTO @airportH FROM Airports WHERE airportName = 'h';
SELECT Airports.id INTO @airportI FROM Airports WHERE airportName = 'i';
SELECT Airports.id INTO @airportJ FROM Airports WHERE airportName = 'j';
SELECT Airports.id INTO @airportK FROM Airports WHERE airportName = 'k';
SELECT Airports.id INTO @airportL FROM Airports WHERE airportName = 'l';

INSERT INTO Routes (originAirportId, destinyAirportId) VALUES
(@airportA, @airportC),
(@airportA, @airportG),
(@airportA, @airportL),
(@airportA, @airportJ),
(@airportB, @airportC),
(@airportB, @airportH),
(@airportB, @airportD),
(@airportB, @airportA),
(@airportB, @airportL),
(@airportB, @airportF),
(@airportC, @airportF),
(@airportC, @airportE),
(@airportC, @airportA),
(@airportC, @airportI),
(@airportC, @airportJ),
(@airportD, @airportB),
(@airportD, @airportC),
(@airportD, @airportF),
(@airportD, @airportH),
(@airportD, @airportJ),
(@airportD, @airportL),
(@airportE, @airportL),
(@airportE, @airportD),
(@airportE, @airportK),
(@airportE, @airportA),
(@airportE, @airportC),
(@airportF, @airportH),
(@airportF, @airportE),
(@airportF, @airportD),
(@airportF, @airportI),
(@airportF, @airportL),
(@airportF, @airportA),
(@airportG, @airportB),
(@airportG, @airportD),
(@airportG, @airportF),
(@airportG, @airportH),
(@airportH, @airportI),
(@airportH, @airportA),
(@airportH, @airportC),
(@airportH, @airportE),
(@airportH, @airportG),
(@airportI, @airportB),
(@airportI, @airportE),
(@airportI, @airportF),
(@airportI, @airportA),
(@airportI, @airportB),
(@airportI, @airportC),
(@airportJ, @airportD),
(@airportJ, @airportE),
(@airportJ, @airportF),
(@airportJ, @airportG),
(@airportJ, @airportH),
(@airportJ, @airportI),
(@airportK, @airportJ),
(@airportK, @airportL),
(@airportK, @airportA),
(@airportK, @airportB),
(@airportK, @airportC),
(@airportL, @airportD),
(@airportL, @airportE),
(@airportL, @airportF),
(@airportL, @airportG),
(@airportL, @airportH),
(@airportL, @airportI),
(@airportL, @airportJ),
(@airportL, @airportK)
;