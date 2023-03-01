<?php

namespace App\Service;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
  private $targetDir;

  public function __construct($targetDir)
  {
    $this->targetDir = $targetDir;
  }

  public function upload(UploadedFile $file): string
  {
    $fileName = md5(uniqid()).'.'.$file->guessExtension();
    try {
      $file->move($this->targetDir, $fileName);
    } catch (FileException $e) {
      throw new FileException("File move failed : ".$e);
    }

    return $fileName;
  }

  public function delete($filename): bool
  {
    $filesystem = new Filesystem();
    try {
      $filesystem->remove($this->targetDir.'/'.$filename);
    } catch (IOExceptionInterface $e) {
      echo "File remove failed : ".$e;
    }

    return true;
  }

  public function getTargetDir()
  {
    return $this->targetDir;
  }
}