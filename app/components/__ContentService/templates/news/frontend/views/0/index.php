<h2>Новости</h2>
<?php

    foreach ($model as $data){
        echo '<b>'.(date('d.m.Y', strtotime($data->created_at))).'</b></br>';
        echo '<a href="/news/'.$data->id.'">'.$data->name.'</a></br>';
    }