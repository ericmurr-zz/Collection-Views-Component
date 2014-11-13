<?php

/**
 * @version     1.0.3
 * @package     com_collectionviews
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Eric Murray <eric@altosmarketing.com> - http://ericmurray.me
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Collectionviews helper.
 */
class CollectionviewsHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_COLLECTIONVIEWS_TITLE_COLLECTIONITEMS'),
			'index.php?option=com_collectionviews&view=collectionitems',
			$vName == 'collectionitems'
		);
		JHtmlSidebar::addEntry(
			JText::_('JCATEGORIES') . ' (' . JText::_('COM_COLLECTIONVIEWS_TITLE_COLLECTIONITEMS') . ')',
			"index.php?option=com_categories&extension=com_collectionviews",
			$vName == 'categories'
		);
		if ($vName=='categories') {
			JToolBarHelper::title('Collection Views: JCATEGORIES (COM_COLLECTIONVIEWS_TITLE_COLLECTIONITEMS)');
		}
		JHtmlSidebar::addEntry(
			JText::_('COM_COLLECTIONVIEWS_TITLE_ARRANGEMENTS'),
			'index.php?option=com_collectionviews&view=arrangements',
			$vName == 'arrangements'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_collectionviews';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
