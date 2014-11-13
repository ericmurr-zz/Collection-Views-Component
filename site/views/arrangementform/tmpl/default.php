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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_collectionviews', JPATH_ADMINISTRATOR);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/components/com_collectionviews/assets/js/form.js');


?>
</style>
<script type="text/javascript">
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', function() {
        jQuery(document).ready(function() {
            jQuery('#form-arrangement').submit(function(event) {
                
            });

            
			jQuery('input:hidden.catid').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('catidhidden')){
					jQuery('#jform_catid option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_catid").trigger("liszt:updated");
			jQuery('input:hidden.item_ids').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('item_idshidden')){
					jQuery('#jform_item_ids option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
	jQuery('#jform_item_ids').change(function(){
		if(jQuery('#jform_item_ids option:selected').length == 0){
		jQuery("#jform_item_ids option[value=0]").attr('selected', 'selected');
		}
	});
					jQuery("#jform_item_ids").trigger("liszt:updated");
        });
    });

</script>

<div class="arrangement-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Edit <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Add</h1>
    <?php endif; ?>

    <form id="form-arrangement" action="<?php echo JRoute::_('index.php?option=com_collectionviews&task=arrangement.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
        
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
	</div>
	<?php foreach((array)$this->item->catid as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="catid" name="jform[catidhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('password'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('password'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('items'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('items'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('item_ids'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('item_ids'); ?></div>
	</div>
	<?php foreach((array)$this->item->item_ids as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="item_ids" name="jform[item_idshidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_collectionviews&task=arrangementform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>
        
        <input type="hidden" name="option" value="com_collectionviews" />
        <input type="hidden" name="task" value="arrangementform.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
