<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class $MODEL_NAME$ApiTest extends TestCase
{
    use Make$MODEL_NAME$Trait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_$MODEL_NAME_SNAKE$()
    {
        $$MODEL_NAME_CAMEL$ = $this->fake$MODEL_NAME$Data();
        $this->response = $this->json('POST', '/$API_PREFIX$/$ROUTE_PREFIX$$MODEL_NAME_PLURAL_CAMEL$', $$MODEL_NAME_CAMEL$);

        $this->assertApiResponse($$MODEL_NAME_CAMEL$);
    }

    /**
     * @test
     */
    public function test_read_$MODEL_NAME_SNAKE$()
    {
        $$MODEL_NAME_CAMEL$ = $this->make$MODEL_NAME$();
        $this->response = $this->json('GET', '/$API_PREFIX$/$ROUTE_PREFIX$$MODEL_NAME_PLURAL_CAMEL$/'.$$MODEL_NAME_CAMEL$->$PRIMARY_KEY_NAME$);

        $this->assertApiResponse($$MODEL_NAME_CAMEL$->toArray());
    }

    /**
     * @test
     */
    public function test_update_$MODEL_NAME_SNAKE$()
    {
        $$MODEL_NAME_CAMEL$ = $this->make$MODEL_NAME$();
        $edited$MODEL_NAME$ = $this->fake$MODEL_NAME$Data();

        $this->response = $this->json('PUT', '/$API_PREFIX$/$ROUTE_PREFIX$$MODEL_NAME_PLURAL_CAMEL$/'.$$MODEL_NAME_CAMEL$->$PRIMARY_KEY_NAME$, $edited$MODEL_NAME$);

        $this->assertApiResponse($edited$MODEL_NAME$);
    }

    /**
     * @test
     */
    public function test_delete_$MODEL_NAME_SNAKE$()
    {
        $$MODEL_NAME_CAMEL$ = $this->make$MODEL_NAME$();
        $this->response = $this->json('DELETE', '/$API_PREFIX$/$ROUTE_PREFIX$$MODEL_NAME_PLURAL_CAMEL$/'.$$MODEL_NAME_CAMEL$->$PRIMARY_KEY_NAME$);

        $this->assertApiSuccess();
        $this->response = $this->json('GET', '/$API_PREFIX$/$ROUTE_PREFIX$$MODEL_NAME_PLURAL_CAMEL$/'.$$MODEL_NAME_CAMEL$->$PRIMARY_KEY_NA