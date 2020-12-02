 
 #####Please create a basic entity for storing quotes. It should contain information about author and type. Please create a CRUD. Code should be compatible with Symfony 5.1 and PHP 7.4 best practices.
 
I am a little misunderstood what you mean here: *It should contain information about author and type*

So, I just add field author_name to the `quote` table . You can see here src/Entity/Quote.php


###How to test it
 
 
 `docker-compose -f .docker/docker-compose.yml up -d`
 
 `docker ps` - copy php container id
 
 `docker exec -it <container id> sh`
 
 `composer install` - in php container
 
 `bin/console doctrine:database:create` - create db
 
 `bin/console   doctrine:migrations:migrate` - run migrations
 
 ```   
 curl --request GET    \
     --url http://localhost/api/quotes
```

```
  curl --request POST \
     --url http://localhost/api/quote \
     --header 'content-type: application/json' \
     --data '{"quote": "Hello world", "authorName":"Ben"}'
```
     
``` 
 curl --request GET    \
     --url http://localhost/api/quote/1
```

```
  curl --request PATCH    \
      --url http://localhost/api/quote/1 \
      --header 'content-type: application/json'   \
      --data '{"quote": "Hello world", "authorName":"Ben Men"}'
```

```
  curl --request DELETE    \
      --url http://localhost/api/quote/1
```