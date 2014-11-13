<?php

/**
 * @version     1.0.3
 * @package     com_collectionviews
 * @subpackage  mod_collectionviews
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Eric Murray <eric@altosmarketing.com> - http://ericmurray.me
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$doc = JFactory::getDocument();

/* */
$doc->addStyleSheet(JURI::base() . '/modules/mod_collectionviews/assets/css/style.css');

/* */
$doc->addScript(JURI::base() . '/modules/mod_collectionviews/assets/js/script.css');

require JModuleHelper::getLayoutPath('mod_collectionviews', $params->get('content_type', 'blank'));
