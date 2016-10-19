<?php
/**
 * User: 周智超
 * Date: 2016/8/2
 * Time: 17:03
 */

namespace view;


class Twig extends Base{
    /**
     * @var string The path to the Twig code directory WITHOUT the trailing slash
     */
    public $parserDirectory = null;

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @var array Paths to directories to attempt to load Twig template from
     */
    public $twigTemplateDirs = array();

    /**
     * @var array The options for the Twig environment, see
     * http://www.twig-project.org/book/03-Twig-for-Developers
     */
    public $parserOptions = array();

    /**
     * @var TwigExtension The Twig extensions you want to load
     */
    public $parserExtensions = array();

    /**
     * @var TwigEnvironment The Twig environment for rendering templates.
     */
    private $parserInstance = null;

    /**
     * Render Twig Template
     *
     * This method will output the rendered template content
     *
     * @param string $template The path to the Twig template, relative to the Twig templates directory.
     * @param null $data
     * @param bool $isAbsolute
     * @return string
     */
    protected function render($template, $data = null, $isAbsolute = false) {
        $env = $this->getInstance();
        $parser = $env->loadTemplate($template);
        $data = array_merge($this->all(), (array) $data);
        return $parser->render($data);
    }
    public function getEnvironment()
    {
        return $this->getInstance();
    }

    /**
     * Creates new TwigEnvironment if it doesn't already exist, and returns it.
     *
     * @return \Twig_Environment
     */
    public function getInstance()
    {
        if (!$this->parserInstance) {
            /**
             * Check if Twig_Autoloader class exists
             * otherwise include it.
             */
            if (!class_exists('\Twig_Autoloader')) {
                require_once $this->parserDirectory . '/Autoloader.php';
            }

            \Twig_Autoloader::register();
            $loader = new \Twig_Loader_Filesystem($this->getTemplateDirs());
            $this->parserInstance = new \Twig_Environment(
                $loader,
                $this->parserOptions
            );

            foreach ($this->parserExtensions as $ext) {
                $extension = is_object($ext) ? $ext : new $ext;
                $this->parserInstance->addExtension($extension);
            }
        }

        return $this->parserInstance;
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * Get a list of template directories
     *
     * Returns an array of templates defined by self::$twigTemplateDirs, falls
     * back to Slim\View's built-in getTemplatesDirectory method.
     *
     * @return array
     **/
    private function getTemplateDirs()
    {
        if (empty($this->twigTemplateDirs)) {
            return array($this->getTemplatesDirectory());
        }
        return $this->twigTemplateDirs;
    }
}