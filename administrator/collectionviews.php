<?php
/**
 * @version     1.0.3
 * @package     com_collectionviews
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Eric Murray <eric@altosmarketing.com> - http://ericmurray.me
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_collectionviews')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Collectionviews');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
