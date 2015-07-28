<?php

namespace base;

class NavigationNode{
	const ID = 'id';
	const WHEN = 'when';
	const GET = 'get';
	const POST = 'post';
	const CONTROLLER = 'controller';
	const CONTROLLERPARAMS = 'controllerParams';
	const VIEW = 'view';
	const VIEWPARAMS = 'viewParams';
	const SORT = 'sort';
	const TITLE = 'title';

	private $db;
	private $children = array();

	private $id;
	private $when;
	private $get;
	private $post;
	private $controller;
	private $controllerParams;
	private $view;
	private $viewParams;
	private $sort;
	private $title;

	function __construct(Database $db, $id){
		$this->db = $db;
		$this->read($id);
		$this->readChildren();
	}

	private function read($id){
		$result = $this->db->select('* FROM {prefix}'.Navigation::DB_TABLE.' WHERE id = '.$id);

		if(!count($result)){
			throw new NavigatioNodeNotFoundException($id);
		}

		$this->id = $id;
		$this->when = $result[0]['when'];
		$this->get = $result[0]['get'];
		$this->post = $result[0]['post'];
		$this->controller = $result[0]['controller'];
		$this->controllerParams = $result[0]['controllerParams'];
		$this->view = $result[0]['view'];
		$this->viewParams = $result[0]['viewParams'];
		$this->sort = $result[0]['sort'];
		$this->title = $result[0]['title'];
	}

	private function readChildren(){
		$result = $this->db->select('id FROM {prefix}'.Navigation::DB_TABLE.' WHERE parent = '.$id.' ORDER BY sort ASC');

		foreach($result AS $child){
			$this->children[] = new NavigationNode($this->db, $child['id']);
		}
	}

	function save(){
		return $this->db->update('{prefix}'.Navigation::DB_TABLE.'
								  SET when = '.$this->db->escape($this->when).',
								  get = '.$this->db->escape($this->get).',
								  post = '.$this->db->escape($this->post).',
								  controller = '.$this->db->escape($this->controller).',
								  controllerParams = '.$this->db->escape($this->controllerParams).',
								  view = '.$this->db->escape($this->view).',
								  viewParams = '.$this->db->escape($this->viewParams).',
								  sort = '.$this->db->escape($this->sort).',
								  title = '.$this->db->escape($this->title).'
								  WHERE id = '.$this->id);
	}

	function addRoute(Router $router){

	}

	function removeRoute(Router $router){

	}

	function findNode($attr, $value){

	}

	function setWhen($when){
		$this->when = $when;
	}

	function setGet($get){
		$this->get = $get;
	}

	function setPost($post){
		$this->post = $post;
	}

	function setController($controller){
		$this->controller = $controller;
	}

	function setControllerParams($controllerParams){
		$this->controllerParams = $controllerParams;
	}

	function setView($view){
		$this->view = $view;
	}

	function setViewParams($viewParams){
		$this->viewParams = $viewParams;
	}

	function setSort($sort){
		$this->sort = $sort;
	}

	function setTitle($title){
		$this->title = $title;
	}

	function getId(){
		return $this->id;
	}

	function getWhen(){
		return $this->when;
	}

	function getGet(){
		return $this->get;
	}

	function getPost(){
		return $this->post;
	}

	function getController(){
		return $this->controller;
	}

	function getControllerParams(){
		return $this->controllerParams;
	}

	function getView(){
		return $this->view;
	}

	function getViewParams(){
		return $this->viewParams;
	}

	function getSort(){
		return $this->sort;
	}

	function getTitle(){
		return $this->title;
	}

	function getChildren(){
		return $this->children;
	}
}
?>
