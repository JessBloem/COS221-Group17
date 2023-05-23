CREATE TABLE WineBarrels(
ID int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
Name VARCHAR(128) NOT NULL,
Year DATE NOT NULL,
Description VARCHAR(288) NOT NULL,
Cellaring_Potential DATE NOT NULL,
Brand_Name VARCHAR(128) NOT NULL,
Varietal VARCHAR(128) NOT NULL,
Winery_Name VARCHAR(128) NOT NULL,
Production_Date DATE NOT NULL,
Production_Method VARCHAR(128) NOT NULL,
Wineyard_Name VARCHAR(128) NOT NULL,
PRIMARY KEY (ID),
CONSTRAINT `fk_WineBarrels_Brand`FOREIGN KEY(Brand_Name) REFERENCES Brand(Name) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_WineBarrels_Varietal`FOREIGN KEY(Varietal) REFERENCES Varietal(Varietal_Name) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_WineBarrels_Winery`FOREIGN KEY(Winery_Name) REFERENCES Winery(Name) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Bottle(
    Wine_Barrel_ID INT(11) UNSIGNED NOT NULL,
    Bottle_Size SET("500ml","750ml","1000ml") NOT NULL DEFAULT "750ml",
    Price DECIMAL UNSIGNED NOT NULL DEFAULT 199.99,
    Num_Bottles_Made INT UNSIGNED NOT NULL DEFAULT 0,
    Image_URL VARCHAR(128) NOT NULL DEFAULT "https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg?20200913095930",
    PRIMARY KEY(Wine_Barrel_ID),
    CONSTRAINT `fk_Bottle_WineBarrels` FOREIGN KEY(Wine_Barrel_ID) REFERENCES WineBarrels(ID) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `check_Bottle_Size` CHECK(Bottle_Size IN("500ml","750ml","1000ml")),
    CONSTRAINT `check_Price` CHECK(Price BETWEEN 100.00 AND 400.00).
    CONSTRAINT`check_NumBottles_Made` CHECK(Num_Bottles_Made BETWEEN 0 AND 900000)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Brand(
Name VARCHAR(128) NOT NULL,
Phone_Number VARCHAR(9) NOT NULL UNIQUE,
Email VARCHAR(128) NOT NULL UNIQUE,
Street_Address VARCHAR(128) NOT NULL,
Province SET("Eastern Cape","Free State", "Gauteng","KwaZulu-Natal","Limpopo","Mpumalanga","Northern Cape","North West","Western Cape") NOT NULL,
Postal_Code VARCHAR(4) NOT NULL,
PRIMARY KEY(Name)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Varietal(
Varietal_Name VARCHAR(128) NOT NULL,
Residual_Sugar DECIMAL NOT NULL,
pH DECIMAL NOT NULL,
Alcohol_Percentage DECIMAL NOT NULL,
Quality INT(2) NOT NULL DEFAULT 5,
Category_Name VARCHAR(128) NOT NULL,
PRIMARY KEY(Varietal_Name),
CONSTRAINT `check_Quality` CHECK(Quality BETWEEN 0 AND 10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Winery(
Name VARCHAR(128) NOT NULL,
Region SET("Eastern Cape","Free State", "Gauteng","KwaZulu-Natal","Limpopo","Mpumalanga","Northern Cape","North West","Western Cape") NOT NULL,
Phone_Number VARCHAR(9) NOT NULL UNIQUE,
Email VARCHAR(128) NOT NULL UNIQUE,
Street_Address VARCHAR(128) NOT NULL,
Province SET("Eastern Cape","Free State", "Gauteng","KwaZulu-Natal","Limpopo","Mpumalanga","Northern Cape","North West","Western Cape") NOT NULL,
Postal_Code VARCHAR(4) NOT NULL,
PRIMARY KEY(Name),
CONSTRAINT `check_Province` CHECK(Province IN("Eastern Cape","Free State", "Gauteng","KwaZulu-Natal","Limpopo","Mpumalanga","Northern Cape","North West","Western Cape")),
CONSTRAINT `check_postal_code` CHECK(Postal_Code BETWEEN 0000 AND 9999),
CONSTRAINT `check_Region` CHECK(Region IN("Eastern Cape","Free State", "Gauteng","KwaZulu-Natal","Limpopo","Mpumalanga","Northern Cape","North West","Western Cape"))
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Award(
Wine_Barrel_ID INT(11) DEFAULT NULL,
Award VARCHAR(128) NOT NULL,
Year DATE DEFAULT NULL,
Details VARCHAR(288) NOT NULL,
PRIMARY KEY(Wine_Barrel_ID,Award,Year),
CONSTRAINT `fk_Award_WineBarrels`FOREIGN KEY(Wine_Barrel_ID) REFERENCES WineBarrels(ID) ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Wineyards(
Winery_Name VARCHAR(128) NOT NULL,
Wineyard_Name VARCHAR(128) NOT NULL,
Street_Address VARCHAR(128) NOT NULL,
Province SET("Eastern Cape","Free State", "Gauteng","KwaZulu-Natal","Limpopo","Mpumalanga","Northern Cape","North West","Western Cape") NOT NULL,
Postal_Code VARCHAR(4) NOT NULL,
Area VARCHAR(128) NOT NULL,
Grape_Variety VARCHAR(128) NOT NULL,
PRIMARY KEY(Winery_Name,Wineyard_Name),
CONSTRAINT `fk_Wineyard_Winery`FOREIGN KEY(Winery_Name) REFERENCES Winery(Name) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `check_Province` CHECK(Province IN("Eastern Cape","Free State", "Gauteng","KwaZulu-Natal","Limpopo","Mpumalanga","Northern Cape","North West","Western Cape")),
CONSTRAINT `check_postal_code` CHECK(Postal_Code <= 9999)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE User(
User_ID int(11) AUTO_INCREMENT NOT NULL,
First_Name VARCHAR(128) NOT NULL,
Last_Name VARCHAR(128) NOT NULL,
Phone_Number VARCHAR(9) NOT NULL UNIQUE,
Email VARCHAR(128) NOT NULL UNIQUE,
Street_Address VARCHAR(128) NOT NULL,
Province SET("Eastern Cape","Free State", "Gauteng","KwaZulu-Natal","Limpopo","Mpumalanga","Northern Cape","North West","Western Cape") NOT NULL,
Postal_Code VARCHAR(4) NOT NULL,
User_Type SET("Customer","Manager","Critic"),
Department VARCHAR(128) DEFAULT NULL,
Credentials VARCHAR(128) DEFAULT NULL,
Preferences VARCHAR(128) DEFAULT NULL,
PRIMARY KEY(User_ID),
CONSTRAINT `check_Province` CHECK(Province IN("Eastern Cape","Free State", "Gauteng","KwaZulu-Natal","Limpopo","Mpumalanga","Northern Cape","North West","Western Cape")),
CONSTRAINT `check_postal_code` CHECK(Postal_Code <= 9999),
CONSTRAINT `check_user_type` CHECK(User_Type IN("Customer","Manager","Critic"))
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE  Purchases TABLE(
    User_ID int(11) NOT NULL,
    Item VARCHAR NOT NULL DEFAULT "WINE",
    Date_of_Purchase DATE NOT NULL,
    CONSTRAINT`fk_Purchases_User` FOREIGN KEY(User_ID) REFERENCES User(User_ID) ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE WineryRating(
User_ID int(11)  NOT NULL,
Winery_Name VARCHAR(128) NOT NULL,
Rating int(2) NOT NULL DEFAULT 5,
PRIMARY KEY(User_ID,Winery_Name),
CONSTRAINT `fk_WineryRating_Winery`FOREIGN KEY(Winery_Name) REFERENCES Winery(Name) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_WineyRating_User`FOREIGN KEY(User_ID) REFERENCES User(User_ID) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `check_rating` CHECK(Rating BETWEEN 0 AND 10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE WineyardRating(
User_ID int(11) NOT NULL,
Winery_Name VARCHAR(128) NOT NULL,
Wineyard_Name VARCHAR(128) NOT NULL,
Rating int(2) NOT NULL DEFAULT 5,
PRIMARY KEY(User_ID,Winery_Name),
CONSTRAINT `fk_WineyardRating_User`FOREIGN KEY(User_ID) REFERENCES User(User_ID) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_WineyardRating_Winery`FOREIGN KEY(Winery_Name) REFERENCES Winery(Name) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_WineyardRating_Wineyard`FOREIGN KEY(Wineyard_Name) REFERENCES Wineyards(Wineyard_Name) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `check_rating` CHECK(Rating BETWEEN 0 AND 10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE WineRating(
User_ID int(11) NOT NULL,
WineBarrel_ID int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
Rating int(2) NOT NULL DEFAULT 5,
PRIMARY KEY(User_ID,WineBarrel_ID),
CONSTRAINT `fk_WineRating_User`FOREIGN KEY(User_ID) REFERENCES User(User_ID) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_WineRating_WineBarrles`FOREIGN KEY(WineBarrel_ID) REFERENCES WineBarrels(ID) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `check_rating` CHECK(Rating BETWEEN 0 AND 10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Production(
Winery_Name VARCHAR(128) NOT NULL,
Brand_Name VARCHAR(128) NOT NULL,
PRIMARY KEY(Winery_Name,Brand_Name),
CONSTRAINT `fk_Production_Winery`FOREIGN KEY(Winery_Name) REFERENCES Winery(Name) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_Production_Brand`FOREIGN KEY(Brand_Name) REFERENCES Brand(Name) ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

