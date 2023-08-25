<?php
namespace TitipInformatika\Data\Domain;

class User{

    private string $id,$username, $name, $password;
    
	/**
	 * @return 
	 */
	public function getId(): string {
		return $this->id;
	}
	
	/**
	 * @param  $id 
	 * @return void
	 */
	public function setId(string $id): void {
		$this->id = $id;
		
	}

	/**
	 * @return 
	 */
	public function getUsername(): string {
		return $this->username;
	}
	
	/**
	 * @param  $username 
	 * @return void
	 */
	public function setUsername(string $username): void {
		$this->username = $username;
		
	}

	/**
	 * @return 
	 */
	public function getName(): string {
		return $this->name;
	}
	
	/**
	 * @param  $name 
	 * @return void
	 */
	public function setName(string $name): void {
		$this->name = $name;
		
	}

	/**
	 * @return 
	 */
	public function getPassword(): string {
		return $this->password;
	}

	/**
	 * @param  $password 
	 * @return void
	 */
	public function setPassword(string $password): void {
		$this->password = $password;
	}
}