<?php

namespace DummyNamespace;

use NamespacedDummyUserModel;
use NamespacedDummyModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class DummyClass
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the DocDummyModel.
     *
     * @param  \NamespacedDummyUserModel  $user
     * @param  \NamespacedDummyModel  $dummyModel
     * @return mixed
     */
    public function view(DummyUser $user, DummyModel $dummyModel)
    {
        //
    }

    /**
     * Determine whether the user can create DocDummyPluralModel.
     *
     * @param  \NamespacedDummyUserModel  $user
     * @return mixed
     */
    public function create(DummyUser $user)
    {
        //
    }

    /**
     * Determine whether the user can update the DocDummyModel.
     *
     * @param  \NamespacedDummyUserModel  $user
     * @param  \NamespacedDummyModel  $dummyModel
     * @return mixed
     */
    public function update(DummyUser $user, DummyModel $dummyModel)
    {
        //
    }

    /**
     * Determine whether the user can delete the DocDummyModel.
     *
     * @param  \NamespacedDummyUserModel  $user
     * @param  \NamespacedDummyModel  $dummyModel
     * @return mixed
     */
    public function delete(DummyUser $user, DummyModel $dummyMode