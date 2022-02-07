## 👤 👤 Usuarios:
Todos los usuarios que se registran desde cero no tienen permisos de admin, y por tanto, no podrán crear, eliminar o editar centros.

#### 👩‍🏫 Acceso administrador:
* Usuario: mpenas@cifpfbmoll.eu
* Password: Examen2022

## 💾 Base de datos
La base de datos está desplegada en un servidor remoto de IONOS.

URL: [http://victoriapenyasphp.ddns.net/adminer](http://victoriapenyasphp.ddns.net/adminer)

**Importante**: El acceso a http://victoriapenyasphp.ddns.net/ debe ser desde una red ajena al centro, ya que el firewall lo bloquea.

El acceso a la base de datos se puede recuperar desde el .env del proyecto.

## 🚀 Despliegue

El proyecto se ha desplegado en el servidor del centro, dentro de la ruta */var/www/ifc33b/mpenas/* [Ver aplicacion](http://mpenas.ifc33b.cifpfbmoll.eu/laravel_pruebas-victoriapenasmiro/CentroEducativo/public/es/centros).

## Aspectos generales
### Input type=file
Se ha limitado el input type file del formulario para que solo permita la subida de archivos de tipo imagen.

### 🔁 Old values
En el caso concreto del input type=file no es posible mostrar el fichero previamente subido después de realizar un submit. Es el comportamiento por defecto de los navegadores por temas de seguridad.

Más info en este [post](https://stackoverflow.com/questions/16365668/pre-populate-html-form-file-input).

### ⬆️ Seeders

* Se ha creado el seeder *AmbitoSeeder* para completar la tabla de ámbitos con los valores disponibles mediante QueryBuilder

* Desde *DatabaseSeeder* hay varios ejemplos de inserción utilizando:

- Sentencias raw
- QueryBuilder
- Eloquent
- Factories

### 🔡 Multiidioma
* Se ha configurado el idioma por defecto a español en el *config/app*:

~~~
locale' => 'es'
~~~

* El idioma secundario que se ejecutará en caso de que no se encuentre traducción en el idioma por defecto establecido es:

~~~
'fallback_locale' => 'en'
~~~

* Se ha configurado el *faker* para que en caso de generación de factories se realicen en español:

~~~
‘faker_locale’ => ‘es_ES’
~~~

### 🚪 Gates
El multiidioma de la aplicación se pasa como parámetro en ls URL y se controla mediante el siguiente Gate:

~~~
    Gate::define('check-language', function($user, $locale){

        if (! in_array($locale, ['en', 'es'])) {
            abort(404);
        }

        App::setLocale($locale);

        return true;
    });
~~~

### 🔐 Policies
Se ha creado *CentroPolicy* para controlar que únicamente el usuario administrador pueda realizar insert, updates y deletes.

El resto de usuarios, solo tendrán permisos de consulta.

### ✅ FormRequest - validació multiidioma
* Con el objetivo de mostrar los warnings de validación en el idioma correspondiente, se controla en el Form Request creado: StoreCentro

~~~
$lang = $this->route('lang');
abort_unless(Gate::allows('check-language', $lang), 403);
~~~

### ❗ Error Pages
Se han generado unas vistas personalizadas para los errores 404 y 403.

#### ERROR 403

* Para la página de error 403, se ha utilizado una plantilla de [Codepen.io](https://codepen.io/Mansoour/pen/LgGGvm).

Esta página se muestra al intentar acceder a un sitio restringido (error 403) y se ha forzado, también en la ruta *fallback*, es decir, cuando se intenta acceder a una ruta que no existe.

~~~
Route::fallback(function(){
  Abort(403);
});
~~~

#### ERROR 404

Se ha programado un *Abort(404)* al intentar acceder a un idioma por URL qué no sean los implementados (ES, EN).

Por ejemplo: [http://mpenas.ifc33b.cifpfbmoll.eu/laravel_pruebas-victoriapenasmiro/CentroEducativo/public/cc/centros](http://mpenas.ifc33b.cifpfbmoll.eu/laravel_pruebas-victoriapenasmiro/CentroEducativo/public/cc/centros)

### 🔖 Git tags
Para cada punto del examen se ha hecho un commit y se ha etiquetado con un tag haciendo referencia al punto del ejercicio.

### .env file
Se ha generado una copia del fichero .env: *.env copy*



