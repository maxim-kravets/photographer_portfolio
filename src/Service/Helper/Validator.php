<?php
/**
 * @author Maxim Kravets kravets.development@gmail.com.
 * Date: 12/26/18
 * Time: 23:22
 */

namespace App\Service\Helper;


use App\Dto\User;

class Validator extends ValidatorAbstract implements ValidatorInterface
{
    public function validate(User $dto)
    {
        $username = $dto->getUsername();

        if (\iconv_strlen($username) < 3) {
            throw new ValidatorException('Username must be more than 2 characters');
        }

        if (\iconv_strlen($username) > 11) {
            throw new ValidatorException('Username must be less than 10 characters');
        }

        $email = $dto->getEmail();

        if (\filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
            throw new ValidatorException('Incorrect email');
        }

        $entry = $this->userRepository->findOneBy(['email' => $email]);

        if ( ! \is_null($entry)) {
            throw new ValidatorException('User with such email already exists');
        }

        $password = $dto->getPassword();

        if (\iconv_strlen($password) < 6) {
            throw new ValidatorException('Password must be more than 5 characters');
        }

        $retype_password = $dto->getRetypePassword();

        if ($password != $retype_password) {
            throw new ValidatorException('Passwords don\'t match');
        }
    }
}
