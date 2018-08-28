<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvatarRepository")
 * @ORM\EntityListeners({"App\EventListener\AvatarUploadListener"})
 */
class Avatar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $extension;
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

    /**
     * @param string $name
     *
     */
    public function setName(string $name)
    {
        $this->name = $name;

    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;

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
     */
    public function setTempFilename()
    {
        $this->tempFilename = $this->name. '.' .$this->extension;
    }

    /**
     * @return string
     */
    public function getTempFilename(): ?string
    {
        return $this->tempFilename;
    }

    /**
     * @return string
     */
    public function getUploadDir(): string
    {
        return 'uploads/avatars';
    }

    /**
     * @return string
     */
    public function getUploadRootDir(): string
    {
        return __DIR__.'/../../public/'.$this->getUploadDir();
    }

    /**
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->getUploadDir().'/'.$this->getName().'.'.$this->getExtension();
    }

}
