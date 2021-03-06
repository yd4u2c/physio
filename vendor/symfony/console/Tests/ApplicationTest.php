My Symfony application <info>v1.0</info>

<comment>Usage:</comment>
  command [options] [arguments]

<comment>Options:</comment>
  <info>-h, --help</info>            Display this help message
  <info>-q, --quiet</info>           Do not output any message
  <info>-V, --version</info>         Display this application version
  <info>    --ansi</info>            Force ANSI output
  <info>    --no-ansi</info>         Disable ANSI output
  <info>-n, --no-interaction</info>  Do not ask any interactive question
  <info>-v|vv|vvv, --verbose</info>  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

<comment>Available commands:</comment>
  <info>help</info>                 Displays help for a command
  <info>list</info>                 Lists commands
 <comment>descriptor</comment>
  <info>descriptor:command1</info>  [alias1|alias2] command 1 description
  <info>descriptor:command2</info>  command 2 description
  <info>descriptor:command4</info>  [descriptor:alias_command4|command4:descriptor]
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?xml version="1.0" encoding="UTF-8"?>
<symfony name="My Symfony application" version="v1.0">
  <commands>
    <command id="help" name="help" hidden="0">
      <usages>
        <usage>help [--format FORMAT] [--raw] [--] [&lt;command_name&gt;]</usage>
      </usages>
      <description>Displays help for a command</description>
      <help>The &lt;info&gt;help&lt;/info&gt; command displays help for a given command:
 
   &lt;info&gt;php app/console help list&lt;/info&gt;
 
 You can also output the help in other formats by using the &lt;comment&gt;--format&lt;/comment&gt; option:
 
   &lt;info&gt;php app/console help --format=xml list&lt;/info&gt;
 
 To display the list of available commands, please use the &lt;info&gt;list&lt;/info&gt; command.</help>
      <arguments>
        <argument name="command_name" is_required="0" is_array="0">
          <description>The command name</description>
          <defaults>
            <default>help</default>
          </defaults>
        </argument>
      </arguments>
      <options>
        <option name="--format" shortcut="" accept_value="1" is_value_required="1" is_multiple="0">
          <description>The output format (txt, xml, json, or md)</description>
          <defaults>
            <default>txt</default>
          </defaults>
        </option>
        <option name="--raw" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>To output raw command help</description>
        </option>
        <option name="--help" shortcut="-h" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this help message</description>
        </option>
        <option name="--quiet" shortcut="-q" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not output any message</description>
        </option>
        <option name="--verbose" shortcut="-v" shortcuts="-v|-vv|-vvv" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug</description>
        </option>
        <option name="--version" shortcut="-V" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this application version</description>
        </option>
        <option name="--ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Force ANSI output</description>
        </option>
        <option name="--no-ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Disable ANSI output</description>
        </option>
        <option name="--no-interaction" shortcut="-n" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not ask any interactive question</description>
        </option>
      </options>
    </command>
    <command id="list" name="list" hidden="0">
      <usages>
        <usage>list [--raw] [--format FORMAT] [--] [&lt;namespace&gt;]</usage>
      </usages>
      <description>Lists commands</description>
      <help>The &lt;info&gt;list&lt;/info&gt; command lists all commands:
 
   &lt;info&gt;php app/console list&lt;/info&gt;
 
 You can also display the commands for a specific namespace:
 
   &lt;info&gt;php app/console list test&lt;/info&gt;
 
 You can also output the information in other formats by using the &lt;comment&gt;--format&lt;/comment&gt; option:
 
   &lt;info&gt;php app/console list --format=xml&lt;/info&gt;
 
 It's also possible to get raw list of commands (useful for embedding command runner):
 
   &lt;info&gt;php app/console list --raw&lt;/info&gt;</help>
      <arguments>
        <argument name="namespace" is_required="0" is_array="0">
          <description>The namespace name</description>
          <defaults/>
        </argument>
      </arguments>
      <options>
        <option name="--raw" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>To output raw command list</description>
        </option>
        <option name="--format" shortcut="" accept_value="1" is_value_required="1" is_multiple="0">
          <description>The output format (txt, xml, json, or md)</description>
          <defaults>
            <default>txt</default>
          </defaults>
        </option>
      </options>
    </command>
    <command id="descriptor:command1" name="descriptor:command1" hidden="0">
      <usages>
        <usage>descriptor:command1</usage>
        <usage>alias1</usage>
        <usage>alias2</usage>
      </usages>
      <description>command 1 description</description>
      <help>command 1 help</help>
      <arguments/>
      <options>
        <option name="--help" shortcut="-h" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this help message</description>
        </option>
        <option name="--quiet" shortcut="-q" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not output any message</description>
        </option>
        <option name="--verbose" shortcut="-v" shortcuts="-v|-vv|-vvv" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug</description>
        </option>
        <option name="--version" shortcut="-V" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this application version</description>
        </option>
        <option name="--ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Force ANSI output</description>
        </option>
        <option name="--no-ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Disable ANSI output</description>
        </option>
        <option name="--no-interaction" shortcut="-n" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not ask any interactive question</description>
        </option>
      </options>
    </command>
    <command id="descriptor:command2" name="descriptor:command2" hidden="0">
      <usages>
        <usage>descriptor:command2 [-o|--option_name] [--] &lt;argument_name&gt;</usage>
        <usage>descriptor:command2 -o|--option_name &lt;argument_name&gt;</usage>
        <usage>descriptor:command2 &lt;argument_name&gt;</usage>
      </usages>
      <description>command 2 description</description>
      <help>command 2 help</help>
      <arguments>
        <argument name="argument_name" is_required="1" is_array="0">
          <description></description>
          <defaults/>
        </argument>
      </arguments>
      <options>
        <option name="--option_name" shortcut="-o" accept_value="0" is_value_required="0" is_multiple="0">
          <description></description>
        </option>
        <option name="--help" shortcut="-h" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this help message</description>
        </option>
        <option name="--quiet" shortcut="-q" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not output any message</description>
        </option>
        <option name="--verbose" shortcut="-v" shortcuts="-v|-vv|-vvv" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug</description>
        </option>
        <option name="--version" shortcut="-V" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this application version</description>
        </option>
        <option name="--ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Force ANSI output</description>
        </option>
        <option name="--no-ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Disable ANSI output</description>
        </option>
        <option name="--no-interaction" shortcut="-n" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not ask any interactive question</description>
        </option>
      </options>
    </command>
    <command id="descriptor:command3" name="descriptor:command3" hidden="1">
      <usages>
        <usage>descriptor:command3</usage>
      </usages>
      <description>command 3 description</description>
      <help>command 3 help</help>
      <arguments/>
      <options>
        <option name="--help" shortcut="-h" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this help message</description>
        </option>
        <option name="--quiet" shortcut="-q" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not output any message</description>
        </option>
        <option name="--verbose" shortcut="-v" shortcuts="-v|-vv|-vvv" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug</description>
        </option>
        <option name="--version" shortcut="-V" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this application version</description>
        </option>
        <option name="--ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Force ANSI output</description>
        </option>
        <option name="--no-ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Disable ANSI output</description>
        </option>
        <option name="--no-interaction" shortcut="-n" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not ask any interactive question</description>
        </option>
      </options>
    </command>
    <command id="descriptor:command4" name="descriptor:command4" hidden="0">
      <usages>
        <usage>descriptor:command4</usage>
        <usage>descriptor:alias_command4</usage>
        <usage>command4:descriptor</usage>
      </usages>
      <description></description>
      <help></help>
      <arguments/>
      <options>
        <option name="--help" shortcut="-h" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this help message</description>
        </option>
        <option name="--quiet" shortcut="-q" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not output any message</description>
        </option>
        <option name="--verbose" shortcut="-v" shortcuts="-v|-vv|-vvv" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug</description>
        </option>
        <option name="--version" shortcut="-V" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Display this application version</description>
        </option>
        <option name="--ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Force ANSI output</description>
        </option>
        <option name="--no-ansi" shortcut="" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Disable ANSI output</description>
        </option>
        <option name="--no-interaction" shortcut="-n" accept_value="0" is_value_required="0" is_multiple="0">
          <description>Do not ask any interactive question</description>
        </option>
      </options>
    </command>
  </commands>
  <namespaces>
    <namespace id="_global">
      <command>alias1</command>
      <command>alias2</command>
      <command>help</command>
      <command>list</command>
    </namespace>
    <namespace id="command4">
      <command>command4:descriptor</command>
    </namespace>
    <namespace id="descriptor">
      <command>descriptor:alias_command4</command>
      <command>descriptor:command1</command>
      <command>descriptor:command2</command>
      <command>descriptor:command3</command>
      <command>descriptor:command4</command>
    </namespace>
  </namespaces>
</symfony>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               My Symfony application <info>v1.0</info>

<comment>Usage:</comment>
  command [options] [arguments]

<comment>Options:</comment>
  <info>-h, --help</info>            Display this help message
  <info>-q, --quiet</info>           Do not output any message
  <info>-V, --version</info>         Display this application version
  <info>    --ansi</info>            Force ANSI output
  <info>    --no-ansi</info>         Disable ANSI output
  <info>-n, --no-interaction</info>  Do not ask any interactive question
  <info>-v|vv|vvv, --verbose</info>  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

<comment>Available commands for the "command4" namespace:</comment>
  <info>command4:descriptor</info>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  MbString åpplicätion
====================

* [`help`](#help)
* [`list`](#list)

**descriptor:**

* [`descriptor:åèä`](#descriptoråèä)

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
* Is multiple: no
* Default: `false`

#### `--no-ansi`

Disable ANSI output

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`

#### `--no-interaction|-n`

Do not ask any interactive question

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`

`list`
------

Lists commands

### Usage

* `list [--raw] [--format FORMAT] [--] [<namespace>]`

The list command lists all commands:

  php app/console list

You can also display the commands for a specific namespace:

  php app/console list test

You can also output the information in other formats by using the --format option:

  php app/console list --format=xml

It's also possible to get raw list of commands (useful for embedding command runner):

  php app/console list --raw

### Arguments

#### `namespace`

The namespace name

* Is required: no
* Is array: no
* Default: `NULL`

### Options

#### `--raw`

To output raw command list

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`

#### `--format`

The output format (txt, xml, json, or md)

* Accept value: yes
* Is value required: yes
* Is multiple: no
* Default: `'txt'`

`descriptor:åèä`
----------------

command åèä description

### Usage

* `descriptor:åèä [-o|--option_åèä] [--] <argument_åèä>`
* `descriptor:åèä -o|--option_name <argument_name>`
* `descriptor:åèä <argument_name>`

command åèä help

### Arguments

#### `argument_åèä`

* Is required: yes
* Is array: no
* Default: `NULL`

### Options

#### `--option_åèä|-o`

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
* Is multiple: no
* Default: `false`

#### `--no-ansi`

Disable ANSI output

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`

#### `--no-interaction|-n`

Do not ask any interactive question

* Accept value: no
* Is value required: no
* Is multiple: no
* Default: `false`
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    MbString åpplicätion

<comment>Usage:</comment>
  command [options] [arguments]

<comment>Options:</comment>
  <info>-h, --help</info>            Display this help message
  <info>-q, --quiet</info>           Do not output any message
  <info>-V, --version</info>         Display this application version
  <info>    --ansi</info>            Force ANSI output
  <info>    --no-ansi</info>         Disable ANSI output
  <info>-n, --no-interaction</info>  Do not ask any interactive question
  <info>-v|vv|vvv, --verbose</info>  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

<comment>Available commands:</comment>
  <info>help</info>            Displays help for a command
  <info>list</info>            Lists commands
 <comment>descriptor</comment>
  <info>descriptor:åèä</info>  command åèä description
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
[33mIn Foo3Command.php line 26:[39m
[37;41m                                              [39;49m
[37;41m  Third exception <fg=blue;bg=red>comment</>  [39;49m
[37;41m                                              [39;49m

[33mIn Foo3Command.php line 23:[39m
[37;41m                                               [39;49m
[37;41m  Second exception <comment>comment</comment>  [39;49m
[37;41m                                               [39;49m

[33mIn Foo3Command.php line 21:[39m
[37;41m                                       [39;49m
[37;41m  First exception <p>this is html</p>  [39;49m
[37;41m                                       [39;49m

[32mfoo3:bar[39m

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 INDX( 	 c6�            (   �  �       e p �m ��         �,     � �     s,     p|�pk� rX�Y���,���<�p|�pk��       �                 a p p l i c a t i o n _ r e n d e r e x c e p t i o n 4 . t x t       �,     � �     s,     /��pk� rX�Y��@����<�/��pk�p       n               , a p p l i c a t i o n _ r e n d e r e x c e p t i o n _ d o u b l e w i d t h 1 . t x t       �,     � �     s,     F@�pk� rX�Y��@����<�F@�pk��       �               5 a p p l i c a t i o n _ r e n d e r  x c e p t i o n _ d o u b l e w i d t h 1 d e c o r a t e d . t x t     �,     � �     s,     �� �pk� rX�Y�������<��� �pk��       �               , a p p l i c a t i o n _ r e n d e r e x c e p t i o n _ d o u b l e w i d t h 2 . t x t       �,     � �     s,     �#�pk� rX�Y���T���<��#�pk��                      , a p p l i c a t i o n _ r e n d e r e x c e p t i o n _ e s c a p e s l i n e s . t x t       �,     � �     s,     \g%�pk� rX�Y��L����<�\g%�pk�                    * a p  l i c a t i o n _ r e n d e r e x c e p t i o n _ l i n e b r e a k s . t x t   �,     � j     s,     ��'�pk� rX�Y��L����<���'�pk�@      9               a p p l i c a t i o n _ r u n 1 . t x t       �,     � j     s,     :�,�pk� rX�Y������<�:�,�pk��      �               a p p l i c a t i o n _ r u n 2 . t x t       �,     � j     s,     :�,�pk� rX�Y���z���<�:�,�pk��      �               a p p l i c a t i o n _ r u n 3 . t x t       �,     � j     s,     ��.�pk� rX�Y�������< ��.�pk�                       a p p l i c a t i o n _ r u n 4 . t x t       �,     x d     s,     ��3�pk� rX�Y�������<���3�pk��       �                B a r B u c C o m m a n d . p h p     �,     p ^     s,     �6�pk� rX�Y���@��<��6�pk�(      '               c o m m a n d _ 1 . j s o n   �,     p Z     s,     Iz8�pk� rX�Y�����<�Iz8�pk��       �                c o m m a n d _ 1 . m d                     s,     �?=�pk� rX�Y��r��<��?=�pk��       �                c o  m a n d _ 1 . t x t     �,     p \     s,     �?�pk� rX�Y���f��<��?�pk�`      Z               c o m m a n d _ 1 . x m l     �,     p ^     s,     �eD�pk� rX�Y���f��<��eD�pk�       �               c o m m a n d _ 2 . j s o n   �,     p Z     s,     )�F�pk� rX�Y��:�
��<�)�F�pk��      �               c o m m a n d _ 2 . m d       �,     p \     s,     ��M�pk� rX�Y���+��<���M�pk��      �               c o m m a n d _ 2 . t x t     �,     p \     s,     �U�pk� rX�Y� �+��<��U�pk�                      c o m m a n d _ 2 . x m l     �,     x h     s,     	yW�pk� rX�Y�����<�	yW�pk��      �               c o m m a n d _ m b s t r i n g . m d �,     � j     s,     �=\�pk� rX�Y��E���<��=\�pk��      �               c o m m a n d _ m b s t r i n g . t x t       �,     � v     s,     �dc�pk� rX�Y���R��<��dc�pk��      �               D e s c r i p t o r A p p l i c a t i o n 1 . p h p   �,     � v     s,     )h�pk� rX�Y�����<�)h�pk �      �               D e s c r i p t o r A p p l i c a t i o n 2 . p h p   �,     � �     s,     ��j�pk� rX�Y���8��<���j�pk�(      &              ! D e s c r i p t o r A p p l i c a t i o n M b S t r i n g . p h p     �,     � n     s,     �l�pk� rX�Y���8��<��l�pk��      �               D e s c r i p t o r C o m m a n d 1 . p h p   �,     � n     s,     ϲq�pk� rX�Y��Rx:��<�ϲq�pk�       �               D e s c r i p t o r C o m m a n d 2 . p h p   �,     � n     s,     �wv�pk� rX�Y��Rx:��<��wv�pk�p      p               D e s c r i p t o r C o m m a n d 3 . p h p   �,     � n     s,     z�x�pk� rX�Y����<��<�z�x�pk�H      C               D e s c r i p t o r C o m m a n d 4 . p h p   �,     � |     s,     ��}�pk� rX�Y��=?��<���}�pk�       �               D e s c r i p t o r C o m m a n d M b S t r i n g . p h p     �,     p `     s,     Od��pk� rX�Y��ԟA��<�Od��pk�                      D u m m y O u t p u t . p h p                      {
    "name": "descriptor:command2",
    "hidden": false,
    "usage": [
        "descriptor:command2 [-o|--option_name] [--] <argument_name>",
        "descriptor:command2 -o|--option_name <argument_name>",
        "descriptor:command2 <argument_name>"
    ],
    "description": "command 2 description",
    "help": "command 2 help",
    "definition": {
        "arguments": {
            "argument_name": {
                "name": "argument_name",
                "is_required": true,
                "is_array": false,
                "description": "",
                "default": null
            }
        },
        "options": {
            "option_name": {
                "name": "--option_name",
                "shortcut": "-o",
                "accept_value": false,
                "is_value_required": false,
                "is_multiple": false,
                "description": "",
                "default": false
            }
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?xml version="1.0" encoding="UTF-8"?>
<command id="descriptor:command2" name="descriptor:command2" hidden="0">
  <usages>
    <usage>descriptor:command2 [-o|--option_name] [--] &lt;argument_name&gt;</usage>
    <usage>descriptor:command2 -o|--option_name &lt;argument_name&gt;</usage>
    <usage>descriptor:command2 &lt;argument_name&gt;</usage>
  </usages>
  <description>command 2 description</description>
  <help>command 2 help</help>
  <arguments>
    <argument name="argument_name" is_required="1" is_array="0">
      <description></description>
      <defaults/>
    </argument>
  </arguments>
  <options>
    <option name="--option_name" shortcut="-o" accept_value="0" is_value_required="0" is_multiple="0">
      <description></description>
    </option>
  </options>
</command>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Fixtures;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DescriptorCommand2 extends Command
{
    protected function configure()
    {
        $this
            ->setName('descriptor:command2')
            ->setDescription('command 2 description')
            ->setHelp('command 2 help')
            ->addUsage('-o|--option_name <argument_name>')
            ->addUsage('<argument_name>')
            ->addArgument('argument_name', InputArgument::REQUIRED)
            ->addOption('option_name', 'o', InputOption::VALUE_NONE)
        ;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Fixtures;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DescriptorCommandMbString extends Command
{
    protected function configure()
    {
        $this
            ->setName('descriptor:åèä')
            ->setDescription('command åèä description')
            ->setHelp('command åèä help')
            ->addUsage('-o|--option_name <argument_name>')
            ->addUsage('<argument_name>')
            ->addArgument('argument_åèä', InputArgument::REQUIRED)
            ->addOption('option_åèä', 'o', InputOption::VALUE_NONE)
        ;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Fixtures;

use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Dummy output.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DummyOutput extends BufferedOutput
{
    /**
     * @return array
     */
    public function getLogs()
    {
        $logs = [];
        foreach (explode(PHP_EOL, trim($this->fetch())) as $message) {
            preg_match('/^\[(.*)\] (.*)/', $message, $matches);
            $logs[] = sprintf('%s %s', $matches[1], $matches[2]);
        }

        return $logs;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   INDX( 	 (J�            (   �  �           a u �m e         �,     p \     s,     �?�pk� rX�Y���f��<��?�pk�`      Z               c o m m a n d _ 1 . x m l     �,     p ^     s,     �eD�pk� rX�Y���f��<��eD�pk�       �               c o m m a n d _ 2 . j s o n   �,     p Z     s,     )�F�pk� rX�Y��:�
��<�)�F�pk��      �               c o m m a n d _ 2 . m d       �,     p \     s,     ��M�pk� rX�Y���+��<���M�pk��      �               c o m m a n d _ 2 . t x t    �,     p \     s,     �U�pk� rX�Y���+��<��U�pk�                      c o m m a n d _ 2 . x m l     �,     x h     s,     	yW�pk� rX�Y�����<�	yW�pk��      �               c o m m a n d _ m b s t r i n g . m d �,     � j     s,     �=\�pk� rX�Y��E���<��=\�pk��      �               c o m m a n d _ m b s t r i n g . t x t       �,     � v     s,     �dc�pk� rX�Y���R��<��dc�pk��      �               D e s c r i p t o r A p p l i c a t i o n 1 . p h p   �,     � v    s,     )h�pk� rX�Y�����<�)h�pk��      �               D e s c r i p t o r A p p l i c a t i o n 2 . p h p   �,     � �     s,     ��j�pk� rX�Y���8��<���j�pk�(      &              ! D e s c r i p t o r A p p l i c a t i o n M b S t r i n g . p h p     �,     � n     s,     �l�pk� rX�Y���8��<��l�pk��      �               D e s c r i p t o r C o m m a n d 1 . p h p   �,     � n     s,     ϲq�pk� rX�Y��Rx:��<�ϲq�pk�       �               D e s c r i p t o r C o m m  n d 2 . p h p   �,     � n     s,     �wv�pk� rX�Y��Rx:��<��wv�pk�p      p               D e s c r i p t o r C o m m a n d 3 . p h p   �,     � n     s,     z�x�pk� rX�Y����<��<�z�x�pk�H      C               D e s c r i p t o r C o m m a n d 4 . p h p   �,     � |     s,     ��}�pk� rX�Y��=?��<���}�pk�       �               D e s c r i p t o r C o m m a n d M b S t r i n g . p h p                   s,     Od��pk� rX�Y��ԟA��<�Od��pk�                      D u m m y O  t p u t . p h p �,     p `     s,     (��pk� rX�Y��ԟA��<�(��pk�P      P               F o o 1 C o m m a n d . p h p �,     p `     s,     ���pk� rX�Y���D��<����pk��      �               F o o 2 C o m m a n d . p h p �,     p `     s,     M���pk� rX�Y��NdF��<�M���pk�       C               F o o 3 C o m m a n d . p h p �,     p `     s,     `v��pk� rX�Y��NdF��<�`v��pk��       �                F o o 4 C o m m a n d . p h p �,     p `     s,     hٗ�pk� rX�Y���H��< hٗ�pk��       �                F o o 5 C o m m a n d . p h p �,     p `     s,     �:��pk� rX�Y���(K��<��:��pk��       �                F o o 6 C o m m a n d . p h p �,     x d     s,     H���pk� rX�Y��,�M��<�H���pk�0      /               F o o b a r C o m m a n d . p h p     �,     p ^     s,     ^ģ�pk� rX�Y����O��<�^ģ�pk�       �               F o o C o m m a n d . p h p   �,     x h     s,     ���pk� rX�Y����O��<����pk�h      e               F o o L o c k 2 C o  m a n d . p h p �,     x f     s,     �M��pk� rX�Y���OR��<��M��pk�8      2               F o o L o c k C o m m a n d . p h p   �,     x d     s,     �t��pk� rX�Y����T��<��t��pk�       �               F o o O p t C o m m a n d . p h p     �,     � �     s,     ׶�pk� rX�Y����T��<�׶�pk��       �                F o o S a m e C a s e L o w e r c a s e C o m m a n d . p h p �,     � �     s,     W���pk� rX�Y���W��<�W���pk��       �                F o o S a m e C a s e U p p  r c a s e C o m m a n d . p h p �,     � z     s,     w%��pk� rX�Y���vY��<�w%��pk�h      d               F o o S u b n a m e s p a c e d 1 C o m m a n d . p h p       �,     � z     s,     ���pk� rX�Y���vY��<����pk�h      b               F o o S u b n a m e s p a c e d 2 C o m m a n d . p h p       �,     � v     s,     xL��pk� rX�Y��H�[��<�xL��pk��      �               F o o W i t h o u t A l i a s C o m m a n d . p h p                                                        <?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Foo3Command extends Command
{
    protected function configure()
    {
        $this
            ->setName('foo3:bar')
            ->setDescription('The foo3:bar command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            try {
                throw new \Exception('First exception <p>this is html</p>');
            } catch (\Exception $e) {
                throw new \Exception('Second exception <comment>comment</comment>', 0, $e);
            }
        } catch (\Exception $e) {
            throw new \Exception('Third exception <fg=blue;bg=red>comment</>', 404, $e);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FooCommand extends Command
{
    public $input;
    public $output;

    protected function configure()
    {
        $this
            ->setName('foo:bar')
            ->setDescription('The foo:bar command')
            ->setAliases(['afoobar'])
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('interact called');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $output->writeln('called');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FooOptCommand extends Command
{
    public $input;
    public $output;

    protected function configure()
    {
        $this
            ->setName('foo:bar')
            ->setDescription('The foo:bar command')
            ->setAliases(['afoobar'])
            ->addOption('fooopt', 'fo', InputOption::VALUE_OPTIONAL, 'fooopt description')
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('interact called');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $output->writeln('called');
        $output->writeln($this->input->getOption('fooopt'));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               