CREATE DATABASE IF NOT EXISTS medsmart;

USE medsmart;

DROP TABLE IF EXISTS cart;
DROP TABLE IF EXISTS contact;
DROP TABLE IF EXISTS Prescription;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` double NOT NULL,
  `discount` double NOT NULL,
  `image` varchar(500) NOT NULL,
  CONSTRAINT product_PK PRIMARY KEY (`id`)
);

CREATE TABLE Prescription (
	Prescription_ID INT AUTO_INCREMENT,
	User_ID INT NOT NULL,
  Remarks VARCHAR(200),
	Image VARCHAR(100) NOT NULL,
	Pharmacist_ID INT,
	Approved BIT,
  Price FLOAT(32),

	CONSTRAINT Prescription_PK PRIMARY KEY(Prescription_ID, User_ID)
);

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  CONSTRAINT user_pk PRIMARY KEY(id)
);

CREATE TABLE `cart` (
  `id` int AUTO_INCREMENT ,
  `user_id` int(11),
  `product_id` int(11),
  `prescription_id` INT,
  `amount` INT,
  
  CONSTRAINT cart_PK PRIMARY KEY(id),
  CONSTRAINT cart_user_FK FOREIGN KEY(user_id) REFERENCES user(id),
  CONSTRAINT cart_product_FK FOREIGN KEY(product_id) REFERENCES product(id),
  CONSTRAINT cart_pres_FK FOREIGN KEY(prescription_id) REFERENCES Prescription(Prescription_ID),
  CONSTRAINT cart_item_type CHECK((product_id IS NULL AND prescription_id IS NOT NULL) OR (product_id IS NOT NULL AND prescription_id IS NULL)),
  CONSTRAINT cart_unique_prod UNIQUE(user_id, product_id),
  CONSTRAINT cart_unique_pres UNIQUE(user_id, prescription_id),
  CONSTRAINT cart_pres_amount CHECK(product_id IS NOT NULL OR amount = 1)
);

CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` char(30) NOT NULL,
  `telno` varchar(15) NOT NULL,
  `message` varchar(200) NOT NULL,
  CONSTRAINT contact_PK PRIMARY KEY(id)
);

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  CONSTRAINT admin_PK PRIMARY KEY(id)
);

INSERT INTO `admin` VALUES (
  1, 'admin', '$2y$10$tkB4/DkrCr7CJQmYp9Xzxeiu8Gn8JPG6bSQoyiAWlVSHnwmGhsfQG'
);

INSERT INTO `product` (`id`, `name`, `description`, `price`, `discount`, `image`) VALUES
(1, 'Medical Bandage', 'Crepe bandages provide support and help relieve\r\npain. There are several types of bandages \r\navailable in the market for specific needs.', 2000, 100, 'ima1.jpg'),
(2, 'Surgical Mask', '100% Genuine Surgical Face Masks; Made with \r\nMedical Grade Premium Melt Blown Fabric\r\nApproved by National Medicines Regulatory \r\nAuthority', 1500, 350, 'afa.jpg'),
(3, 'Emergency Bag', 'Made of aluminized non-stretch polyester, this \r\nlarge blanket will reflect heat back to body and \r\nprevent heat loss in cold conditions.', 6400, 0, 'assd.webp'),
(4, 'Surgical Tape', 'Microporous surgical tape backed by thin highly \r\npermeable non-woven paper with uniformly coated \r\nhypoallergenic adhesive.', 1750, 100, 'ima12.jpg'),
(5, 'Operation Scissor', 'Surgical scissors curved or straight made of\r\nhigh quality stainless steel and CE certification.', 3400, 0, 'ima34.jpg'),
(6, 'Thermometer', 'Buy Thermometers online at the lowest prices\r\nonline in Sri Lanka available in the market \r\nfor specific needs.', 9250, 340, 'ima9.webp'),
(7, 'Infrared Thermometer', ' Best Buy has digital thermometers. Let us help \r\nyou find the best thermometer for you, including \r\ninfrared forehead thermometers and more.', 12300, 500, 'ima234.webp'),
(8, 'Hand gloves', 'medical glove manufacturers exports a range of \r\nexamination gloves and surgical gloves that are \r\navailable in un-powdered or powdered versions.', 550, 0, 'ima2.webp'),
(9, 'Face Mask', '100% Genuine Surgical Face Masks; Made with \r\nMedical Grade Premium Melt Blown Fabric\r\nApproved by National Medicines Regulatory \r\nAuthority', 150, 0, 'wssa.webp'),
(10, 'Eco Face Mask', '100% Genuine Surgical Face Masks; Made with \r\nMedical Grade Premium Melt Blown Fabric\r\nApproved by National Medicines Regulatory \r\nAuthority', 1200, 100, 'gges.webp'),
(11, 'Medical Bandage', 'Crepe bandages provide support and help relieve \r\npain. There are several types of bandages \r\navailable in the market for specific needs.', 1100, 100, 'ima2.webp');