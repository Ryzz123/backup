/**
     * Handle a matched route
     *
     * @param array $route The matched route
     * @param array $matches The matched parameters from the route
     * @param Request $request The current request instance
     * @param Response $response The current response instance
     * @param ioc $container The DI container instance
     * @return void
     * @throws BindingResolutionException
     * @throws ReflectionException
     */
    private static function handleRoute(array $route, array $matches, Request $request, Response $response, ioc $container): void
    {
        foreach ($route['middleware'] as $middleware) {
            $middlewareInstance = $container->make($middleware);
            $middlewareInstance->before($request, $response);
        }

        array_shift($matches);

        if ($route['function'] !== null) {
            $controllerInstance = $container->make($route['controller']);
            self::handler([$controllerInstance, $route['function']], $matches, $request, $response, $container);
        } else {
            self::handler($route['controller'], $matches, $request, $response, $container);
        }
    }

    /**
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    private static function handler($handler, array $matches, $request, $response, $container)
    {
        if (is_array($handler)) {
            // Handler is an array (object and method)
            list($object, $method) = $handler;
            $reflection = new ReflectionMethod($object, $method);
        } else {
            // Handler is a Closure or function
            $reflection = new ReflectionFunction($handler);
        }

        $parameters = $reflection->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $paramType = $parameter->getType();
            $paramName = $parameter->getName();
            if ($paramType && !$paramType->isBuiltin()) {
                $className = $paramType->getName();
                $dependencies[] = $container->make($className);
            } elseif ($paramName === 'req') {
                $dependencies[] = $request;
            } elseif ($paramName === 'res') {
                $dependencies[] = $response;
            } else {
                $dependencies[] = array_shift($matches);
            }
        }

        // Call method or closure
        if (isset($object)) {
            return $reflection->invokeArgs($object, $dependencies);
        } else {
            return $reflection->invokeArgs($dependencies);
        }
    }

/**
 * Group Routes
 *
 * Creates a group of routes with a common prefix.
 *
 * @param string $prefix The common prefix for the grouped routes
 * @param Closure $callback The callback function to define routes within the group
 * @return void
 */
public static function group(string $prefix, Closure $callback): void
{
    // Get the singleton instance of the Route class
    $route = self::getInstance();

    // Save the current prefix to restore it later
    $previousPrefix = $route->prefix;

    // Set the new prefix by concatenating the previous one
    $newPrefix = rtrim($previousPrefix, '/') . '/' . ltrim($prefix, '/');
    $route->setPrefix($newPrefix);

    // Execute the callback function to define routes within the group
    $callback($route);

    // Restore the previous prefix after group processing
    $route->setPrefix($previousPrefix);
}

/**
 * Match Routes
 *
 * Defines a route that matches multiple HTTP methods with the specified path, handler, and dynamic middleware.
 *
 * @param array $methods The HTTP methods (e.g., GET, POST) to match
 * @param string $path The URL path pattern for the route
 * @param callable|string $handler The controller class and method or a callback function handling the route
 * @param string|null $method The method name if the handler is a controller class (optional)
 * @param array $middleware An associative array where keys are HTTP methods and values are middleware arrays
 * @return void
 */
public static function match(array $methods, string $path, callable|string $handler, ?string $method = null, array $middleware = []): void
{
    $route = self::getInstance();

    foreach ($methods as $httpMethod) {
        $httpMethod = strtoupper($httpMethod);

        // Check if there are specific middleware for this HTTP method
        $methodMiddleware = $middleware[$httpMethod] ?? [];

        if (is_callable($handler)) {
            // Handle the case where $handler is a callable (function)
            $route->addRoute($httpMethod, $path, $handler, null, $methodMiddleware);
        } else {
            // Handle the case where $handler is a controller class
            $route->addRoute($httpMethod, $path, $handler, $method, $methodMiddleware);
        }
    }
}

/**
 * Set Prefix
 *
 * Sets the prefix for the grouped routes.
 *
 * @param string|null $prefix The common prefix for the grouped routes
 * @return void
 */
protected function setPrefix(?string $prefix): void
{
    $this->prefix = $prefix;
}
