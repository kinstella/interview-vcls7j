<?php

namespace Collegeplannerpro\InterviewReport;

class Router
{
    private array $routes;
    private $notFoundController;

    public function __construct(array $routes, callable $notFoundController)
    {
        $this->routes = $routes;
        $this->notFoundController = $notFoundController;
    }

    public function resolve(string $path): string
    {
        foreach ($this->routes as $r) {
            if (preg_match($r['pattern'], $path, $pathMatches)) {
                // reg-exp matches array is wrapped in a NullableMemberLookup object
                // and passed to the specified controller callable
                return $r['controller'](new NullableMemberLookup($pathMatches));
            }
        }

        return ($this->notFoundController)();
    }
}
