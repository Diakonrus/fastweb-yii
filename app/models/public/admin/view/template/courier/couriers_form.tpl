<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-review" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-firstname" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-firstname"><?php echo $column_firstname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $column_firstname; ?>" id="input-firstname" class="form-control" />
              <?php if ($error_firstname) { ?>
              <div class="text-danger"><?php echo $error_firstname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-lastname"><?php echo $column_lastname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $column_lastname; ?>" id="input-lastname" class="form-control" />
              <?php if ($error_lastname) { ?>
              <div class="text-danger"><?php echo $error_lastname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-middlename"><?php echo $column_middlename; ?></label>
            <div class="col-sm-10">
              <input type="text" name="middlename" value="<?php echo $middlename; ?>" placeholder="<?php echo $column_middlename; ?>" id="input-middlename" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-shortfio"><?php echo $column_shortfio; ?></label>
            <div class="col-sm-10">
              <input type="text" name="shortfio" value="<?php echo $shortfio; ?>" placeholder="<?php echo $column_shortfio; ?>" id="input-shortfio" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-email1"><?php echo $column_email1; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email1" value="<?php echo $email1; ?>" placeholder="<?php echo $column_email1; ?>" id="input-email1" class="form-control" />
              <?php if ($error_email1) { ?>
              <div class="text-danger"><?php echo $error_email1; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-email2"><?php echo $column_email2; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email2" value="<?php echo $email2; ?>" placeholder="<?php echo $column_email2; ?>" id="input-email2" class="form-control" />
              <?php if ($error_email2) { ?>
              <div class="text-danger"><?php echo $error_email2; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-phone1"><?php echo $column_phone1; ?></label>
            <div class="col-sm-10">
              <input type="text" name="phone1" value="<?php echo $phone1; ?>" placeholder="<?php echo $column_phone1; ?>" id="input-phone1" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-phone2"><?php echo $column_phone2; ?></label>
            <div class="col-sm-10">
              <input type="text" name="phone2" value="<?php echo $phone2; ?>" placeholder="<?php echo $column_phone2; ?>" id="input-phone2" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-telegramid"><?php echo $column_telegramid; ?></label>
            <div class="col-sm-10">
              <input type="text" name="telegramid" value="<?php echo $telegramid; ?>" placeholder="<?php echo $column_telegramid; ?>" id="input-telegramid" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-city"><?php echo $column_city; ?></label>
            <div class="col-sm-10">
              <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $column_city; ?>" id="input-city" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-address"><?php echo $column_address; ?></label>
            <div class="col-sm-10">
              <textarea rows="10" cols="45" name="address" id="input-address" class="form-control"><?php echo $address; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-comments"><?php echo $column_comments; ?></label>
            <div class="col-sm-10">
              <textarea rows="10" cols="45" name="comments" id="input-comments" class="form-control"><?php echo $comments; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-position"><?php echo $column_position; ?></label>
            <div class="col-sm-10">
              <input type="text" name="position" value="<?php echo $position; ?>" placeholder="<?php echo $column_position; ?>" id="input-position" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-pass_series"><?php echo $column_pass_series; ?></label>
            <div class="col-sm-10">
              <input type="text" name="pass_series" value="<?php echo $pass_series; ?>" placeholder="<?php echo $column_pass_series; ?>" id="input-pass_series" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-pass_number"><?php echo $column_pass_number; ?></label>
            <div class="col-sm-10">
              <input type="text" name="pass_number" value="<?php echo $pass_number; ?>" placeholder="<?php echo $column_pass_number; ?>" id="input-pass_number" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-pass_takeby"><?php echo $column_pass_takeby; ?></label>
            <div class="col-sm-10">
              <input type="text" name="pass_takeby" value="<?php echo $pass_takeby; ?>" placeholder="<?php echo $column_pass_takeby; ?>" id="input-pass_takeby" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-pass_takewhen"><?php echo $column_pass_takewhen; ?></label>
            <div class="col-sm-10">
              <input type="text" name="pass_takewhen" value="<?php echo $pass_takewhen; ?>" placeholder="<?php echo $column_pass_takewhen; ?>" id="input-pass_takewhen" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-pass_scan"><?php echo $column_pass_scan; ?></label>
            <div class="col-sm-10">
              <input type="text" name="pass_scan" value="<?php echo $pass_scan; ?>" placeholder="<?php echo $column_pass_scan; ?>" id="input-pass_scan" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-agreement_scan"><?php echo $column_agreement_scan; ?></label>
            <div class="col-sm-10">
              <input type="text" name="agreement_scan" value="<?php echo $agreement_scan; ?>" placeholder="<?php echo $column_agreement_scan; ?>" id="input-agreement_scan" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $column_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected">Действующий</option>
                <option value="0">Не работает</option>
                <?php } else { ?>
                <option value="1">Действующий</option>
                <option value="0" selected="selected">Не работает</option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php echo $footer; ?>
