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

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class CollectionviewsViewCollectionitem extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar() {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $user = JFactory::getUser();
        $isNew = ($this->item->id == 0);
        if (isset($this->item->checked_out)) {
            $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        } else {
            $checkedOut = false;
        }
        $canDo = CollectionviewsHelper::getActions();

        JToolBarHelper::title(JText::_('COM_COLLECTIONVIEWS_TITLE_COLLECTIONITEM'), 'collectionitem.png');

        // If not checked out, can save the item.
        if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create')))) {

            JToolBarHelper::apply('collectionitem.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('collectionitem.save', 'JTOOLBAR_SAVE');
        }
        if (!$checkedOut && ($canDo->get('core.create'))) {
            JToolBarHelper::custom('collectionitem.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
        }
        // If an existing item, can save to a copy.
        if (!$isNew && $canDo->get('core.create')) {
            JToolBarHelper::custom('collectionitem.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
        }
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('collectionitem.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('collectionitem.cancel', 'JTOOLBAR_CLOSE');
        }
    }

}
