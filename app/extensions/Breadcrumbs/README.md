Breadcrumbs
=============


##Что нужно, чтобы это работало
- Модели должны содержать аттрибуты NAME и URL
- Если нужны родители, модели должны иметь realtion с названием "parent"



##Как использовать
Установить расширение "Breadcrumbs" в директорию с алиасом `application.extensions`

```php
$this->widget(
    'application.extensions.Breadcrumbs.Breadcrumbs',
    array(
        'params'=>array(
            'model'=>$model
        )
    )
);
```