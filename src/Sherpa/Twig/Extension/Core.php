<?php
namespace Sherpa\Twig\Extension;

class Core extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'is_array' => new \Twig_Function_Function('is_array'),
            'md5'      => new \Twig_Function_Function('md5'),
        );
    }

    public function getName()
    {
        return 'sherpa_core';
    }
}
