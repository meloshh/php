<?php

namespace Framework;

use Qiq\Template;

class View
{
    public function __construct(
        public string|array    $relativePaths,
        public string          $name,
        public array|\stdClass $data,
        public null|string     $layout = null
    )
    {
    }

    public function getRenderStr()
    {
        $t = Template::new($this->relativePaths);
        // $t->setView('hello');
        $t->setData($this->data);
        $t->setLayout($this->layout);

        return $t->render($this->name);
    }
}