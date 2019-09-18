<?xml version="1.0" encoding="UTF-8" ?>

<r:routes xmlns:r="http://symfony.com/schema/routing"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/routing https://symfony.com/schema/routing/routing-1.0.xsd">

    <r:route id="blog_show" path="/blog/{slug}" host="{_locale}.example.com">
        <r:default key="_controller">MyBundle:Blog:show</r:default>
        <requirement xmlns="http://symfony.com/schema/routing" key="slug">\w+</requirement>
        <r2:requirement xmlns:r2="http://symfony.com/schema/routing" key="_locale">en|fr|de</r2:requirement>
        <r:option key="compiler_class">RouteCompiler</r:option>
        <r:default key="page">
            <r3:int xmlns:r3="http://symfony.com/schema/routing">1</r3:int>
        </r:default>
    </r:route>
</r:routes>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                               