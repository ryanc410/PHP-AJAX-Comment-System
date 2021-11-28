// Execute first
CREATE TABLE IF NOT EXISTS `TABLE_NAME_HERE` (
  `comment_id` int(11) NOT NULL,
  `parent_comment_id` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `comment_sender_name` varchar(40) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `TABLE_NAME_HERE`
  ADD PRIMARY KEY (`comment_id`);

// Adds Auto Increment feature to the comment id
ALTER TABLE `TABLE_NAME_HERE`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;
