<?php

/**
 * @version     1.0.3
 * @package     com_collectionviews
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Eric Murray <eric@altosmarketing.com> - http://ericmurray.me
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Collectionviews records.
 */
class CollectionviewsModelArrangements extends JModelList
{

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'catid', 'a.catid',
                'title', 'a.title',
                'password', 'a.password',
                'items', 'a.items',
                'item_ids', 'a.item_ids',
                'created_by', 'a.created_by',

            );
        }
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since    1.6
     */
    protected function populateState($ordering = null, $direction = null)
    {


        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = $app->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);

        if ($list = $app->getUserStateFromRequest($this->context . '.list', 'list', array(), 'array')) {
            foreach ($list as $name => $value) {
                // Extra validations
                switch ($name) {
                    case 'fullordering':
                        $orderingParts = explode(' ', $value);

                        if (count($orderingParts) >= 2) {
                            // Latest part will be considered the direction
                            $fullDirection = end($orderingParts);

                            if (in_array(strtoupper($fullDirection), array('ASC', 'DESC', ''))) {
                                $this->setState('list.direction', $fullDirection);
                            }

                            unset($orderingParts[count($orderingParts) - 1]);

                            // The rest will be the ordering
                            $fullOrdering = implode(' ', $orderingParts);

                            if (in_array($fullOrdering, $this->filter_fields)) {
                                $this->setState('list.ordering', $fullOrdering);
                            }
                        } else {
                            $this->setState('list.ordering', $ordering);
                            $this->setState('list.direction', $direction);
                        }
                        break;

                    case 'ordering':
                        if (!in_array($value, $this->filter_fields)) {
                            $value = $ordering;
                        }
                        break;

                    case 'direction':
                        if (!in_array(strtoupper($value), array('ASC', 'DESC', ''))) {
                            $value = $direction;
                        }
                        break;

                    case 'limit':
                        $limit = $value;
                        break;

                    // Just to keep the default case
                    default:
                        $value = $value;
                        break;
                }

                $this->setState('list.' . $name, $value);
            }
        }

        // Receive & set filters
        if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array')) {
            foreach ($filters as $name => $value) {
                $this->setState('filter.' . $name, $value);
            }
        }

        $this->setState('list.ordering', $app->input->get('filter_order'));
        $this->setState('list.direction', $app->input->get('filter_order_Dir'));
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return    JDatabaseQuery
     * @since    1.6
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query
            ->select(
                $this->getState(
                    'list.select', 'DISTINCT a.*'
                )
            );

        $query->from('`#__collectionviews_arrangement` AS a');

        
    // Join over the users for the checked out user.
    $query->select('uc.name AS editor');
    $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// Join over the foreign key 'catid'
		$query->select('#__categories_1594298.title AS categories_title_1594298');
		$query->join('LEFT', '#__categories AS #__categories_1594298 ON #__categories_1594298.id = a.catid');
		// Join over the foreign key 'item_ids'
		$query->select('#__collectionviews_collectionitem_1595197.title AS collectionitems_title_1595197');
		$query->join('LEFT', '#__collectionviews_collectionitem AS #__collectionviews_collectionitem_1595197 ON #__collectionviews_collectionitem_1595197.id = a.item_ids');
		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int)substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.title LIKE '.$search.' )');
            }
        }

        

		//Filtering catid
		$filter_catid = $this->state->get("filter.catid");
		if ($filter_catid) {
			$query->where("a.catid = '".$db->escape($filter_catid)."'");
		}

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems()
    {
        $items = parent::getItems();
        foreach($items as $item){
	

			if (isset($item->catid) && $item->catid != '') {
				if(is_object($item->catid)){
					$item->catid = JArrayHelper::fromObject($item->catid);
				}
				$values = (is_array($item->catid)) ? $item->catid : explode(',',$item->catid);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title')
							->from('`#__categories`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$item->catid = !empty($textValue) ? implode(', ', $textValue) : $item->catid;

			}

			if (isset($item->item_ids) && $item->item_ids != '') {
				if(is_object($item->item_ids)){
					$item->item_ids = JArrayHelper::fromObject($item->item_ids);
				}
				$values = (is_array($item->item_ids)) ? $item->item_ids : explode(',',$item->item_ids);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title')
							->from('`#__collectionviews_collectionitem`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$item->item_ids = !empty($textValue) ? implode(', ', $textValue) : $item->item_ids;

			}
}
        return $items;
    }
}