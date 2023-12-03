
-- select TRAIN.train_no, TRAIN.train_name,
-- aSTATION.station_code as 'from', aSTATION.departure_time, aSTATION.day as departure_day, 
-- dSTATION.station_code as 'to', dSTATION.arrival_time, dSTATION.day as arrival_day,
-- TRAIN.Mon, TRAIN.Tue, TRAIN.Wed, TRAIN.Thu, TRAIN.Fri, TRAIN.Sat, TRAIN.Sun, aSTATION.train_no, dSTATION.train_no
-- from TRAIN, STATION as aSTATION, STATION as dSTATION
-- where dSTATION.train_no = TRAIN.train_no and TRAIN.train_no =  aSTATION.train_no 
-- and dSTATION.departure_time = 0 and aSTATION.arrival_time = 0;
