//puts the ability data in the innerHTML part so it will register what will be displayed on the screen
function getElementInnerHtml(id, fColor, DR, damage, ability){
	return getElement(id).innerHTML += "<span><B><font color='"+fColor+"'>You've "+DR+" " + damage + " damage ("+ability+") </font></B></span><br>";
}
//generates a random number that dependents on the information that is given in the parameters.
function random(min , max){
	return Math.floor(Math.random() * (max - min) + min);
}
//generates the document.getElementById based on the information passed into the parameters.
function getElement(id){
	return document.getElementById(id);
}
//calculates the length of the ID that you've put in the paremeter.
function childrenLength(ID){
	return getElement(ID).getElementsByTagName("span").length;
}
//generates the HTML of the standart damage dealt by you or the enemy
function damageDR(CDR, HTML, attack, secondHTML){
	return getElement(CDR).innerHTML += HTML + attack +  secondHTML;
}
//throws the parameters into the damageDR function
function damageD(attack){
	damageDR("charactersD", "<span>You've received " , attack,  " damage</span><br>")
}
//throws the parameters into the damageDR function
function damageR(attack){
	damageDR("charactersR", "<span>You've dealt " , attack,  " damage</span><br>")
}
//generates the critical damage HTML of the enemy
function criticalD(attack){
	getElement("charactersD").innerHTML += "<B><span>Critical! You've received " +  attack + " damage</B></span><br>";
}
//generates the critical damage HTML dealt by you
function criticalR(attack){
	getElement("charactersR").innerHTML += "<B><span>Critical! You've dealt " +  attack + " damage</B></span><br>";
}
//calculates the damage dealt to the enemy
function myDamageDealt(){
	var damage = random(baseDamage)
}
//calculates the damage of the enemy
function damageEnemy(){
	damage =  Math.floor((Math.random() * ( calcDamage(enemyLevel, level) )));
}
//calculates the max damage dealt by the enemy
function calcDamage(){
	//calculate the damage based on level.
	var diff = enemyLevel - level;
	damage = baseDamage + (baseDamage * (diff * 0.25));
	return damage;
}
//shuffles the array in the array.js file
function shuffleEnemyName() {
	shuffle(randomEnemyName);
	getElement("enemyName").innerHTML = randomEnemyName[1];
}
//displays the xpbar
function XPBAR(){
	getElement("xpBar").innerHTML = xp + " xp / " + xpNeeded;
}
//displays the hitpoints
function loadHP(getElementId, id){
	getElement("characterHP").innerHTML = id + " Hitpoints";
}
function decreaseIncreaseDamage(name){
	name = (Math.random() * (0.60 - 0.30) + 0.30).toFixed(2);
}
function defenceAbilityEnemy(){
	getElementInnerHtml("charactersD", "#610B21", "received", damage, " enemy blocked " + (defenceNumber * 100)  + "%. Received  " + damageNumber + " damage");
	HP = HP - damageNumber;
	getElement("characterHP").innerHTML = HP + " Hitpoints";
}
function defenceAbilityCharacter(){
	getElementInnerHtml("charactersR", "#610B21", "dealt", damage, " enemy blocked " + (defenceNumber * 100)  + "%. Received  " + damageNumber + " damage");
	enemyHP = enemyHP - damageNumber;
	getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";
}