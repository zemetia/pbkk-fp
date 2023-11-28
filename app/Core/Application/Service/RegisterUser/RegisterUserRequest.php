<?php

namespace App\Core\Application\Service\RegisterUser;

use Illuminate\Http\UploadedFile;

class RegisterUserRequest
{
    private string $email;
    private string $name;
    private string $password;
    private ?UploadedFile $profile_photo;
    private string $username;

    /**
     * @param string $email
     * @param string $name
     * @param string $password
     * @param UploadedFile|null $profile_photo
     * @param string $username
     */
    public function __construct(string $email, string $name, string $password, string $username, ?UploadedFile $profile_photo)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->profile_photo = $profile_photo;
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getProfilePhoto(): ?UploadedFile
    {
        return $this->profile_photo;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
