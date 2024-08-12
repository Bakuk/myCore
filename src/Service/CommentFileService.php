<?php

namespace Service;

class CommentFileService
{
    private const DIR = './uploadImg/';
    private array $fileFormat = ['image/png', 'image/jpeg'];


    public function create(array $file)
    {
        $size = $file['size']; //размер в байтах
        $fileName = $file['name']; //имя файла
        $tmpFile = $file['tmp_name']; // временный файл на сервере;
        $fileType = $file['type'];

        if (in_array($fileType, $this->fileFormat)){
            move_uploaded_file($tmpFile, self::DIR . $fileName);
        } else {
            echo 'Не правильный формат';
        }

    }


}