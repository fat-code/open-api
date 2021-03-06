<?php declare(strict_types=1);

namespace FatCode\OpenApi\Annotation\Info;

use FatCode\Annotation\Target;

/**
 * @Annotation
 * @Target(Target::TARGET_ANNOTATION)
 */
class License
{
    /**
     * The license name used for the API.
     * @var string
     */
    public $name;

    /**
     * A URL to the license used for the API. MUST be in the format of a URL.
     * @var string
     */
    public $url;

    protected function getRequiredParameters(): array
    {
        return ['name'];
    }
}
