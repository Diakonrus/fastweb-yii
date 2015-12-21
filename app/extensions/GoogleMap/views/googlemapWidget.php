
    <!-- Google maps -->
    <script type="text/javascript">

    var map;

    $(function(){

        map = new google.maps.Map( $('.<?php echo $id ?>-map_canvas')[0], {
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var geocoder = new google.maps.Geocoder();

        var marker = new google.maps.Marker({
            map: map
        });

        map.setMarker = function(location){
            marker.setPosition(location);
        }

        // set map point by location
        map.setAddressByLatLng = function(location){
            map.setCenter(location);
            map.setMarker(location);
        }

        map.updateFields = function(location){
            $('.<?php echo $id ?>-geo_lat').val(location.lat());
            $('.<?php echo $id ?>-geo_lng').val(location.lng());
            $('.<?php echo $id ?>-geo_zoom').val(map.getZoom());
        };

        // set map point by address string
        map.setAddress = function(value){
            geocoder.geocode( { 'address': value}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.updateFields(results[0].geometry.location);
                    map.setAddressByLatLng(results[0].geometry.location);
                } else {
                    alert("Ошибка geocode: " + status);
                }
            });
        }

        map.updateAddress = function(){
            map.setAddress( $(".<?php echo $id ?>-address").val() )
        }

        // Обновляем значение поля при смене zoom карты
        google.maps.event.addListener(map, 'zoom_changed', function() {
            $('.<?php echo $id ?>-geo_zoom').val(map.getZoom());
        });

        google.maps.event.addListener(map, 'click', function(event) {
            map.updateFields(event.latLng);
            map.setMarker(event.latLng);
        });

        //google.maps.event.addListener(map, 'center_changed', function() {
        //    var center = map.getCenter();
        //    map.updateFields(center);
        //    map.setMarker(center);
        //});

        <?php if( !empty($model->geo_lng) && !empty($model->geo_lat) ): ?>
            var location = new google.maps.LatLng(<?php echo $model->geo_lat ?>, <?php echo $model->geo_lng ?>);
            map.setAddressByLatLng(location);
        <?php endif ?>

        <?php if( !empty($model->geo_zoom) ): ?>
            map.setZoom(<?php echo $model->geo_zoom ?>);
        <?php endif ?>

    });

    </script>

    <div class="admin-field-block">
        <label>Карта</label>
	    <?php echo CHtml::textField('address', '', array('class' => $id . '-address', 'style'=>'float:left; width: 610px',  'onkeydown' => "if (event.keyCode == 13) { map.updateAddress(); return false; }" ) ); ?>
	    <?php echo CHtml::button('Найти', array('onclick'=>'map.updateAddress(); return false;', 'class' => "btn", 'style'=>'float:left; margin-left: 10px') ); ?>
        <div class="<?php echo $id ?>-map_canvas" style="width: 700px; height: 400px"></div>
    </div>

    <div class="admin-field-block">
        <?php echo $form->textField($model,'geo_lng',array('class'=> $id . '-geo_lng span5', 'readonly' => 'readonly', 'maxlength'=>255));; ?>
        <?php echo $form->textField($model,'geo_lat',array('class'=> $id . '-geo_lat span5', 'readonly' => 'readonly', 'maxlength'=>255));; ?>
        <?php echo $form->textField($model,'geo_zoom',array('class'=> $id . '-geo_zoom span5', 'readonly' => 'readonly')); ?>
    </div>


    <!-- Google maps //-->