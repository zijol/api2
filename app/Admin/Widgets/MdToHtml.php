<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/2/1
 * Time: 11:00
 */

namespace App\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class MdToHtml implements Renderable
{
    protected $content = '';

    public function __construct($content)
    {
        $this->content = $content;
    }


    public function render()
    {
        return view("md", ['content' => $this->content]);
    }
}
