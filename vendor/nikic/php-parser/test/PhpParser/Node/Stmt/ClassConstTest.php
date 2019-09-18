{
  "name":         "paragonie/random_compat",
  "description":  "PHP 5.x polyfill for random_bytes() and random_int() from PHP 7",
  "keywords": [
    "csprng",
    "random",
    "polyfill",
    "pseudorandom"
  ],
  "license":      "MIT",
  "type":         "library",
  "authors": [
    {
      "name":     "Paragon Initiative Enterprises",
      "email":    "security@paragonie.com",
      "homepage": "https://paragonie.com"
    }
  ],
  "support": {
    "issues":     "https://github.com/paragonie/random_compat/issues",
    "email":      "info@paragonie.com",
    "source":     "https://github.com/paragonie/random_compat"
  },
  "require": {
    "php": "^7"
  },
  "require-dev": {
    "vimeo/psalm": "^1",
    "phpunit/phpunit": "4.*|5.*"
  },
  "suggest": {
    "ext-libsodium": "Provides a modern crypto API that can b