# Configuration

> %project% **does not need** a specific configuration, but it is necessary for some Bundles to have a configuration for
> "%project%" to work correctly.

> %project% comes with a Symfony Flex recipe in its own repository, which installs everything needed to run.

## Configure `idmarinas/flex-recipes`

```json
{
  "extra": {
    "symfony": {
      "endpoint": [
        "https://api.github.com/repos/idmarinas/flex-recipes/contents/index.json?ref=flex/master",
        "flex://defaults"
      ]
    }
  }
}
```

> The `extra.symfony` key will most probably already exist in your `composer.json`.
> In that case, add the `"endpoint"` key to the existing `extra.symfony` entry.
> {style=note}

> In case that `extra.symfony.entrypoint` already exist in your `composer.json` add
> `"https://api.github.com/repos/idmarinas/flex-recipes/contents/index.json?ref=flex/master"` to
`extra.symfony.entrypoint` array
> {style=note}
