<?php

namespace Framework;

class View
{
    // Name of the file associated with the view
    private $file;

    // Title of the view (defined in the view file)
    private $title;

    public function render($template, $data = [])
    {
        $this->file = '../template/'.$template.'.php';
        $content = $this->renderFile($this->file, $data);
        $view = $this->renderFile('../template/template.php', ['title'=> $this->title, 'content' => $content]);
        echo $view;
    }

    public function renderFile($file, $data)
    {
        if(file_exists($file)){
            extract($data);
            ob_start();
            include $file;
            return ob_get_clean();
        }
    }
}