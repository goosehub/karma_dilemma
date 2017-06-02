-- Reset Application State
TRUNCATE game;
TRUNCATE game_bid;
TRUNCATE payoff;
UPDATE user set score = 0 WHERE 1;