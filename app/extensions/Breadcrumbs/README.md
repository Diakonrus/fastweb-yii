Breadcrumbs
=============


##Что нужно, чтобы это работало
- Модели должны содержать аттрибуты NAME и URL
- Если нужны родители, модели должны иметь realtion с названием "parent"



##Как использовать
Extract the `EasyImage` folder under `protected/extensions`

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