<?php
namespace Sherpa\Twig\Extension;

class Core extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'is_array' => new \Twig_Function_Function('is_array'),
        );
    }

    public function getName()
    {
        return 'sherpa_core';
    }
}
