<?php

namespace Cryptows\Classes;

class Backview
{

    public function getStyles(): ?string
    {
        $styles = array_diff(scandir(CWSROOT . '/src/view/backview/assets/css'), array('.', '..'));
        $stylesPath = '';

        foreach($styles as $style)
        {
            $stylesPath .= '<link rel="stylesheet" href="'.CWSSCRIPTPATH. 'src/view/backview/assets/css/'.$style.'">';
        }

        return $stylesPath;
    }

    public function getInline(): ?string
    {
        return file_get_contents(CWSROOT . '/src/view/backview/assets/inline.txt');
    }

    public function getScripts(): ?string
    {
        $scripts = array_diff(scandir(CWSROOT . '/src/view/backview/assets/js'), array('.', '..'));
        $scriptPath = '';

        foreach($scripts as $script)
        {
            $scriptPath .= '<script src="'.CWSSCRIPTPATH. 'src/view/backview/assets/js/'.$script.'"></script>';
        }

        return $scriptPath;
    }

}