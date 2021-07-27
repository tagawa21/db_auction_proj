/*primary keys*/
ALTER TABLE auction.output DROP PRIMARY KEY;
ALTER TABLE auction.users DROP PRIMARY KEY;
ALTER TABLE auction.output ADD PRIMARY KEY(`ItemID`);
ALTER TABLE auction.users ADD PRIMARY KEY(`UID`);

/*constraints*/
ALTER TABLE auction.output ADD CONSTRAINT uniid UNIQUE(itemID);
ALTER TABLE auction.users ADD CONSTRAINT unuid UNIQUE(uid);

/*indices*/
ALTER TABLE auction.output ADD INDEX descIDX (description(50));
ALTER TABLE auction.sellers ADD INDEX sellIDX (userid);
ALTER TABLE auction.categories ADD INDEX catIDX (category);

/*triggers*/
DELIMITER $$ 
DROP TRIGGER IF EXISTS auction.posid;
CREATE TRIGGER posid BEFORE INSERT ON auction.output 
    FOR EACH ROW 
    BEGIN 
    IF NEW.itemID <= 0 THEN 
        signal sqlstate '45000'; 
    END IF; 
END; $$
DELIMITER ;

DELIMITER $$
DROP TRIGGER IF EXISTS auction.addbidtrig;
CREATE TRIGGER auction.addbidtrig BEFORE INSERT ON bids FOR EACH ROW BEGIN 
IF (NEW.Amount > (SELECT output.currently FROM output WHERE NEW.ItemID = output.ItemID) 
    AND NEW.Time < (SELECT output.ends FROM output WHERE NEW.ItemID = output.ItemID)) THEN
    UPDATE output SET currently = NEW.amount WHERE NEW.itemID = itemID;
    UPDATE output SET number_of_bids = number_of_bids + 1 WHERE NEW.itemID = itemID;
    UPDATE output SET top_bidder = NEW.userid WHERE NEW.itemID = itemID;
ELSE
     signal sqlstate '45000';
END IF;
END; $$
DELIMITER ;
