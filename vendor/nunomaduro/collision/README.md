            $extensions[] = (string) $requirement;
            }
        }

        $this->xmlWriter->startElement('requires');
        $this->xmlWriter->startElement('php');
        $this->xmlWriter->writeAttribute('version', $phpRequirement->asString());

        foreach($extensions as $extension) {
            $this->xmlWriter->startElement('ext');
            $this->xmlWriter->writeAttribute('name', $extension);
            $this->xmlWriter->endElement();
        }

        $this->xmlWriter->endElement();
        $this->xmlWriter->endElement();
    }

    private function addBundles(BundledComponentCollection $bundledComponentCollection) {
        if (count($bundledComponentCollection) === 0) {
            return;
        }
        $this->xmlWriter->startElement('bundles');

        foreach($bundledComponentCollection as $bundledComponent) {
            $this->xmlWriter->startElement('component');
            $this->xmlWriter->writeAttribute('name', $bundledComponent->getName());
            $this->xmlWriter->writeAttribute('version', $bundledComponent->getVersion()->getVersionString());
            $this->xmlWriter->endElement();
        }

        $this->xmlWriter->endElement();
    }

    private function addExtension($application, VersionConstraint $versionConstraint) {
        $this->xmlWriter->startElement('extension');
        $this->xmlWriter->writeAttribute('for', $application);
        $this->xmlWriter->writeAttribute('compatible', $versionConstraint->asString());
        $this->xmlWriter->endElement();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         