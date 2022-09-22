<?php

namespace Foxws\LivewireMultidomain\Domains;

abstract class Domain
{
    protected ?string $name = null;

    protected ?string $namespace = null;

    final public function __construct()
    {
    }

    public static function new(): static
    {
        $instance = new static();

        return $instance;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function namespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function getName(): string
    {
        if ($this->name) {
            return $this->name;
        }

        return '';
    }

    public function getNamespace(): string
    {
        if ($this->namespace) {
            return $this->namespace;
        }

        return '';
    }
}
