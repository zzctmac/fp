<?php
/**
 * User: 周智超
 * Date: 2016/8/2
 * Time: 16:57
 */

namespace view;


class Native extends Base{
    private $root;
    private $suffix;

    /**
     * Native constructor.
     * @param $root
     * @param $suffix
     */
    public function __construct($root, $suffix) {
        $this->root = $root;
        $this->templatesDirectory = $root;
        $this->suffix = $suffix;
        parent::__construct();
    }

    /**
     * Render a template file
     *
     * NOTE: This method should be overridden by custom view subclasses
     *
     * @param  string $template The template pathname, relative to the template base directory
     * @param  array $data Any additonal data to be passed to the template.
     * @param bool $isAbsolute
     * @return string The rendered template
     */
    protected function render($template, $data = null, $isAbsolute = false)
    {
        if($isAbsolute) {
            $templatePathname = $template;
        }
        else {
            $templatePathname = $this->getTemplatePathname($template);
        }
        if (!is_file($templatePathname)) {
            throw new \RuntimeException("View cannot render `$template` because the template does not exist");
        }

        $data = array_merge($this->data->all(), (array) $data);
        extract($data);
        ob_start();
        require $templatePathname;

        return ob_get_clean();
    }

}