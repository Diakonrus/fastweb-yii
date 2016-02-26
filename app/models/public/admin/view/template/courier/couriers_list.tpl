<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('Вы уверены, что хотите удалить запись?') ? $('#form-product').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-product">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td><?=$column_firstname;?></td>
                  <td><?=$column_lastname;?></td>
                  <td><?=$column_middlename;?></td>
                  <td><?=$column_email1;?></td>
                  <td><?=$column_email2;?></td>
                  <td><?=$column_phone1;?></td>
                  <td><?=$column_phone2;?></td>
                  <td><?=$column_phone3;?></td>
                  <td><?=$column_telegramid;?></td>
                  <td><?=$column_city;?></td>
                  <td><?=$column_address;?></td>
                  <td><?=$column_comments;?></td>
                  <td><?=$column_status;?></td>
                  <td class="text-right">Действие</td>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($couriers)) { ?>
                <?php foreach ($couriers as $courier) { ?>
                <tr>
                  <td class="text-center">
                    <input type="checkbox" name="selected[]" value="<?php echo $courier['courier_id']; ?>" />
                  </td>
                  <td class="text-left"><?php echo $courier['firstname']; ?></td>
                  <td class="text-left"><?php echo $courier['lastname']; ?></td>
                  <td class="text-left"><?php echo $courier['middlename']; ?></td>
                  <td class="text-left"><?php echo $courier['email1']; ?></td>
                  <td class="text-left"><?php echo $courier['email2']; ?></td>
                  <td class="text-left"><?php echo $courier['phone1']; ?></td>
                  <td class="text-left"><?php echo $courier['phone2']; ?></td>
                  <td class="text-left"><?php echo $courier['phone3']; ?></td>
                  <td class="text-left"><?php echo $courier['telegramid']; ?></td>
                  <td class="text-left"><?php echo $courier['city']; ?></td>
                  <td class="text-left"><?php echo $courier['address']; ?></td>
                  <td class="text-left"><?php echo $courier['comments']; ?></td>
                  <td class="text-left"><?php echo (($courier['status'] == 1)?('Действующий'):('Не работает')); ?></td>
                  <td class="text-right"><a href="<?php echo $courier['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="15"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=catalog/product&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_model = $('input[name=\'filter_model\']').val();

	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}

	var filter_price = $('input[name=\'filter_price\']').val();

	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}

	var filter_quantity = $('input[name=\'filter_quantity\']').val();

	if (filter_quantity) {
		url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
	}

	var filter_status = $('select[name=\'filter_status\']').val();

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	location = url;
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_name\']').val(item['label']);
	}
});

$('input[name=\'filter_model\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['model'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_model\']').val(item['label']);
	}
});
//--></script></div>
<?php echo $footer; ?>