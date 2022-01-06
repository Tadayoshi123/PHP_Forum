SELECT UserName
FROM Users 
INNER JOIN Title, Description, CreatedDate 
ON Users.UserId = Articles.UserId