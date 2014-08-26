<?php
$idx = isset($bookAuthor->id) ? $bookAuthor->id : time();
?>
<tr id="tr_<?= $idx ?>">
    <td style="width: 64%">
        <?php if ( ! isset($authorList))  : ?>
            <?= $bookAuthor->author0->name ?>
            <input type="hidden" name="Book[Author][<?= $idx ?>]" value="<?= $bookAuthor->author0->id ?>">
        <?php
        else :
            echo CHtml::dropDownList('Book[Author]['.$idx.']', null, CHtml::listData($authorList, 'id', 'name'), array('style'=>'width:415px'));
        endif;
        ?>
    </td>
    <td>
        <a id="delAuthor" data="<?= $idx ?>" href="javascript:void(0)">delete</a>
    </td>
</tr>