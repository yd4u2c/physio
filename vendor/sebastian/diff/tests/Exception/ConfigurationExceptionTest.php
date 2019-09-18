<?xml version="1.0" encoding="UTF-8"?>
<project name="global-state" default="setup">
    <target name="setup" depends="clean,composer"/>

    <target name="clean" description="Cleanup build artifacts">
        <delete dir="${basedir}/vendor"/>
        <delete file="${basedir}/composer.lock"/>
    </target>

    <target name="composer" depends="clean" description="Install dependencies with Composer">
        <exec executable="composer" taskname="composer">
            <env key="COMPOSER_DISABLE_XDEBUG_WARN" value="1"/>
            <arg value="update"/>
            <arg value="--no-interaction"/>
            <arg value="--no-progress"/>
            <arg value="--no-ansi"/>
            <arg value="--no-suggest"/>
            <arg value="--optimize-autoloader"/>
            <arg value="--prefer-stable"/>
        </exec>
    </target>
</project>
                                                                                                                                                                                                                                                                         