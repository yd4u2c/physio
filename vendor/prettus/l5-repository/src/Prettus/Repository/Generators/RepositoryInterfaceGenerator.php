language: php

sudo: false

matrix:
  include:
    - php: 5.4
    - php: 5.4
      env: 'COMPOSER_FLAGS="--prefer-lowest --prefer-stable"'
    - php: 5.5
    - php: 5.6
    - php: 7.0
    - php: 7.1
    - php: 7.2
    - php: hhvm
      dist: trusty
  allow_failures:
    - php: 5.4
      env: 'COMPOSER_FLAGS="--prefer-lowest --prefer-stable"'
    - php: hhvm
  fast_finish: true

install: travis_retry composer update --no-interaction $COMPOSER_FLAGS

script:
 - vendor/bin/phpunit --verbose --coverage-clover=coverage.xml
 - '[[ $TRAVIS_PHP_VERSION = 7.2* ]] && make build -j 4 || true'

after_success:
  - bash <(curl -s https://codecov.io/bash)

before_deploy: make dist -j 4

deploy:
  provider: releases
  api_key:
    secure: LL8koDM1xDqzF9t0URHvmMPyWjojyd4PeZ7IW7XYgyvD6n1H6GYrVAeKCh5wfUKFbwHoa9s5AAn6pLzra00bODVkPTmUH+FSMWz9JKLw9ODAn8HvN7C+IooxmeClGHFZc0TfHfya8/D1E9C1iXtGGEoE/GqtaYq/z0C1DLpO0OU=
  file_glob: true
  file: dist/psysh-*.tar.gz
  skip_cleanup: true
  on:
    tags: true
    repo: bobthecow/psysh
    condition: $TRAVIS_PHP_VERSION = 7.2*
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       