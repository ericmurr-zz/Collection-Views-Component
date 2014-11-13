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
$element = ModCollectionviewsHelper::getItem($params);
?>

<?php if (!empty($element)) : ?>
    <div>
        <?php $fields = get_object_vars($element); ?>
        <?php foreach ($fields as $field_name => $field_value): ?>
            <?php if (ModCollectionviewsHelper::shouldAppear($field_name)): ?>
                <div class="row">
                    <div class="span4"><strong><?php echo ModCollectionviewsHelper::renderTranslatableHeader($params, $field_name); ?></strong></div>
                    <div class="span8"><?php echo ModCollectionviewsHelper::renderElement($params->get('item_table'), $field_name, $field_value); ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>