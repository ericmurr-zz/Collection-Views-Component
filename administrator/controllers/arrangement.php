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
 * Arrangement controller class.
 */
class CollectionviewsControllerArrangement extends JControllerForm
{

    function __construct() {
        $this->view_list = 'arrangements';
        parent::__construct();
    }

}