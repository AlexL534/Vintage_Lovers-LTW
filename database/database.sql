PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS USERS;
DROP TABLE IF EXISTS CATEGORY;
DROP TABLE IF EXISTS CONDITION;
DROP TABLE IF EXISTS BRAND;
DROP TABLE IF EXISTS COLOR;
DROP TABLE IF EXISTS SIZE;
DROP TABLE IF EXISTS PRODUCTS;
DROP TABLE IF EXISTS IMAGES;
DROP TABLE IF EXISTS WISHLIST;
DROP TABLE IF EXISTS SHOPPINGCART;
DROP TABLE IF EXISTS IMAGES_OF_PRODUCT;
DROP TABLE IF EXISTS COLORS_OF_PRODUCT;
DROP TABLE IF EXISTS SIZE_OF_PRODUCT;
DROP TABLE IF EXISTS CONDITION_OF_PRODUCT;
DROP TABLE IF EXISTS MESSAGES;

CREATE TABLE USERS(
    id INTEGER PRIMARY KEY NOT NULL ,
    username TEXT NOT NULL,
    name TEXT,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    is_admin INTEGER NOT NULL
);

CREATE TABLE CATEGORY(
    categoryID INTEGER PRIMARY KEY NOT NULL ,
    name TEXT,
    description TEXT
);

CREATE TABLE CONDITION(
    conditionID INTEGER PRIMARY KEY NOT NULL ,
    name TEXT,
    description TEXT
);

CREATE TABLE BRAND(
    brandID INTEGER PRIMARY KEY NOT NULL ,
    name TEXT
);

CREATE TABLE COLOR(
    colorID INTEGER PRIMARY KEY NOT NULL ,
    name TEXT
);

CREATE TABLE SIZE(
    sizeID INTEGER PRIMARY KEY NOT NULL ,
    name TEXT
);

CREATE TABLE PRODUCTS(
    id INTEGER PRIMARY KEY NOT NULL ,
    price INTEGER NOT NULL CHECK (price >0),
    quantity INTEGER CHECK (quantity >=0),
    name TEXT,
    description TEXT,
    owner INTEGER NOT NULL,
    category INTEGER NOT NULL,
    brand INTEGER NOT NULL,
    FOREIGN KEY (owner) references USERS(id),
    FOREIGN KEY (category) references CATEGORY(categoryID),
    FOREIGN KEY (brand) references BRAND(brandID)

);

CREATE TABLE IMAGES(
    imageID INTEGER PRIMARY KEY NOT NULL ,
    path TEXT
);

CREATE TABLE WISHLIST(
    userID INTEGER NOT NULL,
    productID INTEGER NOT NULL,
    PRIMARY KEY (userID,productID),
    FOREIGN KEY (userID) references USERS(id),
    FOREIGN KEY (productID) references PRODUCTS(id)
);

CREATE TABLE SHOPPINGCART(
    userID INTEGER NOT NULL,
    productID INTEGER NOT NULL,
    PRIMARY KEY (userID,productID),
    FOREIGN KEY (userID) references USERS(id),
    FOREIGN KEY (productID) references PRODUCTS(id)
);

CREATE TABLE IMAGES_OF_PRODUCT(
    imageID INTEGER NOT NULL,
    productID INTEGER NOT NULL,
    PRIMARY KEY (imageID,productID),
    FOREIGN KEY (imageID) references IMAGES(imageID),
    FOREIGN KEY (productID) references PRODUCTS(id)
);

CREATE TABLE COLORS_OF_PRODUCT(
    colorID INTEGER NOT NULL,
    productID INTEGER NOT NULL,
    PRIMARY KEY (colorID,productID),
    FOREIGN KEY (colorID) references COLOR(colorID),
    FOREIGN KEY (productID) references PRODUCTS(id)
);

CREATE TABLE SIZE_OF_PRODUCT(
    sizeID INTEGER NOT NULL,
    productID INTEGER NOT NULL,
    PRIMARY KEY (sizeID,productID),
    FOREIGN KEY (sizeID) references SIZE(sizeID),
    FOREIGN KEY (productID) references PRODUCTS(id)
);

CREATE TABLE CONDITION_OF_PRODUCT(
    conditionID INTEGER NOT NULL,
    productID INTEGER NOT NULL,
    PRIMARY KEY (conditionID,productID),
    FOREIGN KEY (conditionID) references CONDITION(conditionID),
    FOREIGN KEY (productID) references PRODUCTS(id)
);

CREATE TABLE MESSAGES(
    senderID INTEGER NOT NULL,
    receiverID INTEGER NOT NULL,
    productID INTEGER NOT NULL,
    messageText TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (senderID,receiverID,productID),
    FOREIGN KEY (senderID) references USERS(id),
    FOREIGN KEY (receiverID) references USERS(id),
    FOREIGN KEY (productID) references PRODUCTS(id)
);

