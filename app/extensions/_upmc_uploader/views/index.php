<?php
/**
 * @var $this UFileUpload
 */
?>

<?php
$script = <<<SCRIPT
        var __fileupload = ({
            onResize: (function (e) {
                // calculate new component sizes
                $('.files-control .image-layer', component).each(function () {
                    var imageLayer = $(this),
                        image = imageLayer.find('img'),
                        valign = imageLayer.find('.valign');

                    // set new thumbnail height with aspectRatio option
                    imageLayer.height(imageLayer.width() * viewOptions.aspectRatio);

                    // calculate image size and align
                    if (viewOptions.stretch === 'inner' && image.attr('data-stretch') !== 'outer' ) {

                        image.css({
                            'height': '',
                            'width': '',
                            'max-height' : '100%',
                            'max-width' : '100%',
                            'left': '',
                            'top': ''
                        });

                        // vertical align switch on because vertical align into layer calculate using native css functional
                        valign.show();

                    } else if (viewOptions.stretch === 'outer' && image.attr('data-stretch') !== 'inner') {
                        // load origin size
                        var originWidth = parseInt(image.attr('data-origin-width')),
                            originHeight = parseInt(image.attr('data-origin-height')),
                            imageAspectRatio = originHeight / originWidth;

                        // first pass - set size
                        image.css({
                            'height': originHeight < originWidth ? '100%' : '',
                            'width': originWidth < originHeight ? '100%' : '',
                            'max-height' : '',
                            'max-width' : ''
                        });

                        // two pass - calculate offsets
                        image.css({
                            left: originHeight < originWidth ? -Math.round((imageLayer.height() / imageAspectRatio - imageLayer.height() / viewOptions.aspectRatio)/2) + 'px' : '',
                            top: originWidth < originHeight ? -Math.round((imageLayer.width() * imageAspectRatio - imageLayer.width() * viewOptions.aspectRatio)/2) + 'px' : '',
                        });

                        // vertical align switch off
                        valign.hide();
                    }
                });
            })
        });

        // add valign helpers
        $('.files-control .image-layer img', component).each(function () {
            $('<div/>').appendTo( $(this).parent() ).addClass('valign').hide();
        });

        component
            .on('mouseenter', '.layers', function () {
                $('.buttons-layer', this).show();
            })
            .on('mouseleave', '.layers', function () {
                $('.buttons-layer', this).hide();
            });

        $(window).on('resize', __fileupload.onResize).trigger('resize');

        // assign functions to component container
        component.data('ufileupload', __fileupload);

SCRIPT;
?>

<?php echo CHtml::encode($this->getJsItemButtons()) ?>

<?php $this->registerScript('view_section', $script, array(
    // component - это объект-контейнер виджета (обычно это div)
    'component' => new CJavaScriptExpression("$('#{$this->id}')"),
    'viewOptions' => $this->viewOptions
)) ?> 

<div id="<?php echo $this->id ?>">
    <ul class="files-control thumbnails row-fluid" >
        <li class="span2">
            <div class="thumbnail layers">
                <div class="image-layer layer">
                    <img src="/images/test01.png" data-origin-width="160" data-origin-height="80" alt="" />
                </div>
                <div class="layer buttons-layer">
                    <a href="#" class="icon-eye-open"></a>
                    <a href="#" class="icon-remove-2"></a>
                </div>
            </div>
        </li>
        <li class="span2">
            <a href="#" class="thumbnail layers">
                <div class="image-layer layer">
                    <img src="/images/test02.png" data-origin-width="80" data-origin-height="160" alt="" />
                </div>
            </a>
        </li>
        <li class="span2">
            <a href="#" class="thumbnail layers empty">
                <div class="image-layer layer"></div>
                <div class="select-layer layer multiply">
                    <span class="background icon-plus"></span>
                    <input type="file"/>
                </div>
            </a>
        </li>
    </ul>
</div>

<?php return /* new concept*/ ?>

<?php echo CHtml::openTag('div', array('id' => $this->id))?>
    <span class="btn btn-success fileinput-button">
        <span><?php echo $this->t('Select file...') ?></span>
        <!-- The file input field used as target for the file upload widget -->
        <?php echo CHtml::hiddenField($uploadName, null, array('id' => $uploadId)) ?>
        <?php echo CHtml::fileField($uploadName, null, array('multiple' => 'multiple', 'id' => $controlId))?>
    </span>
    <!-- The container for the uploaded files -->
    <div class="files">
        <ul class="thumbnails">
        </ul>
    </div>
<?php echo CHtml::closeTag('div')?>

<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        $('#<?php echo $controlId ?>').fileupload({
            url: '<?php echo $uploadUrl ?>',
            dataType: 'json',
            sequentialUploads : true,
            paramName: '<?php echo $uploadName ?>',
            done: function (e, data) {
                /* $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo('#files');
                }); */
                $('#<?php echo $uploadId ?>').val( data.result.filelink );
                $('div#<?php echo $this->id ?> .files .thumbnails').empty().append('<li class="span3"><a href="#" class="thumbnail"><img src="' + data.result.filelink + '"/></a></li>');
                //console.log(data.result);
            },
            fail: function () {

            }
        });
    });
</script>