<?php

namespace App\Core\Application\Service\RegisterUser;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\ImageUpload;
use App\Core\Application\Mail\AccountVerificationEmail;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Models\AccountVerification\AccountVerification;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;

class RegisterUserService
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param AccountVerificationRepositoryInterface $account_verification_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(RegisterUserRequest $request)
    {
        $registeredUser = $this->user_repository->findByEmail(new Email($request->getEmail()));
        if ($registeredUser) {
            UserException::throw("Mohon Periksa Email Anda Untuk Proses Verifikasi Akun", 1022, 404);
        }

        $imageUrl = '';
        if (!$request->getProfilePhoto()) {
            $image = ImageUpload::create(
                $request->getProfilePhoto(),
                'photo_profile',
                'profile'
            );

            $image->check();
            $imageUrl = $image->upload($request->getName() . $request->getUsername() . $request->getEmail());
        }


        $user = User::create(
            1,
            new Email($request->getEmail()),
            $request->getName(),
            $imageUrl,
            $request->getUsername(),
            null,
            $request->getPassword()
        );


        $this->user_repository->persist($user);
    }
}
