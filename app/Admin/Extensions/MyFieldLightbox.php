<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-15 14:37:46
 */

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class MyFieldLightbox extends Field
{
    protected $view = 'admin.images';

    public $options = [
        'type' => 'image'
    ];

    protected function script()
    {
        $options = json_encode($this->options);

        return <<<SCRIPT
$('.grid-popup-link').magnificPopup($options);
SCRIPT;
    }

    public function zooming()
    {
        $this->options = array_merge($this->options, [
            'mainClass' => 'mfp-with-zoom',
            'zoom' => [
                'enabled' => true,
                'duration' => 300,
                'easing'   => 'ease-in-out',
            ]
        ]);
    }

    public function render()
    {
        $this->zooming();
        $this->script = $this->script();
        return parent::render();
    }
}
