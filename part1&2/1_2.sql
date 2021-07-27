/*1.2*/
select t1.itemid from
(select itemid, number_of_bids from output group by itemid) as t1,
(select itemid, count(itemid) as c from bids group by itemid) as t2
where t1.number_of_bids <> t2.c and t1.itemid = t2.itemid;