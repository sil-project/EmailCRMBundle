<?php

namespace Librinfo\EmailCRMBundle\Entity\OuterExtension\LibrinfoEmailBundle;

use Doctrine\Common\Collections\Collection;

trait EmailExtension
{

    /**
     * @var Collection
     */
    protected $individuals;

    /**
     * @var Collection
     */
    protected $organizations;

    /**
     * @return Collection 
     */
    public function getIndividuals()
    {
        return $this->individuals;
    }

    /**
     * @param Collection $individuals
     * @return $this
     */
    public function setIndividuals($individuals)
    {
        $this->individual = $individuals;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * @param Collection $organizations
     * @return $this
     */
    public function setOrganizations($organizations)
    {
        $this->organizations = $organizations;
        return $this;
    }

}
