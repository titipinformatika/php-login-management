<?php
namespace TitipInformatika\Data\Model;

class UserProfileUpdateRequest{
	private ?string $id = null;

    private ?string $name =null;

    private ?string $username = null;
    

	/**
	 * @return 
	 */
	public function getName(): ?string {
		return $this->name;
	}
	
	/**
	 * @param  $name 
	 * @return void
	 */
	public function setName(?string $name): void {
		$this->name = $name;
		
	}

	/**
	 * @return 
	 */
	public function getUsername(): ?string {
		return $this->username;
	}
	
	/**
	 * @param  $username 
	 * @return void
	 */
	public function setUsername(?string $username): void {
		$this->username = $username;
		
	}

	/**
	 * @return 
	 */
	public function getId(): ?string {
		return $this->id;
	}

	/**
	 * @param  $id 
	 * @return void
	 */
	public function setId(?string $id): void {
		$this->id = $id;
	}
}