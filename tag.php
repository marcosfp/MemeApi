<?php
class Tag
{
	public $idTag;
	public $texto;

	public function __construct()
	{
		$this->idTag = 0;
		$this->texto = "";
	}

	public function getIdTag()
	{
		return $this->idTag;
	}
	public function setIdTag($idTag): self
	{
		$this->idTag = $idTag;
		return $this;
	}
	public function getTexto()
	{
		return $this->texto;
	}
	public function setTexto($texto): self
	{
		$this->texto = $texto;
		return $this;
	}
	public function toArray()
	{
		return (array) $this;
	}
}



?>