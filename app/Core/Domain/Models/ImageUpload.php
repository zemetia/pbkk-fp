<?php

namespace App\Core\Application\ImageUpload;

use App\Exceptions\UserException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUpload
{
    private UploadedFile $uploaded_file;
    private array $available_type;
    private array $available_mime_type;
    private int $file_size_limit;
    private string $path;
    private string $full_path;
    private string $name;

    public function __construct(UploadedFile $uploaded_file, string $path, string $name)
    {
        $this->uploaded_file = $uploaded_file;
        $this->path = $path;
        $this->name = trim($name);


        $this->available_type = [
            "jpg",
            "jpeg",
            "png"
        ];

        $this->available_mime_type = [
            "image/jpg",
            "image/jpeg",
            "image/png"
        ];
        $this->file_size_limit = 5048576;

        $this->check();
    }

    public static function create(UploadedFile $uploaded_file, string $path, string $name): self
    {
        return new self(
            $uploaded_file,
            $path,
            $name
        );
    }

    /**
     * @throws UserException
     */
    public function check(): void
    {
        if (
            !in_array($this->uploaded_file->getClientOriginalExtension(), $this->available_type) ||
            !in_array($this->uploaded_file->getClientMimeType(), $this->available_mime_type)
        )
            UserException::throw("Tipe File {$this->name} Invalid", 2000);
        if ($this->uploaded_file->getSize() > 1048576)
            UserException::throw("{$this->name} Harus Dibawah 5Mb", 2000);
    }

    /**
     * @return string
     */
    public function upload(string $seed): string
    {
        $file_front = str_replace(" ", "_", strtolower($this->name));
        $encrypted_seed = base64_encode($seed);
        $file_name = $file_front . "_" . $encrypted_seed;

        $uploaded = Storage::putFileAs(
            $this->path,
            $this->uploaded_file,
            $file_name
        );
        if (!$uploaded)
            UserException::throw("Upload {$this->name} Gagal", 2003);
        $this->full_path = $this->path . '/' . $file_name;
        return $this->full_path;
    }
}
