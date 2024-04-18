DROP database IF EXISTS db_ovenstore;
create database db_ovenstore;

use db_ovenstore;
DROP TABLE IF EXISTS tbl_brand;
-- Create table tbl_brand
CREATE TABLE tbl_brand (
    b_id INT AUTO_INCREMENT PRIMARY KEY,
    b_name VARCHAR(100)
);


-- Insert data into tbl_brand
INSERT INTO tbl_brand (b_name) VALUES 
('Insignia'),
('LG'),
('Panasonic'),
('Samsung'),
('Whirlpool'),
('Galanz'),
('Breville'),
('Frigidaire');

-- Drop table if it exists
DROP TABLE IF EXISTS tbl_product;

-- Create table tbl_product
CREATE TABLE tbl_product (
    p_id INT AUTO_INCREMENT PRIMARY KEY,
    brand_id INT,
    p_name VARCHAR(255),
    p_price DECIMAL(10, 2),
    p_desc TEXT,
    p_rating DECIMAL(3, 1),
    p_image VARCHAR(255),
    FOREIGN KEY (brand_id) REFERENCES tbl_brand(b_id)
);
DROP TABLE IF EXISTS tbl_userdetails;
CREATE TABLE tbl_userdetails (
    u_id INT AUTO_INCREMENT PRIMARY KEY,
    u_name VARCHAR(50) NOT NULL,
    u_password VARCHAR(255) NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    mobile_number VARCHAR(20) NOT NULL,
    user_type ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
    UNIQUE(u_name),
    UNIQUE(customer_email),
    UNIQUE(mobile_number)
);
DROP TABLE IF EXISTS tbl_orders;
CREATE TABLE tbl_orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_group_id VARCHAR(100),
    u_id INT,
    p_id INT,
    quantity INT,
    order_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (u_id) REFERENCES tbl_userdetails(u_id),
    FOREIGN KEY (p_id) REFERENCES tbl_product(p_id)
);
DROP procedure IF EXISTS GetOrderDetailsByOrderGroupId;
DELIMITER //

CREATE PROCEDURE GetOrderDetailsByOrderGroupId(IN order_group_id VARCHAR(100))
BEGIN
    SELECT 
        o.order_id,
        o.order_group_id,
        u.customer_name,
        u.customer_email,
        u.mobile_number,
        b.b_name AS brand_name,
        p.p_name AS product_name,
        p.p_price AS product_price,
        o.quantity
    FROM 
        tbl_orders o
    INNER JOIN tbl_userdetails u ON o.u_id = u.u_id
    INNER JOIN tbl_product p ON o.p_id = p.p_id
    INNER JOIN tbl_brand b ON p.brand_id = b.b_id
    WHERE 
        o.order_group_id = order_group_id;
END //

DELIMITER ;

-- Insert data into tbl_product
INSERT INTO tbl_product (brand_id, p_name, p_price, p_desc, p_rating, p_image) VALUES 
(1, 'Insignia 0.7 Cu. Ft. Microwave - Stainless Steel', 69.99, 'Heat up your food quickly and evenly with this reliable Insignia microwave. Its 0.7 cu. ft. interior is compact enough to fit on countertops of all sizes. It features 6 quick-set buttons, defrost, and 30-second express cooking to easily handle a variety of tasks, including reheating leftovers, popping popcorn, heating beverages, and more.', 4.1, '14469088.jpg'),
(2, 'LG 1.5 Cu. Ft. Microwave with Smart Inverter (LMC1575ST) ', 169.99, 'Preparing meals with a microwave should be quick and simple, and that''s exactly what you get with this LG 1.5 cu. ft. countertop microwave. This unit senses interior humidity levels and adjusts cooking time and power for the perfect dish every time. It also sports an EasyClean interior that resists stains and buildup to make cleaning a cinch.', 4.4, '10620230.jpg'),
(3, 'Panasonic Genius 1.3 Cu. Ft. Microwave - Stainless Steel/Black', 219.99, 'Serve up late-night snacks or weeknight dinners in a snap with the Panasonic Genius microwave. This mid-sized countertop microwave boasts a generous 1.3 cu. ft. capacity to accommodate large dishes with ease. It features Genius Sensor Cooking technology to ensure every dish is cooked to perfection.', 4.2, '14689611.jpg'),
(7, 'Breville Compact Wave Soft Close 0.9 Cu. Ft. Microwave- Silver', 349.99, 'Make your cooking experience easy and efficient with this Breville Compact Wave Soft Close 0.9 cu. ft. microwave. This countertop appliance comes with defrost and reheat functions to simplify your cooking needs, as well as a variety of convenient one-touch buttons. The soft-close system reduces door noise and keeps your kitchen peaceful.', 4.5, '14434796.jpg'),
(4, 'Samsung 1.1 Cu. Ft. Microwave - Charcoal', 149.99, 'Anyone can prep food like a pro with the Samsung 1.1 Cu. Ft. microwave. It comes equipped with pre-programmed auto cooking options, 10 power levels, and a 900W power output, so all you have to do is touch a few buttons and you are done. The Triple Distribution System makes sure the food is cooked evenly by distributing microwaves in three directions to reach every corner.', 3.2, '17089922.jpg'),
(3, 'Panasonic Genius 1.3 cu. ft. 1200 W Stainless-steel', 169.00, 'This stainless-steel Panasonic Genius® microwave oven features 1200 W of power and produces incredible results thanks to Inverter® technology. This technology uses variable power to cook food evenly ensuring excellent texture, colour and taste. The new soft-touch keypad is easy to use and simple to keep clean.', 4.3, '14399556.jpeg'),
(8, 'Frigidaire Over-The-Range Microwave -1.8 Cu. Ft.- White', 299.00, 'Create tasty meals and snacks for your family in a flash with this Frigidaire over-the-range microwave. Boasting a spacious 1.8 cu. ft. capacity, it has enough room to accommodate large dishes so you can have dinner on the table in just minutes. It doubles as a range hood to quickly clear the air of smoke, steam, and odours for a clean, fresh kitchen.', 4.6, '14475207.jpg'),
(8, 'Frigidaire Professional Built-In Microwave - Stainless Steel', 699.00, 'Cook delicious meals in minutes with the Frigidaire Professional built-in microwave. This versatile appliance offers a 2.2 cu. ft. capacity and nine Quick Start functions to help you get meals started quicker. It''s equipped with smart sensor technology to ensure optimal cooking and reheating results and has a sleek stainless steel finish.', 4.8, '16384973.jpg'),
(5, 'Whirlpool Countertop Microwave - 1.6 Cu. Ft. - Black Stainless', 179.00, 'Enjoy quick and easy cooking and warming with the 1200 Watt Whirlpool 1.6 cu. ft. countertop microwave. Its spacious 1.6 cu. ft. capacity and easy-to-clean glass turntable offer plenty of room for family-sized portions, while sensor cooking can automatically adjust your cook times as your dish warms.', 3.7, '11457737.jpg'),
(6, 'Galanz SpeedWave Convection Microwave with Air Fryer ', 349.00, 'Prepare a wide range of dishes at home with this Galanz SpeedWave convection microwave. This 1.6 cu. ft. countertop appliance has 3-in-1 functionality as an air fryer, convection oven, and microwave. Combi-Speed combines the convection and microwave functions to speed up cooking, and you can air-fry with less or no oil using TotalFry 360 technology.', 4.6, '14635702.jpg'),
(6, 'Galanz Retro 1.1 Cu. Ft. Microwave- White', 139.00, 'Bring modern functionality and retro style to your kitchen with the Galanz Retro 1.1 cu. ft. microwave. It offers ten variable power levels and a menu of quick cook, reheat, and defrost programs for effortless microwave cooking and reheating. Its fun design makes it a stand-out addition to any kitchen, office, or dorm room.', 3.0, '17183084.jpg'),
(4, 'Samsung 1.4 Cu. Ft. Microwave with Grill - Mirror', 199.00, 'Cook or reheat dishes at the push of a button with the Samsung 1.4 cu. ft. microwave with grill. It offers a variety of built-in cook modes, including grill, and has a touch display panel for easy one-touch operation. It uses a Triple Distribution system to ensure quick heating and better circulation throughout the ceramic enamel interior.', 2.8, '17089919.jpg');

-- Inserting admin record
INSERT INTO tbl_userdetails (u_name, u_password, customer_name, customer_email, mobile_number,user_type)
VALUES ( 'admin', '$2y$10$5kQ35iiOcTSNlkguLNEgkO5gFalLdnv6/m8MbcVzSp/q79Wml.Hqa', 'Admin', 'admin@gmail.com', '9876543210', 'admin'
);


