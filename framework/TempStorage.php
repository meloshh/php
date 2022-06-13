<?php

namespace Framework;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

class TempStorage extends Storage
{
    public function __construct()
    {
        $tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
        $adapter = new LocalFilesystemAdapter($tmp_dir);
        $this->filesystem = new Filesystem($adapter);
    }
}