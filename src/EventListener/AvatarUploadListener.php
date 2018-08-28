<?php

namespace App\EventListener;

use App\Entity\Avatar;
use App\Service\FileUploader;
use Doctrine\ORM\Mapping as ORM;


class AvatarUploadListener
{
	/**
	 * @var FileUploader
	 */
	private $uploader;

	/**
	 * @var string
	 */
	private $directory;

	/**
	 * AvatarUploadListener constructor.
     *
	 * @param FileUploader $uploader
	 * @param $directory
	 */
	public function __construct(FileUploader $uploader, $directory)
	{
		$this->uploader = $uploader;
		$this->directory = $directory;
	}

	/**
	 * @param Avatar $avatar
     *
	 * @ORM\PrePersist
	 * @ORM\PreUpdate
	 */
	public function prePersistHandler(Avatar $avatar)
	{
		if(!$avatar instanceof Avatar)
			return;

		if($avatar->getFile() === null)
			return;

		$extension = $this->uploader->getExtension($avatar->getFile());

		$avatar->setName(md5(uniqid()));
		$avatar->setExtension($extension);
	}

	/**
	 * @param Avatar $avatar
     *
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function postPersistHandler(Avatar $avatar)
	{
		if(!$avatar instanceof Avatar)
			return;

		if ($avatar->getTempFilename() !== null) {
			$oldFile = $this->directory.'/'.$avatar->getTempFilename();
			if (file_exists($oldFile))
				unlink($oldFile);
		}

		$this->uploader->setTargetDirectory($this->directory);
		$this->uploader->upload($avatar->getFile());
	}

	/**
	 * @param Avatar $avatar
     *
	 * @ORM\PreRemove()
	 */
	public function preRemoveHandler(Avatar $avatar)
	{
		if(!$avatar instanceof Avatar)
			return;

		$avatar->setTempFilename();
	}

	/**
	 * @param Avatar $avatar
     *
	 * @ORM\PostRemove()
	 */
	public function postRemoveHandler(Avatar $avatar)
	{
		if(!$avatar instanceof Avatar)
			return;

		if (file_exists($this->directory.'/'.$avatar->getTempFilename()))
			unlink($this->directory.'/'.$avatar->getTempFilename());
	}
}
