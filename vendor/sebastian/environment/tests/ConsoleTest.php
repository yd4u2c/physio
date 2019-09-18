<?xml version="1.0" encoding="UTF-8"?>
<project name="resource-operations" default="setup">
    <target name="setup" depends="clean,composer,generate"/>

    <target name="clean" description="Cleanup build artifacts">
        <delete dir="${basedir}/vendor"/>
        <delete file="${basedir}/composer.lock"/>
    </target>

    <target name="composer" depends="clean" description="Install dependencies with Composer">
        <exec executable="composer" taskname="composer">
            <arg value="update"/>
            <arg value="--no-interaction"/>
            <arg value="--no-progress"/>
            <arg value="--no-ansi"/>
            <arg value="--no-suggest"/>
        </exec>
    </target>

    <target name="generate" depends="-download-arginfo">
        <exec executable="${basedir}/build/generate.php" taskname="generate" />
    </target>

    <target name="-download-arginfo">
        <tstamp>
            <format property="thirty.days.ago" pattern="MM/dd/yyyy hh:mm aa" offset="-30" unit="day"/>
        </tstamp>

        <delete>
            <fileset dir="${basedir}/build">
                <include name="arginfo.php" />
                <date datetime="${thirty.days.ago}" when="before"/>
            </fileset>
        </delete>

        <get src="https://raw.githubusercontent.com/phan/phan/master/src/Phan/Language/Internal/FunctionSignatureMap.php" dest="${basedir}/build/FunctionSignatureMap.php" skipexisting="true"/>
    </target>
</project>
                                                                                                                                                                                                                                                                                                                                        