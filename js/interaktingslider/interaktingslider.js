/**
* Interakting Slider
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@magentocommerce.com and you will be sent a copy immediately.
*
* @category   BusinessDecision
* @package    BusinessDecision_Interaktingslider
* @author     Business & Decision Picardie - contactmagento@interakting.com
* @copyright  Copyright (c) 2009 Business & Decision (http://www.businessdecision.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/  

/******************* TRANSITIONS ************************/


function noEffect(pOld,pNew){
	
	if (pOld){
		pOld.style.display='none';
	}
	
	if (pNew){
		pNew.style.display='block';	
	}
}

function crossFade(pOld,pNew,pSpeed){
	
	if (pNew){
		new Effect.Appear(pNew.id, {duration : pSpeed});
	}
	if (pOld){
		new Effect.Fade(pOld.id, {duration : pSpeed});
	}
}

function blindDown(pOld,pNew,pSpeed){
	
	if(pNew){
		pNew.style.zIndex='2';
	}
	if(pOld){
		pOld.style.zIndex='1';
	}
	if (pNew){
		new Effect.BlindDown(pNew.id, {duration : pSpeed});
	}
	if (pOld){
		new Effect.Fade(pOld.id,{duration : pSpeed});
	}
}

function blindUp(pOld,pNew,pSpeed){
	
	if(pNew){
		pNew.style.zIndex='1';
	}
	if(pOld){
		pOld.style.zIndex='2';
	}
	if (pNew){
		new Effect.Appear(pNew.id,{duration : pSpeed});
	}
	if (pOld){
		new Effect.BlindUp(pOld.id, {duration : pSpeed});
	}
	
}

/******************* OBJET CARROUSEL ********************/

function InteraktingSlider(){

	this.slides = new Array();
	this.delay	= 5;	//delai en secondes
	this.chrono = 0; // secondes restantes avant changement
	this.currentSlide = 0;

	this.previousSlide = null;
	this.mode = 'mixte';
	this.transition = 'none';
	this.speed = 1;
	
	this.height = 100;
	this.width = 200;

	return this;
}

// Defini un delai différent du défaut
InteraktingSlider.prototype.setDelay = function(pDelay){
	if(pDelay>0){
		this.delay = pDelay;
	}
		
}

// Défini le mode de changement des slides auto ou manual 
InteraktingSlider.prototype.setMode = function(ps_Mode){
	this.mode = ps_Mode;
}

// Retourne vrai si mode auto actif
InteraktingSlider.prototype.isAutoMode = function(){
	if(this.mode!='manual'){
		return true;
	}
	return false;
}

// Retourne vrai si mode manual actif
InteraktingSlider.prototype.isManualMode = function(){
	
	if(this.countSlides()<1){
		return false;
	}
	if(this.mode!='auto'){
		return true;
	}
	return false;
}

// Redefini le temps restant avant prochain changement
InteraktingSlider.prototype.setChrono = function(pSec){
	this.chrono = pSec;
}

// Defini la transition a utiliser
InteraktingSlider.prototype.setTransition = function(pTrans){
	this.transition = pTrans;
}

// Defini la vitesse de transition
InteraktingSlider.prototype.setSpeed = function(pSpeed){
	if(pSpeed>0){
		this.speed = pSpeed/1000;
	}
	
}

// Ajoute un slide au carrousel
InteraktingSlider.prototype.addSlide = function(pCms){
	
	var div = document.getElementById('slide-content');	
	if (div){
		
		var i=this.countSlides();
		
		var content = "<div id='slide-"+i+"' class='slide' style='display:none;position:absolute;'>"+pCms+"</div>";			
			
		div.innerHTML += content;
		
		
	}
	
	this.slides.push(i);
}

// retourne le nombre de slides du carrousel
InteraktingSlider.prototype.countSlides = function(){
	return this.slides.length;
}

// Retourne le contenu du slide courant
InteraktingSlider.prototype.getCurrentSlide = function(){
	return this.slides[this.currentSlide];
}

// Défini quel slide doit etre utilisé
InteraktingSlider.prototype.setCurrentSlide = function(pId){
	this.previousSlide = this.currentSlide;
	this.currentSlide = pId;
}

// Retourne si l'index en parametre est le slide courante
InteraktingSlider.prototype.isCurrentSlide = function(pId){
	return (this.currentSlide==pId);
}

// Incrémente l'index du slide à utiliser
InteraktingSlider.prototype.setCurrentSlideUp = function(){
	this.previousSlide = this.currentSlide;
	this.currentSlide++;
}

// Décrémente l'index du slide à utiliser
InteraktingSlider.prototype.setCurrentSlideDown = function(){
	this.previousSlide = this.currentSlide;
	this.currentSlide--;
}

// Décale les slides du carrousel vers la gauche
InteraktingSlider.prototype.turnLeft = function(){
	var nb = this.countSlides();
	if(this.currentSlide==0){
		this.goTo(nb-1);
	}
	else {
		this.setCurrentSlideDown();
	}
	this.refresh();		
}

// Décale les slides du carrousel vers la droite
InteraktingSlider.prototype.turnRight = function(){
	var nb = this.countSlides();
	if(this.currentSlide==(nb-1)){
		this.goTo(0);
	}
	else {
		this.setCurrentSlideUp();
	}
	this.refresh();		
}

//Changement du slide courant vers celui d'index pId
InteraktingSlider.prototype.goTo = function(pId){
	if(pId!=this.currentSlide){
		this.setCurrentSlide(pId);
		this.refresh();
	}
	
}

// Retourne le code HTML pour les boutons de commandes
InteraktingSlider.prototype.getCommande = function(){

	var html = '';
	html += "<a href='#' id='prev' class='normal' onclick='interaktingslider.turnLeft();return false;'><span>&lt;</span></a>";
	for (i=0;i<this.countSlides();i++){
		html += "<a href='#' id='button"+i+"' onclick='interaktingslider.goTo("+i+");return false;'><span>"+(i+1)+"</span></a>";		
	}
	html += "<a href='#' id='next' class='normal' onclick='interaktingslider.turnRight();return false;'><span>&gt;</span></a>";
	return html;
}

//Défini le slide actif en attribut CSS pour les boutons de commande
InteraktingSlider.prototype.setCurrentButton = function(){
	for (i=0;i<this.countSlides();i++){
		var button = document.getElementById('button'+i);
		if(this.isCurrentSlide(i)){
			button.setAttribute("class", "active"); 
			button.setAttribute("className", "active");
		}
		else{
			button.setAttribute("class", "normal"); 
			button.setAttribute("className", "normal");
		} 
		
	}
}

// Affiche dans la page les élements du carrousel
InteraktingSlider.prototype.show = function(){
	
	if(this.isManualMode()){
		div = document.getElementById('middle-center');	
		if (div){
			div.innerHTML += '<div id="slide-commands">'+this.getCommande()+'</div>';
		}
	}
	

	
	if(this.countSlides()>0){
		this.refresh();
		this.run();	
	}
	
}


// Change le slide affiché
InteraktingSlider.prototype.changeSlide = function(){
	
	if(this.isManualMode()){	
		this.setCurrentButton();
	}
	
	if(this.transition=='random'){
		this.makeTransition(this.getRandomTransition());
	}
	else{
		this.makeTransition(this.transition);
	}
		
}

//Joue la transition
InteraktingSlider.prototype.makeTransition = function(pTransition){
	
	var oldSlide = document.getElementById('slide-'+this.previousSlide);	
	var newSlide = document.getElementById('slide-'+this.currentSlide);
	
	// Appel de la bonne transition
	switch(pTransition)
	{
		case 'up':
			blindUp(oldSlide,newSlide,this.speed);
			break;
		case 'down':
			blindDown(oldSlide,newSlide,this.speed);
			break;		
		case 'fade':
  			crossFade(oldSlide,newSlide,this.speed);
  			break;
  		case 'none':
		default:
	  		noEffect(oldSlide,newSlide,this.speed);
	}
}

// Actualise l'affichage de l'écran et relande le compte a rebours
InteraktingSlider.prototype.refresh = function(){
	this.changeSlide();
	this.setChrono(this.delay);	// RAZ du compte a rebours
}


// Automatisation du Diaporama
InteraktingSlider.prototype.run = function(){

	if(this.chrono==0){
		// le compte a rebours est terminé
		this.turnRight();
	}
	else{
		// décompte du temps restant
		this.chrono--;
	}
	
	if(this.isAutoMode()){
		setTimeout("interaktingslider.run()",1000);
	}
	
	
}


