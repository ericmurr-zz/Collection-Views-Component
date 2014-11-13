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
$elements = ModCollectionviewsHelper::getList($params);
?>

<?php if (!empty($elements)) : ?>
    <table class="table">
        <?php foreach ($elements as $element): ?>
            <tr>
                <th><?php echo ModCollectionviewsHelper::renderTranslatableHeader($params, $params->get('field')); ?></th>
                <td><?php echo ModCollectionviewsHelper::renderElement($params->get('table'), $params->get('field'), $element->{$params->get('field')}); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>