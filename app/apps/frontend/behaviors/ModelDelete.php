<?php

class ModelDelete extends CActiveRecordBehavior
{
    /*
     * Проверка внешних связей при удалении элемента модели.
     * Если существует связь типа HAS_MANY, проверяется наличие связанных записей.
     * Если запись найдена - выводится исключение.
     *
     * @throws CDbException если найден связанный элемент модели
     */
    public function beforeDelete()
    {
        $owner = $this->owner;
        foreach($owner->relations() as $relation) {
            if($relation[0] == $owner::HAS_MANY) {
                $model = call_user_func("{$relation[1]}::model");
                $exists = $model->exists("{$relation[2]}=:{$relation[2]}", array(":{$relation[2]}" => $owner->id));
                if($exists) {
                    // Создаём экземпляр потомка CEvent
                    $event = new CModelEvent($this);
                    $event->isValid = false;

                    throw new CDbException('Элемент модели "' . get_class($owner)
                        . '" не удалён поскольку ссылка на него содержится в связанной модели "' . get_class($model)
                        . '". Идентификатор элемента: ' . $owner->id);
                }
            }
        }
    }
}