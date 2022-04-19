<?php

namespace App\Entity;

use App\Repository\GoodsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoodsRepository::class)]
class Goods
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\ManyToMany(targetEntity: Bundle::class, mappedBy: 'goods')]
    private $bundles;

    public function __construct()
    {
        $this->bundles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Bundle>
     */
    public function getBundles(): Collection
    {
        return $this->bundles;
    }

    public function addBundle(Bundle $bundle): self
    {
        if (!$this->bundles->contains($bundle)) {
            $this->bundles[] = $bundle;
            $bundle->addGood($this);
        }

        return $this;
    }

    public function removeBundle(Bundle $bundle): self
    {
        if ($this->bundles->removeElement($bundle)) {
            $bundle->removeGood($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
