<?php
namespace TitipInformatika\Data\Domain;
class Session {

    private ?string $id=null;
    private ?string $user_id=null;

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

	/**
	 * @return 
	 */
	public function getUser_id(): ?string {
		return $this->user_id;
	}
	
	/**
	 * @param  $user_id 
	 * @return void
	 */
	public function setUser_id(?string $user_id): void {
		$this->user_id = $user_id;
	}
}