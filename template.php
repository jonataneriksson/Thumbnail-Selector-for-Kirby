<input class="[ js-selector-storage ]" type="hidden" name="<?= $field->name() ?>" id="<?= $field->name() ?>" value="<?= implode(',', $field->value()) ?>" />


<?php


?>

<?php if ($field->files()->count() > 0):  ?>
    <div class="input input-with-items">

        <?php foreach ($field->files() as $file): ?>

            <?php

              $fileobject = array(
                'type' => (string)$file->type(),
                'filename' => (string)$file->filename(),
                'video' => (string)str_replace(site()->url(), '', $file->thumb(['original' => true, 'silent' => 'true'])->url()),
                'ratio' => (string)$file->thumb(['height' => 480, 'still' => true])->ratio(),
                'orientation' => (string)$file->thumb(['height' =>480, 'still' => true])->orientation()
              );

              $fileobject = array_merge($fileobject, $field->getthumbnails($file, ['clip' => true, 'still' => true, 'silent' => 'true']));

              $data = (string)(json_encode($fileobject, JSON_HEX_APOS));
              $cleandata = str_replace('"','\'', $data);
             ?>
            <div id="<?= $field->itemId($file) ?>" class="item item-with-image [ selector-item js-selector-item ]" data-file="<?= $cleandata ?>" <?= r($field->isInValue($file), 'data-checked="true"') ?> >
                <div class="item-content">
                    <?php if ($file->type() == 'image'): ?>
                        <figure class="item-image">
                            <?php if (version_compare(panel()->version(), '2.2', '>=')): ?>
                                <?php if ($field->editable()): ?>
                                    <a class="btn btn-with-icon" data-context="<?= purl($file, 'context') ?>" href="#options" title="<?= l('pages.show.subpages.edit') ?>">
                                        <?= thumb($file, array('width' => 48, 'height' => 48, 'crop' => true)) ?>
                                    </a>
                                <?php else: ?>
                                    <?= thumb($file, array('width' => 48, 'height' => 48, 'crop' => true)) ?>
                                <?php endif ?>
                            <?php else: ?>
                                <a class="btn btn-with-icon" href="<?= purl($file, 'show') ?>" title="<?= l('pages.show.subpages.edit') ?>">
                                    <?= thumb($file, array('width' => 48, 'height' => 48, 'crop' => true)) ?>
                                </a>
                            <?php endif ?>
                        </figure>
                    <?php else: ?>
                        <figure class="item-image item-filetype">
                            <?php if ($field->editable()): ?>
                                <a class="btn btn-with-icon" data-context="<?= purl($file, 'context') ?>" href="#options" title="<?= l('pages.show.subpages.edit') ?>">
                                    <?= strtoupper($file->extension()) ?>
                                </a>
                            <?php else: ?>
                                <?= strtoupper($file->extension()) ?>
                            <?php endif ?>
                        </figure>
                    <?php endif ?>
                    <div class="item-info">
                        <div class="fix">
                            <strong class="item-title">
                                <?= $file->filename() ?>
                            </strong>
                            <small class="item-meta marginalia">
                                <?= $file->type() ?> / <?= $file->niceSize() ?>
                                <?php if (($file->type() == 'image') and ($file->extension() != 'svg')): ?>
                                    / <?= $file->width() ?> x <?= $file->height() ?>
                                <?php endif ?>
                            </small>
                        </div>
                    </div>
                </div>

                <nav class="item-options">
                    <ul class="nav nav-bar">
                        <?php if ($field->editable()): ?>
                            <li>
                                <?php if (version_compare(panel()->version(), '2.2', '>=')): ?>
                                    <a class="btn btn-with-icon" data-context="<?= purl($file, 'context') ?>" href="#options" title="<?= l('pages.show.subpages.edit') ?>">
                                        <i class="icon icon-left fa fa-pencil"></i>
                                        <span><?= l('pages.show.subpages.edit') ?></span>
                                    </a>
                                <?php else: ?>
                                    <a class="btn btn-with-icon" href="<?= purl($file, 'show') ?>" title="<?= l('pages.show.subpages.edit') ?>">
                                        <i class="icon icon-left fa fa-pencil"></i>
                                        <span><?= l('pages.show.subpages.edit') ?></span>
                                    </a>
                                <?php endif ?>
                            </li>
                        <?php endif ?>
                        <li>
                            <a class="btn btn-with-icon [ selector-checkbox js-selector-checkbox ]" href="#" title="<?= l::get('selector.select') ?>">
                                <i class="icon icon-left fa fa-circle-o"></i>
                                <span><?= l::get('selector.select') ?></span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        <?php endforeach ?>

    </div>
<?php else: ?>
    <div class="field field-is-readonly field-with-icon">
        <div class="field-content">
            <input class="input input-is-readonly" type="text" readonly placeholder="" value="<?= l::get('selector.empty', 'No matching files yet.') ?>">
            <div class="field-icon">
                <i class="icon fa fa-info"></i>
            </div>
        </div>
    </div>
<?php endif ?>
