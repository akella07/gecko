<?php

namespace Cryptows\Classes;

use Cryptows\Classes\Config;

class View
{
    public $template;

    /*
     * Yes, no enqueues.
     * After frontend view will be done, this part will be refactored.
     * Currently it goes like this to make things faster.
     * */

    public function getTemplate(): ?string
    {

        $template = file_get_contents(CWSROOT . '/src/view/step1.php');

        return $template;
    }


    public function getStyles(): ?string
    {
        $styles = array_diff(scandir(CWSROOT . '/src/assets/css'), array('.', '..'));
        $stylesPath = '';

        foreach($styles as $style)
        {
            $stylesPath .= '<link rel="stylesheet" href="'.CWSSCRIPTPATH. 'src/assets/css/'.$style.'">';
        }

        return $stylesPath;
    }

    public function getInline(): ?string
    {
        return file_get_contents(CWSROOT . '/src/assets/inline.txt');
    }



}