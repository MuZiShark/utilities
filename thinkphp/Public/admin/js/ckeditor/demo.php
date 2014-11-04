<input name="subject" type="text" >

<?php
include './ckeditor/ckeditor.php'; //include ckeditor.php
$ckeditor = new CKEditor;
//include './ckfinder/ckfinder.php';
$ckeditor->editor('content');
//CKFinder::SetupCKEditor($ckeditor, true, true);

?>
<input name="submit" type="submit" value="提交"  />