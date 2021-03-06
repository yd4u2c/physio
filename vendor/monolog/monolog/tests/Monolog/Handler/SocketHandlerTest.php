on-1-dev-version-1next)).

If you're the owner of a library that strongly depends on Carbon, we recommend you to run unit tests daily requiring
`"nesbot/carbon": "dev-master"` (for `^2`) or `"nesbot/carbon": "dev-version-1.next"` (for `^1`), this way you can
detect incompatibilities earlier and report it to us before we tag a release. We'll pay attention and try to fix it to
make update to next minor releases as soft as possible.

We reserve the right to publish emergency patches within 24 hours after a release if a tag that does not respect
this pattern would have been released despite our vigilance. In this very rare and particular case, we would mark the
tag as broken on GitHub and backward compatibility would be based on previous stable tag.

Last, you must understand that Carbon extends PHP natives classes, that means Carbon can be impacted by any change
that occurs in the date/time API of PHP. We watch new PHP versions and handle those changes as quickly as possible
when detected, but as PHP does not follow the semantic versioning pattern, it basically means any releases (including
patches) can have unexpected consequences on Carbon methods results.

### Long term support

To benefit the better support, require Carbon using major version range (`^1` or `^2`). By requiring `1.26.*`,
`~1.26.0` or limited range such as `>=1.20 <1.33`, you fall to low priority support (only security and critical issues
will be fixed), our prior support goes to next minor releases of each major version. It applies to bug fixes and
low-cost features. Other new features will only be added in the last stable release. At the opposite, we recommend you
to restrain to a major number, as there is no compatibility guarantee from a major version to the next. It means
requiring `>=2`, as it allows any newer version, will probably leads to errors on releasing our next major version.

Open milestones can be patched if a minor bug is detected while if you're on a closed milestone, we'll more likely
ask you to update first to an open one. See currently open milestones: 

https://github.com/briannesbitt/Carbon/milestones
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Copyright (C) Brian Nesbitt

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?xml version="1.0"?>
<ruleset name="Mess detection rules for Carbon"
         xmlns="http://pmd.sf.net/ruleset/1.0.0"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://pmd.sf.net/ruleset/1.0.0
                     http://pmd.sf.net/ruleset_xml_schema.xsd"
         xsi:noNamespaceSchemaLocation="
                     http://pmd.sf.net/ruleset_xml_schema.xsd">
    <description>
        Mess detection rules for Carbon
    </description>
    <rule ref="rulesets/codesize.xml" />
    <rule ref="rulesets/cleancode.xml" />
    <rule ref="rulesets/controversial.xml" />
    <rule ref="rulesets/design.xml" />
    <rule ref="rulesets/naming.xml/ShortVariable">
        <properties>
            <property name="exceptions" value="id,tz" />
        </properties>
    </rule>
    <rule ref="rulesets/unusedcode.xml" />
</ruleset>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           