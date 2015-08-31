<?php
namespace StevenWadeJr\Exposure;

class Factory
{
    public static function expose($object)
    {
        $stub = file_get_contents(__DIR__ . '/Exposure.php');

        // Rename exposed class
        $className = '\\' . get_class($object);
        $newClassName = static::renameStub($className);
        $stub = static::extend($stub, $newClassName, $className);
        $stub = static::stripNamespace($stub);
        $stub = str_replace('<?php', '', $stub);

        eval($stub);

        $toInstantiate = '\\' . $newClassName;

        return new $toInstantiate($object);
    }

    public static function proxy($object)
    {
        $proxy = new Exposure($object);
    }

    protected static function extend($classContents, $newName, $toExtend)
    {
        return preg_replace(
            '/(class\s+)(\w+)(?:[\n?|\s?]?)(?={)/',
            sprintf(
                'class %s extends %s',
                $newName,
                $toExtend
            ),
            $classContents
        );
    }

    protected static function renameStub($className)
    {
        $rfc = new \ReflectionClass($className);

        return $rfc->getShortName() . '_Exposed';
    }

    protected static function stripNamespace($classContents)
    {
        return preg_replace('/(namespace\s[\w|\\\\]+;)/', '', $classContents);
    }
}
