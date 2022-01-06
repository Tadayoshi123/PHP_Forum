SELECT UserName, Email
FROM Users 
INNER JOIN Title, Description, CreationDate , ArticleId
ON Users.UserId = Articles.UserId
WHERE Users.UserName = 'UserName'


//modification password

UPDATE Users 
set Password = 'newPassword'
WHERE UserId = 'UserId'

//modification Email


UPDATE Users 
set Email = 'Email'
WHERE UserId = 'UserId'

//modification UserName


UPDATE Users 
set UserName = 'UserName'
WHERE UserId = 'UserId'

//getPassword

SELECT password
FROM Users
WHERE UserId = 'UserId'

//delete 
DELETE FROM Articles
WHERE ArticleId = 'ArticleId'