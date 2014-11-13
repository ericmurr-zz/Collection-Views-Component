<?php

/**
 * @version     1.0.3
 * @package     com_collectionviews
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Eric Murray <eric@altosmarketing.com> - http://ericmurray.me
 */
defined('_JEXEC') or die;

class CollectionviewsFrontendHelper {
    
	/**
	* Get category name using category ID
	* @param integer $category_id Category ID
	* @return mixed category name if the category was found, null otherwise
	*/
	public static function getCategoryNameByCategoryId($category_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select('title')
			->from('#__categories')
			->where('id = ' . intval($category_id));

		$db->setQuery($query);
		return $db->loadResult();
	}
}
