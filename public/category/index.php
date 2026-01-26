<?php
if (is_file('../../libs/incs.php')) {
    include_once('../../libs/incs.php');
}
if (is_file('../libs/incs.php')) {
    include_once('../libs/incs.php');
}
include_once('category/public/category.php');
$module_category = new category();

$module_category->process_data($_POST);

$module_category->publish_output();
