CREATE TABLE MVR_RuleSets (
  id INT,
  customerID MEDIUMINT UNSIGNED,
  productID MEDIUMINT UNSIGNED,
  name VARCHAR(255)
);
INSERT INTO MVR_RuleSets(id, name, customerID, productID) VALUES (1, 'Accident', 1, 1);
INSERT INTO MVR_RuleSets(id, name, customerID, productID) VALUES (2, 'DUI', 1, 1);
INSERT INTO MVR_RuleSets(id, name, customerID, productID) VALUES (3, 'Minor', 1, 1);
INSERT INTO MVR_RuleSets(id, name, customerID, productID) VALUES (4, 'Speeding', 1, 1);
INSERT INTO MVR_RuleSets(id, name, customerID, productID) VALUES (5, 'General_3_Refer', 1, 1);
INSERT INTO MVR_RuleSets(id, name, customerID, productID) VALUES (6, 'General_3_3', 1, 1);
INSERT INTO MVR_RuleSets(id, name, customerID, productID) VALUES (7, 'General_2_Refer', 1, 1);