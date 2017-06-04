-- Reset Application State
TRUNCATE game;
TRUNCATE game_bid;
TRUNCATE payoff;
TRUNCATE karma;
TRUNCATE karma_bid;
UPDATE user set score = 0 WHERE 1;