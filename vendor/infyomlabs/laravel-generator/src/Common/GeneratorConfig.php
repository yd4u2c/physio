<?php

namespace $NAMESPACE_CONTROLLER$;

use $NAMESPACE_DATATABLES$\$MODEL_NAME$DataTable;
use $NAMESPACE_REQUEST$;
use $NAMESPACE_REQUEST$\Create$MODEL_NAME$Request;
use $NAMESPACE_REQUEST$\Update$MODEL_NAME$Request;
use $NAMESPACE_REPOSITORY$\$MODEL_NAME$Repository;
use Flash;
use $NAMESPACE_APP$\Http\Controllers\AppBaseController;
use Response;

class $MODEL_NAME$Controller extends AppBaseController
{
    /** @var  $MODEL_NAME$Repository */
    private $$MODEL_NAME_CAMEL$Repository;

    public function __construct($MODEL_NAME$Repository $$MODEL_NAME_CAMEL$Repo)
    {
        $this->$MODEL_NAME_CAMEL$Repository = $$MODEL_NAME_CAMEL$Repo;
    }

    /**
     * Display a listing of the $MODEL_NAME$.
     *
     * @param $MODEL_NAME$DataTable $$MODEL_NAME_CAMEL$DataTable
     * @return Response
     */
    public function index($MODEL_NAME$DataTable $$MODEL_NAME_CAMEL$DataTable)
    {
        return $$MODEL_NAME_CAMEL$DataTable->render('$VIEW_PREFIX$$MODEL_NAME_PLURAL_SNAKE$.index');
    }

    /**
     * Show the form for creating a new $MODEL_NAME$.
     *
     * @return Response
     */
    public function create()
    {
        return view('$VIEW_PREFIX$$MODEL_NAME_PLURAL_SNAKE$.create');
    }

    /**
     * Store a newly created $MODEL_NAME$ in storage.
     *
     * @param Create$MODEL_NAME$Request $request
     *
     * @return Response
     */
    public function store(Create$MODEL_NAME$Request $request)
    {
        $input = $request->all();

        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->create($input);

        Flash::success('$MODEL_NAME_HUMAN$ saved successfully.');

        return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
    }

    /**
     * Display the specified $MODEL_NAME$.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            Flash::error('$MODEL_NAME_HUMAN$ not found');

            return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
        }

        return view('$VIEW_PREFIX$$MODEL_NAME_PLURAL_SNAKE$.show')->with('$MODEL_NAME_CAMEL$', $$MODEL_NAME_CAMEL$);
    }

    /**
     * Show the form for editing the specified $MODEL_NAME$.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            Flash::error('$MODEL_NAME_HUMAN$ not found');

            return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
        }

        return view('$VIEW_PREFIX$$MODEL_NAME_PLURAL_SNAKE$.edit')->with('$MODEL_NAME_CAMEL$', $$MODEL_NAME_CAMEL$);
    }

    /**
     * Update the specified $MODEL_NAME$ in storage.
     *
     * @param  int              $id
     * @param Update$MODEL_NAME$Request $request
     *
     * @return Response
     */
    public function update($id, Update$MODEL_NAME$Request $request)
    {
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            Flash::error('$MODEL_NAME_HUMAN$ not found');

            return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
        }

        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->update($request->all(), $id);

        Flash::success('$MODEL_NAME_HUMAN$ updated successfully.');

        return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
    }

    /**
     * Remove the specified $MODEL_NAME$ from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            Flash::error('$MODEL_NAME_HUMAN$ not found');

            return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
        }

        $this->$MODEL_NAME_CAMEL$Repository->delete($id);

        Flash::success('$MODEL_NAME_HUMAN$ deleted successfully.');

        return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php namespace $NAMESPACE_TESTS$;

trait ApiTestTrait
{
    private $response;
    public function assertApiResponse(Array $actualData)
    {
        $this->assertApiSuccess();

        $response = json_decode($this->response->getContent(), true);
        $responseData = $response['data'];

        $this->assertNotEmpty($responseData['id']);
        $this->assertModelData($actualData, $responseData);
    }

    public function assertApiSuccess()
    {
        $this->response->assertStatus(200);
        $this->response->assertJson(['success' => true]);
    }

    public function assertModelData(Array $actualData, Array $expectedData)
    {
        foreach ($actualData as $key => $value) {
            if (in_array($key, $TIMESTAMPS$)) {
                continue;
            }
            $this->assertEquals($actualData[$key], $expectedData[$key]);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php namespace $NAMESPACE_REPOSITORIES_TESTS$;

use $NAMESPACE_MODEL$\$MODEL_NAME$;
use $NAMESPACE_REPOSITORY$\$MODEL_NAME$Repository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use $NAMESPACE_TESTS$\TestCase;
use $NAMESPACE_TEST_TRAITS$\Make$MODEL_NAME$Trait;
use $NAMESPACE_TESTS$\ApiTestTrait;

class $MODEL_NAME$RepositoryTest extends TestCase
{
    use Make$MODEL_NAME$Trait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var $MODEL_NAME$Repository
     */
    protected $$MODEL_NAME_CAMEL$Repo;

    public function setUp() : void
    {
        parent::setUp();
        $this->$MODEL_NAME_CAMEL$Repo = \App::make($MODEL_NAME$Repository::class);
    }

    /**
     * @test create
     */
    public function test_create_$MODEL_NAME_SNAKE$()
    {
        $$MODEL_NAME_CAMEL$ = $this->fake$MODEL_NAME$Data();
        $created$MODEL_NAME$ = $this->$MODEL_NAME_CAMEL$Repo->create($$MODEL_NAME_CAMEL$);
        $created$MODEL_NAME$ = $created$MODEL_NAME$->toArray();
        $this->assertArrayHasKey('id', $created$MODEL_NAME$);
        $this->assertNotNull($created$MODEL_NAME$['id'], 'Created $MODEL_NAME$ must have id specified');
        $this->assertNotNull($MODEL_NAME$::find($created$MODEL_NAME$['id']), '$MODEL_NAME$ with given id must be in DB');
        $this->assertModelData($$MODEL_NAME_CAMEL$, $created$MODEL_NAME$);
    }

    /**
     * @test read
     */
    public function test_read_$MODEL_NAME_SNAKE$()
    {
        $$MODEL_NAME_CAMEL$ = $this->make$MODEL_NAME$();
        $db$MODEL_NAME$ = $this->$MODEL_NAME_CAMEL$Repo->find($$MODEL_NAME_CAMEL$->$PRIMARY_KEY_NAME$);
        $db$MODEL_NAME$ = $db$MODEL_NAME$->toArray();
        $this->assertModelData($$MODEL_NAME_CAMEL$->toArray(), $db$MODEL_NAME$);
    }

    /**
     * @test update
     */
    public function test_update_$MODEL_NAME_SNAKE$()
    {
        $$MODEL_NAME_CAMEL$ = $this->make$MODEL_NAME$();
        $fake$MODEL_NAME$ = $this->fake$MODEL_NAME$Data();
        $updated$MODEL_NAME$ = $this->$MODEL_NAME_CAMEL$Repo->update($fake$MODEL_NAME$, $$MODEL_NAME_CAMEL$->$PRIMARY_KEY_NAME$);
        $this->assertModelData($fake$MODEL_NAME$, $updated$MODEL_NAME$->toArray());
        $db$MODEL_NAME$ = $this->$MODEL_NAME_CAMEL$Repo->find($$MODEL_NAME_CAMEL$->$PRIMARY_KEY_NAME$);
        $this->assertModelData($fake$MODEL_NAME$, $db$MODEL_NAME$->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_$MODEL_NAME_SNAKE$()
    {
        $$MODEL_NAME_CAMEL$ = $this->make$MODEL_NAME$();
        $resp = $this->$MODEL_NAME_CAMEL$Repo->delete($$MODEL_NAME_CAMEL$->$PRIMARY_KEY_NAME$);
        $this->assertTrue($resp);
        $this->assertNull($MODEL_NAME$::find($$MODEL_NAME_CAMEL$->$PRIMARY_KEY_NAME$), '$MODEL_NAME$ should not exist in DB');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php namespace $NAMESPACE_TEST_TRAITS$;

use Faker\Factory as Faker;
use $NAMESPACE_MODEL$\$MODEL_NAME$;
use $NAMESPACE_REPOSITORY$\$MODEL_NAME$Repository;

trait Make$MODEL_NAME$Trait
{
    /**
     * Create fake instance of $MODEL_NAME$ and save it in database
     *
     * @param array $$MODEL_NAME_CAMEL$Fields
     * @return $MODEL_NAME$
     */
    public function make$MODEL_NAME$($$MODEL_NAME_CAMEL$Fields = [])
    {
        /** @var $MODEL_NAME$Repository $$MODEL_NAME_CAMEL$Repo */
        $$MODEL_NAME_CAMEL$Repo = \App::make($MODEL_NAME$Repository::class);
        $theme = $this->fake$MODEL_NAME$Data($$MODEL_NAME_CAMEL$Fields);
        return $$MODEL_NAME_CAMEL$Repo->create($theme);
    }

    /**
     * Get fake instance of $MODEL_NAME$
     *
     * @param array $$MODEL_NAME_CAMEL$Fields
     * @return $MODEL_NAME$
     */
    public function fake$MODEL_NAME$($$MODEL_NAME_CAMEL$Fields = [])
    {
        return new $MODEL_NAME$($this->fake$MODEL_NAME$Data($$MODEL_NAME_CAMEL$Fields));
    }

    /**
     * Get fake data of $MODEL_NAME$
     *
     * @param array $$MODEL_NAME_CAMEL$Fields
     * @return array
     */
    public function fake$MODEL_NAME$Data($$MODEL_NAME_CAMEL$Fields = [])
    {
        $fake = Faker::create();

        return array_merge([
            $FIELDS$
        ], $$MODEL_NAME_CAMEL$Fields);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    