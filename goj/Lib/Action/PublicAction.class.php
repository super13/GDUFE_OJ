<?php
class PublicAction extends Action{
     Public function verify(){
         import('ORG.Util.Image');
         Image::buildImageVerify(4,1,'png',60,25,'verify');
     }
 }
?>
