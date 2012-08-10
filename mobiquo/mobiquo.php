<?php

require_once('mobiquoCommon.php');

$oMbqMain = new MbqMain();  /* frame init */
$oMbqMain->input();     /* handle input data */
$oMbqMain->initAppEnv();    /* application environment init */
$oMbqMain->action();    /* main program handle */
$oMbqMain->beforeOutput();  /* do something before output */
$oMbqMain->output();    /* handle output data */

?>