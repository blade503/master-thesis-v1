<?php

namespace AppBundle\GraphQL\Type;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use GraphQL\Type\Definition\ScalarType;

class DateTimeType extends ScalarType implements AliasedInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getAliases()
    {
        return ['DateTime', 'Date'];
    }

    /**
     * @param \DateTime $value
     * @return mixed|string
     */
    public function serialize($value)
    {
        return $value->format('c');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function parseValue($value)
    {
        return new \DateTime($value);
    }

    /**
     * @param $valueNode
     * @return \DateTime
     */
    public function parseLiteral($valueNode)
    {
        return new \DateTime($valueNode->value);
    }
}