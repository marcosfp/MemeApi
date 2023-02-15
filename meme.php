<?php
class Meme
{
	private $idMeme;
	private $nombre;
	private $tSuperior;
	private $tInferior;
	private $url;

	public function __construct()
	{

		$this->idMeme = 0;
		$this->nombre = "";
		$this->tSuperior = "";
		$this->tInferior = "";
		$this->url = "";

	}
	public function getTInferior()
	{
		return $this->tInferior;
	}

	public function setTInferior($tInferior): self
	{
		$this->tInferior = $tInferior;
		return $this;
	}
	public function getNombre()
	{
		return $this->nombre;
	}

	public function setNombre($nombre): self
	{
		$this->nombre = $nombre;
		return $this;
	}

	public function getIdMeme()
	{
		return $this->idMeme;
	}

	public function setIdMeme($idMeme): self
	{
		$this->idMeme = $idMeme;
		return $this;
	}
	public function getTSuperior()
	{
		return $this->tSuperior;
	}
	public function setTSuperior($tSuperior): self
	{
		$this->tSuperior = $tSuperior;
		return $this;
	}
	public function getUrl()
	{
		return $this->url;
	}
	public function setUrl($url): self
	{
		$this->url = $url;
		return $this;
	}
	public function toArray()
	{
		return array(
			"idMeme" => $this->getIdMeme(),
			"nombre" => $this->getNombre(),
			"tInferior" => $this->getTInferior(),
			"tSuperior" => $this->getTSuperior(),
			"url" => $this->getUrl()
		);
	}
}

?>