<?php
defined('C5_EXECUTE') or die("Access Denied.");
$f = $fv->getFile();
$fp = new Permissions($f);
$dh = Core::make('date');
if (!isset($mode) || !$mode) {
    $mode = 'single';
}
?>
<? if ($mode == 'single') { ?>
<div class="row">
    <div class="col-md-3"><p><?= t('ID') ?></p></div>
    <div class="col-md-9"><p><?= $fv->getFileID() ?> <span style="color: #afafaf">(<?= t(
                    'Version') ?> <?= $fv->getFileVersionID() ?>)</p></div>
</div>
<div class="row">
    <div class="col-md-3"><p><?= t('Filename') ?></p></div>
    <div class="col-md-9"><p><?= h($fv->getFileName()) ?></p></div>
</div>
<? } ?>

<?
$url = $fv->getURL();
?>
<div class="row">
    <div class="col-md-3"><p><?= t('URL to File') ?></p></div>
    <div class="col-md-9"><p style="overflow: hidden"><?= $url ?></p></div>
</div>
<? if ($mode == 'single') { ?>
    <?
    $oc = $f->getOriginalPageObject();
    if (is_object($oc)) {
        $fileManager = Page::getByPath('/dashboard/files/search');
        $ocName = $oc->getCollectionName();
        if (is_object($fileManager) && !$fileManager->isError()) {
            if ($fileManager->getCollectionID() == $oc->getCollectionID()) {
                $ocName = t('Dashboard File Manager');
            }
        }
        ?>
        <div class="row">
            <div class="col-md-3"><p><?= t('Page Added To') ?></p></div>
            <div class="col-md-9"><p><a href="<?= Loader::helper('navigation')->getLinkToCollection($oc) ?>"
                                        target="_blank"><?= $ocName ?></a></p></div>
        </div>
    <? } ?>

    <div class="row">
        <div class="col-md-3"><p><?= t('Type') ?></p></div>
        <div class="col-md-9"><p><?= $fv->getType() ?></p></div>
    </div>

<? } ?>

<? if ($fv->getTypeObject()->getGenericType() == \Concrete\Core\File\Type\Type::T_IMAGE) {
    try {
        $thumbnails = $fv->getThumbnails();
    } catch (InvalidDimensionException $e) {
        ?>
        <div class="row">

            <div class="col-md-3"><p><?= t('Thumbnails') ?></p></div>
            <div class="col-md-9">
                <p style="color:#cc3333">
                    <?= t('Invalid file dimensions, please rescan this file.') ?>
                    <? if ($mode != 'preview' && $fp->canEditFileContents()) { ?>
                        <a href="#" class="btn pull-right btn-default btn-xs"
                           data-action="rescan"><?= t('Rescan') ?></a>
                    <? } ?>
                </p>
            </div>
        </div>
    <?php
    } catch (\Exception $e) {
        ?>
        <div class="row">

            <div class="col-md-3"><p><?= t('Thumbnails') ?></p></div>
            <div class="col-md-9">
                <p style="color:#cc3333">
                    <?= t('Unknown error retrieving thumbnails, please rescan this file.') ?>
                    <? if ($mode != 'preview' && $fp->canEditFileContents()) { ?>
                        <a href="#" class="btn pull-right btn-default btn-xs"
                           data-action="rescan"><?= t('Rescan') ?></a>
                    <? } ?>
                </p>
            </div>
        </div>
    <?php
    }
    if ($thumbnails) {
        ?>
        <div class="row">
            <div class="col-md-3"><p><?= t('Thumbnails') ?></p></div>
            <div class="col-md-9"><p><a class="dialog-launch icon-link"
                                        dialog-title="<?= t('Thumbnail Images') ?>"
                                        dialog-width="90%" dialog-height="70%" href="<?= URL::to(
                        '/ccm/system/dialogs/file/thumbnails') ?>?fID=<?= $fv->getFileID() ?>&fvID=<?= $fv->getFileVersionID() ?>"><?= count(
                            $thumbnails) ?> <i class="fa fa-edit"></i></a></p></div>
        </div>
    <?
    }
}
?>
<? if ($mode == 'single') { ?>

    <div class="row">
        <div class="col-md-3"><p><?= t('Size') ?></p></div>
        <div class="col-md-9"><p><?= $fv->getSize() ?> (<?= t2(/*i18n: %s is a number */
                    '%s byte',
                    '%s bytes',
                    $fv->getFullSize(),
                    Loader::helper('number')->format($fv->getFullSize())) ?>)</p></div>
    </div>
    <div class="row">
        <div class="col-md-3"><p><?= t('Date Added') ?></p></div>
        <div class="col-md-9"><p><?= t(
                    'Added by <strong>%s</strong> on %s',
                    $fv->getAuthorName(),
                    $dh->formatDateTime($f->getDateAdded(), true)) ?></p></div>
    </div>
    <?
    $fsl = $f->getFileStorageLocationObject();
    if (is_object($fsl)) { ?>
        <div class="row">
            <div class="col-md-3"><p><?= t('Storage Location') ?></p></div>
            <div class="col-md-9"><p><?= $fsl->getDisplayName() ?></div>
        </div>
    <? } ?>
<? } ?>
<div class="row">
    <div class="col-md-3"><p><?= t('Title') ?></p></div>
    <div class="col-md-9"><p><span
                <? if ($fp->canEditFileProperties()) { ?>data-editable-field-type="xeditable"
                data-type="text" data-name="fvTitle"<? } ?>><?= h($fv->getTitle()) ?></span></p></div>
</div>
<div class="row">
    <div class="col-md-3"><p><?= t('Description') ?></p></div>
    <div class="col-md-9"><p><span
                <? if ($fp->canEditFileProperties()) { ?>data-editable-field-type="xeditable"
                data-type="textarea" data-name="fvDescription"<? } ?>><?= h(
                    $fv->getDescription()) ?></span></p></div>
</div>
<div class="row">
    <div class="col-md-3"><p><?= t('Tags') ?></p></div>
    <div class="col-md-9"><p><span
                <? if ($fp->canEditFileProperties()) { ?>data-editable-field-type="xeditable"
                data-type="textarea" data-name="fvTags"<? } ?>><?= h($fv->getTags()) ?></span></p></div>
</div>
