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

jimport('joomla.application.component.controllerform');

/**
 * Collectionitem controller class.
 */
class CollectionviewsControllerCollectionitem extends JControllerForm
{

    function __construct() {
        $this->view_list = 'collectionitems';
        parent::__construct();
    }

}