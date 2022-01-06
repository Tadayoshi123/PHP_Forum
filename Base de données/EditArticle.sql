SELECT UserName 
FROM Users 
INNER JOIN Title, Description, CreationDate 
ON Users.UserId = Articles.UserId
WHERE Articles.ArticleId = ArticleId


//modification Title

UPDATE Articles 
set Title = 'Title'
WHERE ArticleId = 'ArticleId'

//modification Description


UPDATE Articles 
set Description = 'Description'
WHERE ArticleId = 'ArticleId'

