lse,
                        "is_multiple": false,
                        "description": "Disable ANSI output",
                        "default": false
                    },
                    "no-interaction": {
                        "name": "--no-interaction",
                        "shortcut": "-n",
                        "accept_value": false,
                        "is_value_required": false,
                        "is_multiple": false,
                        "description": "Do not ask any interactive question",
                        "default": false
                    }
                }
            }
        },
        {
            "name": "list",
            "hidden": false,
            "usage": [
                "list [--raw] [--format FORMAT] [--] [<namespace>]"
            ],
            "description": "Lists commands",
            "help": "The <info>list<\/info> command lists all commands:\n\n  <info>php app\/console list<\/info>\n\nYou can also display the commands for a specific namespace:\n\n  <info>php app\/console list test<\/info>\n\nYou can also output the information in other formats by using the <comment>--format<\/comment> option:\n\n  <info>php app\/console list --format=xml<\/info>\n\nIt's also possible to get raw list of commands (useful for embedding command runner):\n\n  <info>php app\/console list --raw<\/info>",
            "definition": {
                "arguments": {
                    "namespace": {
                        "name": "namespace",
                        "is_required": false,
                        "is_array": false,
                        "description": "The namespace name",
                        "default": null
                    }
                },
                "options": {
                    "raw": {
                        "name": "--raw",
                        "shortcut": "",
                        "accept_value": false,
                        "is_value_required": false,
                        "is_multiple": false,
                        "description": "To output raw command list",
                        "default": false
                    },
                    "format": {
                        "name": "--format",
                        "shortcut": "",
                        "accept_value": true,
                        "is_value_required": true,
                        "is_multiple": false,
                        "description": "The output format (txt, xml, json, or md)",
                        "default": "txt"
                    }
                }
            }
        }
    ],
    "namespaces": [
        {
            "id": "_global",
            "commands": [
                "help",
                "list"
            ]
        }
    ]
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Console Tool
============

* [`help`](#help)
* [`list`](#list)

`help`
------

Displays help for a command

### Usage

* `help [--format FORMAT] [--raw] [--] [<command_name>]`

The help command displays help for a given command:

  php app/console help list

You can also output the help in other formats by using the --format option:

  php app/console help --format=xml list

To display the list of available commands, please use the list command.

### Arguments

#### `command_name`

The command name

* Is required: no
* Is array: no
* Default: `'help'`

### Options

#### `--format`

The output format (txt, xml, json, or md)

* Accept value: yes
* Is value required: yes
* Is multiple: no
* Default: `'txt'`

#### `--raw`

To output raw command help

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`

#### `--help|-h`

Display this help message

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`

#### `--quiet|-q`

Do not output any message

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`

#### `--verbose|-v|-vv|-vvv`

Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`

#### `--version|-V`

Display this application version

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`

#### `--ansi`

Force ANSI output

* Accept value: no
* Is value required: no
* Is 