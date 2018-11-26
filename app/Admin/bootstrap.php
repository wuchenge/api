<?php

use App\Admin\Extensions\Column\ExpandRow;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid\Column;

use App\Admin\Extensions\WangEditor;
use App\Admin\Extensions\MyLightbox;
use App\Admin\Extensions\MyFieldLightbox;

Form::forget(['map', 'editor']);

Form::extend('editor', WangEditor::class);
Form::extend('my_lightbox', MyFieldLightbox::class);
Column::extend('my_lightbox', MyLightbox::class);
