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

    public function getFilters()
    {
        $filters = array(
            'humanize' => new \Twig_Filter_Method($this, 'humanize'),
        );

        return $filters;
    }

    public function humanize($value)
    {
        switch (gettype($value)) {
            case 'boolean':
                $result = $value ? 'True' : 'False';
                break;

            default:
                $result = $value;
                break;
        }

        return $result;
    }
}
