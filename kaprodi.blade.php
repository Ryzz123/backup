///**
// * Group Routes
// *
// * Creates a group of routes with a common prefix.
// *
// * @param string $prefix The common prefix for the grouped routes
// * @param Closure $callback The callback function to define routes within the group
// * @return void
// */
//public static function group(string $prefix, Closure $callback): void
//{
//    // Get the singleton instance of the Route class
//    $route = self::getInstance();
//
//    // Save the current prefix to restore it later
//    $previousPrefix = $route->prefix;
//
//    // Set the new prefix by concatenating the previous one
//    $newPrefix = rtrim($previousPrefix, '/') . '/' . ltrim($prefix, '/');
//    $route->setPrefix($newPrefix);
//
//    // Execute the callback function to define routes within the group
//    $callback($route);
//
//    // Restore the previous prefix after group processing
//    $route->setPrefix($previousPrefix);
//}
//
///**
// * Match Routes
// *
// * Defines a route that matches multiple HTTP methods with the specified path, handler, and dynamic middleware.
// *
// * @param array $methods The HTTP methods (e.g., GET, POST) to match
// * @param string $path The URL path pattern for the route
// * @param callable|string $handler The controller class and method or a callback function handling the route
// * @param string|null $method The method name if the handler is a controller class (optional)
// * @param array $middleware An associative array where keys are HTTP methods and values are middleware arrays
// * @return void
// */
//public static function match(array $methods, string $path, callable|string $handler, ?string $method = null, array $middleware = []): void
//{
//    $route = self::getInstance();
//
//    foreach ($methods as $httpMethod) {
//        $httpMethod = strtoupper($httpMethod);
//
//        // Check if there are specific middleware for this HTTP method
//        $methodMiddleware = $middleware[$httpMethod] ?? [];
//
//        if (is_callable($handler)) {
//            // Handle the case where $handler is a callable (function)
//            $route->addRoute($httpMethod, $path, $handler, null, $methodMiddleware);
//        } else {
//            // Handle the case where $handler is a controller class
//            $route->addRoute($httpMethod, $path, $handler, $method, $methodMiddleware);
//        }
//    }
//}
//
///**
// * Set Prefix
// *
// * Sets the prefix for the grouped routes.
// *
// * @param string|null $prefix The common prefix for the grouped routes
// * @return void
// */
//protected function setPrefix(?string $prefix): void
//{
//    $this->prefix = $prefix;
//}
