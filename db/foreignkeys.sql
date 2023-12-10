ALTER TABLE `rrs`.`CANCEL` 
ADD CONSTRAINT `cancel_user_username`
  FOREIGN KEY (`username`)
  REFERENCES `rrs`.`USER` (`username`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `cancel_ticket_ticket_id`
  FOREIGN KEY (`ticket_id`)
  REFERENCES `rrs`.`TICKET` (`ticket_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `cancel_passenger_passenger_id`
  FOREIGN KEY (`passenger_id`)
  REFERENCES `rrs`.`PASSENGER` (`passenger_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `rrs`.`PASSENGER` 
ADD CONSTRAINT `passenger_user_username`
  FOREIGN KEY (`username`)
  REFERENCES `rrs`.`USER` (`username`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `rrs`.`STATION` 
ADD CONSTRAINT `station_train_train_no`
  FOREIGN KEY (`train_no`)
  REFERENCES `rrs`.`TRAIN` (`train_no`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `rrs`.`TICKET` 
ADD CONSTRAINT `ticket_user_username`
  FOREIGN KEY (`username`)
  REFERENCES `rrs`.`USER` (`username`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `rrs`.`TRAIN_STATUS` 
ADD CONSTRAINT `train_status_train_no`
  FOREIGN KEY (`train_no`)
  REFERENCES `rrs`.`TRAIN` (`train_no`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `rrs`.`STARTS` 
ADD CONSTRAINT `starts_train_no`
  FOREIGN KEY (`train_no`)
  REFERENCES `rrs`.`TRAIN` (`train_no`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `starts_station_code`
  FOREIGN KEY (`station_code`)
  REFERENCES `rrs`.`STATION` (`station_code`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `rrs`.`STOPS` 
ADD CONSTRAINT `stops_train_no`
  FOREIGN KEY (`train_no`)
  REFERENCES `rrs`.`TRAIN` (`train_no`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `stops_station_code`
  FOREIGN KEY (`station_code`)
  REFERENCES `rrs`.`STATION` (`station_code`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
