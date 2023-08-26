<?php
namespace TitipInformatika\Data\Model;

class UserUpdatePasswordRequest {
    public ?string $id= null;
    public ?string $oldPassword = null;
    public ?string $password = null;
    
}