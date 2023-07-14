<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right form-inline">
                <button type="submit" form="form-module" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
            <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if ($success) { ?>
            <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
                <span class="pull-right"><?php echo $text_info; ?></span>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-main" data-toggle="tab"><?php echo $tab_main; ?></a></li>
                </ul>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
                    <div class="tab-content">
                        <div class="tab-pane active form-horizontal" id="tab-main">
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-name"><span class="help" title="<?php echo $help_name; ?>" data-toggle="tooltip"><?php echo $entry_name; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="pet_form_name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control"/>
                                    <?php if ($error_name): ?>
                                        <div class="text-danger"><?php echo $error_name; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status"><span class="help" title="<?php echo $help_status; ?>" data-toggle="tooltip"><?php echo $entry_status; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="pet_form_status" id="input-status" class="form-control">
                                        <option value="0" <?php echo "0" == $status ? "selected" : ""; ?>><?php echo $text_disabled; ?></option>
                                        <option value="1" <?php echo "1" == $status ? "selected" : ""; ?>><?php echo $text_enabled; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script type="text/javascript"><!--
    $('.nav[id*=language]').find('a:first').tab('show');
//--></script>
<?php echo $footer; ?>
</div>
