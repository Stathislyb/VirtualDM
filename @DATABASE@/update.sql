ALTER TABLE `questions` ADD `threshold` INT NOT NULL AFTER `reply`, ADD `result` INT NOT NULL AFTER `threshold`;

ALTER TABLE `adventures` ADD `selected_scene` INT(11) NOT NULL AFTER `description`, ADD `chaos_factor` INT(2) NOT NULL AFTER `selected_scene`;