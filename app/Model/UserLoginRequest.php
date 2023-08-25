<?php
namespace TitipInformatika\Data\Model;
class UserLoginRequest {
    private ?string $id= null;
    private ?string $username= null;
    private ?string $password=null;

	/**
	 * @return string
	 */
	public function getUsername(): string {
		return $this->username;
	}
	
	/**
	 * @param string $username 
	 * @return void
	 */
	public function setUsername(string $username): void {
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string {
		return $this->password;
	}
	
	/**
	 * @param string $password 
	 * @return void
	 */
	public function setPassword(string $password): void {
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getId(): string {
		return $this->id;
	}
	
	/**
	 * @param string $id 
	 * @return void
	 */
	public function setId(string $id): void {
		$this->id = $id;
		
	}
}