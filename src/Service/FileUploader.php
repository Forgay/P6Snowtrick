<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 23/08/2018
 * Time: 11:08
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * @var string
     */
    private $targetDirectory;

    /**
     * FileUploader constructor.
     * @param string $targetDirectory
     */
    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    /**
     * @param string $directory
     */
    public function setTargetDirectory($directory)
    {
        $this->targetDirectory = $directory;
    }
    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    public function getExtension(UploadedFile $file): string
    {
        return $file->guessExtension();
    }

    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    public function getOriginalName(UploadedFile $file): string
    {
        return $file->getClientOriginalName();
    }
}
