['uptime'] ?? null;
        } catch (Exception $e) {
        }

        try {
            $collStats   = $this->database->command(['collStats' => $this->collection->getCollectionName()])->toArray()[0];
            $memoryUsage = $collStats['size'] ?? null;
        } catch (Exception $e) {
        }

        return [
            Cache::STATS_HITS => null,
            Cache::STATS_MISSES => null,
            Cache::STATS_UPTIME => $uptime,
            Cache::STATS_MEMORY_USAGE => $memoryUsage,
            Cache::STATS_MEMORY_AVAILABLE  => null,
        ];
    }

    /**
     * Check if the document is expired.
     */
    private function isExpired(BSONDocument $document) : bool
    {
        return isset($document[MongoDBCache::EXPIRATION_FIELD]) &&
            $document[MongoDBCache::EXPIRATION_FIELD] instanceof UTCDateTime &&
            $document[MongoDBCache::EXPIRATION_FIELD]->toDateTime() < new \DateTime();
    }

    private function createExpirationIndex() : void
    {
        if ($this->expirationIndexCreated) {
            return;
        }

        $this->collection->createIndex([MongoDBCache::EXPIRATION_FIELD => 1], ['background' => true, 'expireAfterSeconds' => 0]);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         