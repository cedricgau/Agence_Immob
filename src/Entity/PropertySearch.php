<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch {

    /**
     * @var int|null
     * @Assert\Range(min=50000, max=10000000)
     */

     private $maxPrice;

     
    /**
     * @var int|null
     * @Assert\Range(min=9, max=350)
     */

    private $minSurface;




     /**
      * Get the value of maxPrice
      */ 
     public function getMaxPrice(): ?int
     {
          return $this->maxPrice;
     }

     /**
      * Set the value of maxPrice
      * @param int|null $maxPrice
      * @return  PropertySearch
      */ 
     public function setMaxPrice(int $maxPrice) : PropertySearch
     {
          $this->maxPrice = $maxPrice;

          return $this;
     }

    /**
     * Get the value of $minSurface
     */ 
    public function getminSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * Set the value of $minSurface
     * @param int|null $minSurface
     * @return  PropertySearch
     */ 
    public function setminSurface(int $minSurface) : PropertySearch
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    
}