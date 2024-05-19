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
DROP TABLE IF EXISTS SOLD_PRODUCTS;

CREATE TABLE USERS(
    id INTEGER PRIMARY KEY NOT NULL ,
    username TEXT NOT NULL,
    name TEXT,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    is_admin BOOLEAN NOT NULL
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
    price DECIMAL(10, 2) NOT NULL CHECK (price > 0),
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
    id INTEGER PRIMARY KEY NOT NULL,
    senderID INTEGER NOT NULL,
    receiverID INTEGER NOT NULL,
    productID INTEGER NOT NULL,
    messageText TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (senderID) references USERS(id),
    FOREIGN KEY (receiverID) references USERS(id),
    FOREIGN KEY (productID) references PRODUCTS(id)
);

CREATE TABLE SOLD_PRODUCTS(
    sellerID INTEGER NOT NULL,
    buyerID INTEGER NOT NULL,
    productID INTEGER NOT NULL,
    address TEXT,
    sellID INTEGER PRIMARY KEY NOT NULL,
    FOREIGN KEY (sellerID) references USERS(id),
    FOREIGN KEY (buyerID) references USERS(id),
    FOREIGN KEY (productID) references PRODUCTS(id)
);

--==================================== inserts =========================================
INSERT INTO CATEGORY(name, description) VALUES
('Jeans', 'A variety of styles including skinny, straight-leg, bootcut, and high-waisted jeans'),
('Pants', 'This can include trousers, chinos, leggings, and other types of casual or formal pants'),
('Shirts and Blouses', 'A selection of button-downs, flannels, tunics, and dress shirts for all occasions'),
('T-shirts and Tops', ' Casual wear essentials like graphic tees, tank tops, crop tops, and long-sleeve shirts'),
('Outerwear', 'Jackets, coats, blazers, and sweaters suitable for different seasons and styles'),
('Shoes', 'Shoes, sneakers and all related to this');

INSERT INTO CONDITION(name, description) VALUES
('New with Tags', 'Items that are brand new and have never been worn, with original tags still attached'),
('Like New','Clothes that appear new with no signs of wear and tear, but without tags' ),
('Gently Used', 'Items that have been worn but are still in great condition with minimal signs of use'),
('Well-Loved', 'Clothing that has been worn frequently and may show signs of wear such as fading or minor imperfections'),
('Vintage', 'Older items that are not necessarily in perfect condition, but their age adds to their charm and value');

INSERT INTO BRAND(name) VALUES 
('Levis'),
('Nike'),
('Zara'),
('Patagonia'),
('Ralph Lauren');

INSERT INTO COLOR(name) VALUES
('White'),
('Black'),
('Red'),
('Blue'),
('Green');

INSERT INTO SIZE(name) VALUES
('Very Big'),
('Big'),
('Medium'),
('Small'),
('Very Small');

INSERT INTO USERS(username, name, email, password, is_admin) VALUES
('admin', 'admin', 'teste@gmail.com', '$2y$10$evV7NSpzNaKZBSq8nHvlv.e9lsiSYkJaXOKW17fBAUh/IgQwJ4BhG', 1),
('John Doe', 'John', 'john@gmail.com', '$2y$10$evV7NSpzNaKZBSq8nHvlv.e9lsiSYkJaXOKW17fBAUh/IgQwJ4BhG', 0),
('Alice Doe', 'Alice', 'alice@outlook.com', '$2y$10$evV7NSpzNaKZBSq8nHvlv.e9lsiSYkJaXOKW17fBAUh/IgQwJ4BhG', 0),
('Lucas', 'Lucas', 'lucas@gmail.com', '$2y$10$evV7NSpzNaKZBSq8nHvlv.e9lsiSYkJaXOKW17fBAUh/IgQwJ4BhG', 0),
('Pedro', 'Pedro', 'pedro@gmail.com', '$2y$10$evV7NSpzNaKZBSq8nHvlv.e9lsiSYkJaXOKW17fBAUh/IgQwJ4BhG', 0),
('Vasco', 'Vasco', 'vasco@gmail.com', '$2y$10$evV7NSpzNaKZBSq8nHvlv.e9lsiSYkJaXOKW17fBAUh/IgQwJ4BhG', 0);


INSERT INTO PRODUCTS (price, quantity, name, description, owner, category, brand)
VALUES
    (79.99, 5, 'Denim Jeans', 'Slim-fit jeans', 2, 1, 1),
    (29.99, 20, 'Canvas Sneakers', 'Casual shoes', 3, 6, 2),
    (149.99, 3, 'Leather Jacket', 'Stylish biker jacket', 4, 5, 3),
    (49.99, 10, 'Classic T-Shirt', 'Comfortable cotton tee', 5, 4, 4),
    (19.99, 50, 'Classic White Tee', ' A timeless cotton t-shirt perfect for casual wear',6, 4, 5),
    (79.99, 20, 'Vintage Denim Jacket', 'Rugged and stylish, this jacket is a must-have for any wardrobe',2, 5, 1),
    (30.0, 10, 'Nice shirt', 'Nice cottom shirt', 3, 3, 2),
    (10, 5, 'Runnig pants', 'Nice quality and cheap pants for your exercise', 4, 2,1),
    (30, 3, ' Running Sneakers', 'Hit the ground running with these comfortable and supportive sneakers', 5,6,1),
    (15.99, 1, ' Yoga Leggings', 'Stretch and move freely in these soft and flexible leggings', 4, 2, 4),
    (9.99, 40, 'Linen Shirt ', 'Lightweight and breathable, perfect for hot summer days', 5, 3, 5);


INSERT INTO COLORS_OF_PRODUCT (colorID, productID)
VALUES 
    (4, 1),
    (1,2),
    (2,3),
    (3,4),
    (4,5),
    (4,6),
    (5,7),
    (2,8),
    (3,9),
    (1,10),
    (5,11);

INSERT INTO SIZE_OF_PRODUCT (sizeID, productID)
VALUES 
    (1,1),
    (2,2),
    (3,3),
    (4,4),
    (5,5),
    (1,6),
    (2,7),
    (3,8),
    (4,9),
    (5,10),
    (1,11);

INSERT INTO CONDITION_OF_PRODUCT (conditionID, productID)
VALUES 
    (1,1),
    (2,2),
    (3,3),
    (4,4),
    (5,5),
    (1,6),
    (2,7),
    (3,8),
    (4,9),
    (5,10),
    (1,11);

INSERT INTO IMAGES(path) VALUES 
('images/Jeans.jpg'),
('images/JeansT.jpeg'),
('images/CanvasSneaker.jpg'),
('images/CanvasSneakerT.jpg'),
('images/LeatherJacket.jpg'),
('images/LeatherJacketT.jpg'),
('images/LinenShirt.jpg'),
('images/LinenShirtT.jpg'),
('images/NiceShirt.jpg'),
('images/NiceShirtT.jpg'),
('images/RunningPants.jpg'),
('images/RunningPantsT.jpg'),
('images/T-Shirt.jpg'),
('images/T-shirtT.jpeg'),
('images/VintageDenimJacket.jpg'),
('images/VintageDenimJacketT.jpg'),
('images/WhiteTee.jpg'),
('images/WhiteTeeT.jpeg'),
('images/YogaLeggins.jpg'),
('images/YogaLegginsT.jpg'),
('images/RunningSneakers.jpg'),
('images/RunningSneakersT.jpg');

Insert INTO IMAGES_OF_PRODUCT(imageID, productID) VALUES
(1,1),
(2,1),
(3,2),
(4,2),
(5,3),
(6,3),
(7,11),
(8,11),
(9,7),
(10,7),
(11,8),
(12,8),
(13,4),
(14,4),
(15,6),
(16,6),
(17,5),
(18,5),
(19,10),
(20,10),
(21, 9),
(22,9);




