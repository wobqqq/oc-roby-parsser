<?php

Block::put('breadcrumb') ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= Backend::url('blackseadigital/parser/resources') ?>">Resources</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= e($this->pageTitle) ?></li>
</ol>
<?php
Block::endPut() ?>

<?php
if (!$this->fatalError): ?>

    <?= Form::open(['class' => 'd-flex flex-column h-100']) ?>

    <div class="flex-grow-1">
        <?= $this->formRender() ?>
    </div>

    <div class="form-buttons">
        <div data-control="loader-container">
            <button
                type="submit"
                data-request="onSave"
                data-request-data="{ redirect: 0 }"
                data-hotkey="ctrl+s, cmd+s"
                data-request-message="<?= __('Saving :name...', ['name' => $formRecordName]) ?>"
                class="btn btn-primary">
                <?= __('Save') ?>
            </button>
            <button
                type="button"
                data-request="onSave"
                data-request-data="{ close: 1 }"
                data-browser-redirect-back
                data-hotkey="ctrl+enter, cmd+enter"
                data-request-message="<?= __('Saving :name...', ['name' => $formRecordName]) ?>"
                class="btn btn-default">
                <?= __('Save & Close') ?>
            </button>
            <span class="btn-text">
                    <span class="button-separator"><?= __('or') ?></span>
                    <a
                        href="<?= Backend::url('blackseadigital/parser/resources') ?>"
                        class="btn btn-link p-0">
                        <?= __('Cancel') ?>
                    </a>
                </span>
        </div>
    </div>

    <?= Form::close() ?>

<?php else: ?>

    <p class="flash-message static error">
        <?= e($this->fatalError) ?>
    </p>
    <p>
        <a
            href="<?= Backend::url('blackseadigital/parser/resources') ?>"
            class="btn btn-default">
            <?= __('Return to List') ?>
        </a>
    </p>

<?php endif ?>
