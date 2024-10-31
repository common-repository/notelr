<?php
include "Layout.php";
class Notelr_View {
    private $viewsPath;
    private $viewFilePath;
    function __construct($viewFile)
    {
        $this->viewsPath = realpath(APP_PATH."/views");
        $this->viewFilePath = realpath($this->viewsPath."/".$viewFile.".php");
    }
    public function render()
    {
        $layout = new Notelr_Layout($this->viewFilePath);
        $properties = get_object_vars($this);
        $layout->render($properties);
    }
} 