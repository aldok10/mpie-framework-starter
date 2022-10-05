<?php

declare(strict_types=1);

namespace Psr\Http\Message {
    use App\Http\Response;
    use App\Http\ServerRequest;

    /**
     * @mixin ServerRequest
     */
    interface ServerRequestInterface
    {
    }

    /**
     * @mixin Response
     */
    interface ResponseInterface
    {
    }
}

namespace Psr\Container {
    use Mpie\Di\Container;

    /**
     * @mixin Container
     */
    interface ContainerInterface
    {
    }
}

namespace Psr\SimpleCache {
    use Mpie\Cache\Cache;

    /**
     * @mixin Cache
     */
    interface CacheInterface
    {
    }
}

namespace Psr\Log {
    use App\Logger;

    /**
     * @mixin Logger
     */
    interface LoggerInterface
    {
    }
}
