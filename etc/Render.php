<?php


namespace Framework;

use Framework\Interfaces\RenderInterfaces;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class Render implements RenderInterfaces
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var FilesystemLoader
     */
    private $loader;

    /**
     * Render constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->loader = new FilesystemLoader($path);
        $this->twig = new Environment($this->loader, ['debug' => true]);
        $this->twig->addExtension(new DebugExtension());
    }

    /**
     * @param string      $namespace
     * @param null|string $path
     *
     * @throws \Twig\Error\LoaderError
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }

    /**
     * @param string     $view
     * @param array|null $params
     * @param string     $type
     *
     * @return mixed|string
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $view, array $params = null, $type = 'html')
    {
        if (isset($_SESSION['flash'])) {
            $params['__flash'] = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        $params['__session'] = $_SESSION;
        $params['__auth'] = $_SESSION['auth'] ?? null;
        $params['__csrf'] = $_SESSION['__csrf'] ?? null;
        $params['__page'] = $view.".{$type}.twig";

        return $this->twig->render($view.".{$type}.twig", $params);
        //return $this->twig->render($view, $params);
    }
}
