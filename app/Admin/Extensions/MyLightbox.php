<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-15 14:07:23
 */

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;
use Illuminate\Support\Facades\Storage;

class MyLightbox extends AbstractDisplayer
{
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

    public function display(array $options = [])
    {
        if (empty($this->value)) {
            return '';
        }

        $server = array_get($options, 'server');
        $width = array_get($options, 'width', 200);
        $height = array_get($options, 'height', 200);

        if (array_get($options, 'zooming')) {
            $this->zooming();
        }

        Admin::script($this->script());

        // 这里添加数组
        if ($this->value instanceof Arrayable) {
            $this->value = $this->value->toArray();
        }

        return collect((array) $this->value)->filter()->map(function ($path) use ($server, $width, $height) {
            if (url()->isValidUrl($path) || strpos($path, 'data:image') === 0) {
                $src = $path;
            } elseif ($server) {
                $src = rtrim($server, '/').'/'.ltrim($path, '/');
            } else {
                $src = Storage::disk(config('admin.upload.disk'))->url($path);
            }

            return <<<HTML
<a href="$src" class="grid-popup-link">
    <img src='$src' style='max-width:{$width}px;max-height:{$height}px' class='img img-thumbnail' />
</a>
HTML;
        })->implode('&nbsp;');
    }
}
