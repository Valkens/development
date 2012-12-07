<?php

/* @__main__/default/layout.twig */
class __TwigTemplate_8c43ef5d112f9aa1258ac29ff37967e0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    ";
        // line 4
        $this->displayBlock('head', $context, $blocks);
        // line 7
        echo "</head>
<body>
<div id=\"content\">";
        // line 9
        $this->displayBlock('content', $context, $blocks);
        echo "</div>
<div id=\"footer\">
    ";
        // line 11
        $this->displayBlock('footer', $context, $blocks);
        // line 14
        echo "</div>
</body>
</html>";
    }

    // line 4
    public function block_head($context, array $blocks = array())
    {
        // line 5
        echo "        <title>";
        $this->displayBlock('title', $context, $blocks);
        echo " - My Webpage</title>
    ";
    }

    public function block_title($context, array $blocks = array())
    {
    }

    // line 9
    public function block_content($context, array $blocks = array())
    {
    }

    // line 11
    public function block_footer($context, array $blocks = array())
    {
        // line 12
        echo "        &copy; Copyright 2011 by <a href=\"http://domain.invalid/\">you</a>.
    ";
    }

    public function getTemplateName()
    {
        return "@__main__/default/layout.twig";
    }

    public function getDebugInfo()
    {
        return array (  69 => 12,  66 => 11,  61 => 9,  50 => 5,  47 => 4,  41 => 14,  34 => 9,  28 => 4,  23 => 1,  56 => 13,  52 => 11,  49 => 10,  39 => 11,  36 => 4,  30 => 7,);
    }
}
