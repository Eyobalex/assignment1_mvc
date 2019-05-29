<?php
/**
 * Created by Eyob.
 * Date: 8/24/2018
 * Time: 3:18 AM
 */

defined('DS') ? null : define('DS','/');
defined('SITE_ROOT') ? null : define('SITE_ROOT','C:'. DS.'xxamp'.DS.'htdocs'.DS.'assignment1_mvc');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'included_files');
defined('MODEL_PATH') ? null : define('MODEL_PATH', SITE_ROOT.DS.'Model');
defined('CONT_PATH') ? null : define('CONT_PATH', SITE_ROOT.DS.'Controller');


require_once(LIB_PATH.DS."functions.php");
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(MODEL_PATH.DS."database_object.php");
require_once(MODEL_PATH.DS."photograph.php");
require_once(CONT_PATH.DS."photo_controller.php");