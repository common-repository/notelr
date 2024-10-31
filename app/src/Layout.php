<?php

class Notelr_Layout {
    private $viewsPath;
    private $layoutPath;
    private $viewPath;
    public function __construct($viewPath)
    {
        $this->viewsPath = realpath(APP_PATH."/views");
        $this->layoutPath = realpath($this->viewsPath."/layout.php");
        $this->viewPath = $viewPath;
    }
    public function render($properties)
    {
        $layoutProperties = get_object_vars($this);
        foreach($properties as $key => $property)
        {
            if(!in_array($property,$layoutProperties)){
                $this->$key = $property;
            }
        }
        $content = $this->get_include_contents($this->viewPath);
        $this->content = $content;
        include($this->layoutPath);
    }

    private function get_include_contents($filename) {
        if (is_file($filename)) {
            ob_start();
            include $filename;
            return ob_get_clean();
        }
        return false;
    }
} 