SELECT UserName 
FROM Users 
INNER JOIN Title, Description, CreationDate 
ON Users.UserId = Articles.UserId
WHERE Articles.ArticleId = ArticleId