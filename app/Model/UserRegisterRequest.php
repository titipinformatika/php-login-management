<?php
namespace TitipInformatika\Data\Model;
class UserRegisterRequest{
    private string $id;
    private string $name;
    private string $username;
    private string $password;

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

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @param string $name 
	 * @return void
	 */
	public function setName(string $name): void {
		$this->name = $name;
		
	}

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
}