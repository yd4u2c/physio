t is not the same as that of outer exception
     *
     * @param  FrameCollection $parentFrames Outer exception frames to compare tail against
     * @return Frame[]
     */
    public function topDiff(FrameCollection $parentFrames)
    {
        $diff = $this->frames;

        $parentFrames = $parentFrames->getArray();
        $p = count($parentFrames)-1;

        for ($i = count($diff)-1; $i >= 0 && $p >= 0; $i--) {
            /** @var Frame $tailFrame */
            $tailFrame = $diff[$i];
            if ($tailFrame->equals($parentFrames[$p])) {
                unset($diff[$i]);
            }
            $p--;
        }
        return $diff;
    }
}
                                                                                                                                                                                                                                                                                        