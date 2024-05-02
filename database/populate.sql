INSERT INTO USERS (username, name, email, password, is_admin)
VALUES
    ('alice_smith', 'Alice Smith', 'alice@example.com', 'strong_password', 1),
    ('bob_jones', 'Bob Jones', 'bob@example.com', 'secret_password', 0),
    ('emma_wilson', 'Emma Wilson', 'emma@example.com', 'hidden_password', 0),
    ('rafa', 'Rafael Campeão', 'rc@example.com', 'passwordIncrivelMeuDeus', 1);

INSERT INTO CATEGORY (name, description)
VALUES
    ('Footwear', 'Shoes, sandals, and sneakers.'),
    ('Accessories', 'Belts, scarves, and hats.'),
    ('Outerwear', 'Jackets, coats, and sweaters.'),
    ('Shirts','normal shirts');

INSERT INTO CONDITION (name, description)
VALUES
    ('Used', 'Gently worn items in excellent condition.'),
    ('Clearance', 'Discounted items with minor imperfections.'),
    ('Vintage', 'Classic and timeless pieces from the past.');

INSERT INTO BRAND (name) VALUES ('Nike');
INSERT INTO BRAND (name) VALUES ('Adidas');
INSERT INTO BRAND (name) VALUES ('Puma');

INSERT INTO COLOR (name) VALUES ('Red');
INSERT INTO COLOR (name) VALUES ('Blue');
INSERT INTO COLOR (name) VALUES ('Green');

INSERT INTO SIZE (name) VALUES ('Small');
INSERT INTO SIZE (name) VALUES ('Medium');
INSERT INTO SIZE (name) VALUES ('Large');

INSERT INTO PRODUCTS (price, quantity, name, description, owner, category, brand)
VALUES
    (79.99, 5, 'Denim Jeans', 'Slim-fit jeans', 2, 1, 1),
    (29.99, 20, 'Canvas Sneakers', 'Casual shoes', 3, 2, 2),
    (149.99, 3, 'Leather Jacket', 'Stylish biker jacket', 1, 3, 3),
    (49.99, 10, 'Classic T-Shirt', 'Comfortable cotton tee', 1, 2, 3);

INSERT INTO WISHLIST (userID, productID)
VALUES 
    (1, 2),
    (3,2),
    (2,1);

INSERT INTO SHOPPINGCART (userID, productID)
VALUES
    (2, 2),
    (3, 4),
    (1, 3);

INSERT INTO COLORS_OF_PRODUCT (colorID, productID)
VALUES 
    (1, 1),
    (2,3),
    (3,2);

INSERT INTO SIZE_OF_PRODUCT (sizeID, productID)
VALUES 
    (2, 1),
    (1,2),
    (2,3);

INSERT INTO CONDITION_OF_PRODUCT (conditionID, productID)
VALUES 
    (1, 1),
    (2,2),
    (3,3);

INSERT INTO IMAGES (path) VALUES ('images/canvas-shoes.jpg');
INSERT INTO IMAGES (path) VALUES ('images/jeans.jpg');
INSERT INTO IMAGES (path) VALUES ('images/leather_jacket.jpg');
INSERT INTO IMAGES (path) VALUES ('images/t-shirt.jpg');

INSERT INTO IMAGES_OF_PRODUCT (imageID, productID)
VALUES
    (1,2),
    (2,1),
    (3,3),
    (4,4);




