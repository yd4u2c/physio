<?php
namespace Prettus\Repository\Contracts;

use Illuminate\Support\Collection;


/**
 * Interface RepositoryCriteriaInterface
 * @package Prettus\Repository\Contracts
 */
interface RepositoryCriteriaInterface
{

    /**
     * Push Criteria for filter the query
     *
     * @param $criteria
     *
     * @return $this
     */
    public function pushCriteria($criteria);

    /**
     * Pop Criteria
     *
     * @param $criteria
     *
     * @return $this
     */
    public function popCriteria($criteria);

    /**
     * Get Collection of Criteria
     *
     * @return Collection
     */
    public function getCriteria();

    /**
     * Find data by Criteria
     *
     * @param CriteriaInterface $criteria
     *
     * @return mixed
     */
 