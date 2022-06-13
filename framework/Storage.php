<?php

namespace Framework;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

class Storage
{
    protected Filesystem $filesystem;

    public function __construct()
    {
        $adapter = new LocalFilesystemAdapter(P_DIR.'storage/public');
        $this->filesystem = new Filesystem($adapter);
    }



    public function read(string $path): mixed
    {
        return $this->filesystem->readStream($path);
    }

    public function write(string $path, $contents): void
    {
        $this->filesystem->writeStream($path, $contents);
    }

    public function writeUploadedFile(string $path, array $fileData, TempStorage $tempStorage): void
    {
        $resource = $tempStorage->read(pathinfo(request()->files['profilePic']['tmp_name'], PATHINFO_BASENAME));

        $path = randomStr(32).'.'.pathinfo(request()->files['profilePic']['name'], PATHINFO_EXTENSION);
        $this->write($path, $resource);
    }

    public function deleteFile(string $path): void
    {
        $this->filesystem->delete($path);
    }

    public function deleteDir(string $path): void
    {
        $this->filesystem->deleteDirectory($path);
    }
}