<?php

namespace App\Entity;

use App\Service\FileUploader;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\EntityListeners({"App\EventListener\ImageUploadListener"})
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $extension;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="images")
     */
    private $trick;
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     */
    private $tempFilename;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension)
    {
        $this->extension = $extension;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     */
    public function setTempFilename()
    {
        $this->tempFilename = $this->name.'.'.$this->extension;
    }

    /**
     * @return string
     */
    public function getTempFilename(): ?string
    {
        return $this->tempFilename;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile|null $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        if ($this->extension !== null) {
            $this->setTempFilename();

            $this->url = null;
            $this->alt = null;
        }
    }
    /**
     * @return string
     */
    public function getDirectory()
    {
        return 'images/';
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getDirectory().$this->getName().'.'.$this->getExtension();
    }
}
