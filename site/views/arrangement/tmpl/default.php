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

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_collectionviews', JPATH_ADMINISTRATOR);
$canEdit = JFactory::getUser()->authorise('core.edit', 'com_collectionviews');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_collectionviews')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_COLLECTIONVIEWS_FORM_LBL_ARRANGEMENT_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_COLLECTIONVIEWS_FORM_LBL_ARRANGEMENT_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_COLLECTIONVIEWS_FORM_LBL_ARRANGEMENT_CATID'); ?></th>
			<td><?php echo $this->item->catid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_COLLECTIONVIEWS_FORM_LBL_ARRANGEMENT_TITLE'); ?></th>
			<td><?php echo $this->item->title; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_COLLECTIONVIEWS_FORM_LBL_ARRANGEMENT_PASSWORD'); ?></th>
			<td><?php echo $this->item->password; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_COLLECTIONVIEWS_FORM_LBL_ARRANGEMENT_ITEMS'); ?></th>
			<td><?php echo $this->item->items; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_COLLECTIONVIEWS_FORM_LBL_ARRANGEMENT_ITEM_IDS'); ?></th>
			<td><?php echo $this->item->item_ids; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_COLLECTIONVIEWS_FORM_LBL_ARRANGEMENT_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_collectionviews&task=arrangement.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_COLLECTIONVIEWS_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_collectionviews')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_collectionviews&task=arrangement.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_COLLECTIONVIEWS_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_COLLECTIONVIEWS_ITEM_NOT_LOADED');
endif;
?>
