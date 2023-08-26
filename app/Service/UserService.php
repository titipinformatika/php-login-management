<?php
namespace TitipInformatika\Data\Service;
use Exception;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Domain\User;
use TitipInformatika\Data\Exception\ValidationException;
use TitipInformatika\Data\Model\UserLoginRequest;
use TitipInformatika\Data\Model\UserLoginResponse;
use TitipInformatika\Data\Model\UserProfileUpdateRequest;
use TitipInformatika\Data\Model\UserProfileUpdateResponse;
use TitipInformatika\Data\Model\UserRegisterRequest;
use TitipInformatika\Data\Model\UserRegisterResponse;
use TitipInformatika\Data\Model\UserUpdatePasswordRequest;
use TitipInformatika\Data\Model\UserUpdatePasswordResponse;
use TitipInformatika\Data\Repository\UserRepository;
class UserService {

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request):UserRegisterResponse{
        $this->validateUserRegisterRequest($request);
        try{
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->getId());

            if($user != null){
                throw new ValidationException("User id already exists");
            }

            $user = new User();
            $user->setId($request->getId());
            $user->setName($request->getName());
            $user->setUsername($request->getUsername());
            $user->setPassword(password_hash($request->getPassword(),PASSWORD_BCRYPT));
            
            $resultUser = $this->userRepository->save($user);
            $response = new UserRegisterResponse();
            $response->user= $resultUser;
            Database::commitTransaction();
            return $response;

        }catch(Exception $exception){

            Database::rollbackTransaction();
            throw $exception;
        }
        
    }

    public function userUpdatePassword(UserUpdatePasswordRequest $request):UserUpdatePasswordResponse{
        $this->validateUserUpdatePassword($request);

        try{
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->id);
            if($user == null){
                throw new ValidationException("User not found");
            }

            // check match old password and new password
            if(!password_verify($request->oldPassword,$user->getPassword())){
                throw new ValidationException("old password is wrong");
            }


            $user->setPassword(password_hash($request->password,PASSWORD_BCRYPT));
            $this->userRepository->update($user);
            Database::commitTransaction();

            $response = new UserUpdatePasswordResponse();
            $response->user = $user;
            return $response;

        }catch(Exception $exception){
            Database::rollbackTransaction();
            throw $exception;
        }
       
    }

    function userUpdateProfile(UserProfileUpdateRequest $request):UserProfileUpdateResponse{

        $this->validationUserProfileUpdateRequest($request);

        try{
            Database::beginTransaction();
            $user =$this->userRepository->findById($request->getId());

            if($user == null){
                throw new ValidationException("userId not found");
            }

            $user->setId($request->getId());
            $user->setName($request->getName());
            $user->setUsername($request->getUsername());
            $response = new UserProfileUpdateResponse();
            $response->user = $this->userRepository->update($user);
            Database::commitTransaction();
            return $response;

        }catch(Exception $excetion){
            Database::rollbackTransaction();
            throw $excetion;
        }

    }

    public function login (UserLoginRequest $userLoginRequest):UserLoginResponse{
        $this->validateUserLoginRequest($userLoginRequest);

        $user = $this->userRepository->findById($userLoginRequest->getId());
        if($user == null){
            throw new ValidationException("id or password is worng");
        }

        if(password_verify($userLoginRequest->getPassword(),$user->getPassword())){
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;
        }else{
            throw new ValidationException("Id or password is worng");
        }


    }

    private function validateUserRegisterRequest(UserRegisterRequest $request){
        if($request->getId() == null || $request->getName()==null || $request->getUsername()==null || $request->getPassword() == null
        || trim($request->getId())== "" || trim($request->getName())=="" || trim($request->getUsername()) =="" || trim($request->getPassword())==""
        ){
            throw new ValidationException("id,name,username,password cant not blank");
        }
    }

    private function validationUserProfileUpdateRequest(UserProfileUpdateRequest $request){
        if($request->getUsername() == null || $request->getName()== null || trim($request->getUsername())=="" || trim($request->getName())==""){

            throw new ValidationException("username or name cant not blank");
        }
    }

    private function validateUserLoginRequest(UserLoginRequest $userLoginRequest){
        if($userLoginRequest->getUsername() == null || $userLoginRequest->getUsername()== null || trim($userLoginRequest->getUsername())=="" || trim($userLoginRequest->getPassword())==""){

            throw new ValidationException("username or password cant not blank");
        }
    }

    private function validateUserUpdatePassword(UserUpdatePasswordRequest $request){
        if($request->oldPassword == null || $request->password= null || trim($request->oldPassword)=="" || trim($request->password)==""){
            throw new ValidationException("old password or new password cant not blank");
        }
    }
}