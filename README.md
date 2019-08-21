# repositorio-laravel-pattern
Esta es una implementación posible al patrón de repositorio para Laravel. Sobre la base que la clase concreta se implementará con Eloquent.

El archivo RepositoryInterface ubicado dentro de app/Http/Interfaces/ es una interfaz que define los métodos. 

El archivo GeneralRepository ubicado dentro de app/Http/Repository/ es una clase abstracta que sirve como puntapié inicial para cualquier ejecución de un modelo. 

#Uso
El uso de estos archivo es el siguiente:
- Inyectaremos los controladores con interfaces particulares por cada modelo qu extiendan la interfaz RepositoryInterface. 
- La clase concreta que implementará dicha interface será una extensión de GeneralRepository. 
- Deberemos registrar AppServiceProvider la implentación de la abstración en el método register.

#Ejemplo
Para el modelo "posts" realizaremos una interfaz PostsRepositoryInterface y una clase concreta PostRepository. 

PostRepositoryInterface.php
```
interface PostRepositoryInterface extends RepositoryInterface
```

PostRepository.php
```
class PostRepository extends GeneralRepository implements PostRepositoryInterface
```

AppServiceProvider
```
$this->app->bind('App\Http\Interfaces\PostRepositoryInterface',
            'App\Http\Repository\PostRepository');
```

