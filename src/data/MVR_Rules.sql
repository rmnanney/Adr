CREATE TABLE MVR_Rules (
  id INT,
  ruleSetID INT UNSIGNED,
  minOccurrences SMALLINT UNSIGNED,
  riskBoundary BIGINT UNSIGNED,
  points SMALLINT UNSIGNED,
  decision VARCHAR(8)

);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (1, 1, 1, 2, null, 157800000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (2, 1, 1, 0, null, 160430000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (3, 1, 2, 3, null, 94680000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (4, 1, 2, 3, null, 157800000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (5, 1, 2, 0, 'REFER', 157800000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (6, 2, 1, 2, null, 94680000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (7, 2, 1, 2, 'REFER', 3153600000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (8, 2, 2, 3, null, 157800000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (9, 2, 2, 2, 'REFER', 3153600000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (10, 2, 3, 3, null, 3153600000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (11, 3, 1, 1, null, 157800000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (12, 3, 2, 2, null, 94680000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (13, 3, 2, 1, null, 157800000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (14, 3, 3, 3, null, 94680000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (15, 3, 3, 2, null, 157800000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (16, 3, 3, 1, null, 3153600000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (17, 4, 1, 1, null, 157800000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (18, 4, 2, 2, null, 157800000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (19, 4, 2, 1, null, 3153600000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (20, 5, 1, 3, null, 94680000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (21, 5, 1, 0, 'REFER', 97310000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (22, 6, 1, 3, null, 3153600000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (23, 7, 1, 2, null, 94680000);
INSERT INTO MVR_Rules(id, ruleSetID, minOccurrences, points, decision, riskBoundary) VALUES (24, 7, 1, 0, 'REFER', 97310000);