var interval, enterName, attack, HP, enemyHP;
var multistrikeNumber, damageDealtToEnemy, damageReceivedFromEnemy;
var defenceNumber, damageNumber;
var xp = 9;
var win = 0;
var lost = 0;
var level = 1;
var baseDamage = 10;
var criticalChance = 10;
var enemyCriticalChance = 10;
var enemyLevel;
var skillPoints = 0;
var strengthSkillUp = 0;
var attackSkillUp = 0;
var defenceSkillUp = 0;
var xpNeeded = 10;

//displays the amount of wins and losses.
getElement("winLose").innerHTML = "You have won " + win + " games<br>You have lost " + lost + " games";

//All character information
//Prompt in which you can type your name
function name() {
	enterName = prompt("Please enter your name");
}
//character information.
function charactersInfo() {
	//calls the randomEnemy level and hitpoints functions
	randomEnemyLevel();
	hitpoints();
	//gets a random name from the array
	var userName =  randomEnemyName[Math.floor(Math.random()*randomEnemyName.length)];
	getElement("xpBar").innerHTML = xp + " xp / " + xpNeeded;
	getElement("level").innerHTML = "level " + level; 
	//If the prompt is empty get random name from array
	if (enterName != null){
		getElement("characterName").innerHTML += enterName;
	} else {
		getElement("characterName").innerHTML += userName;
	}
	if (enterName == ""){
		getElement("characterName").innerHTML += userName;
	}
	calcDamage();

	getElement("enemyName").innerHTML = randomEnemyName[1];
	getElement("characterHP").innerHTML = HP + " Hitpoints";
	getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";

}
//hitpoints function calculates the enemy hp based on level and character hp based on level and defenceskill.
function hitpoints(){
	enemyHP = 100;
	if (defenceSkillUp == 0) {
		HP = 100;
	} 
	if (defenceSkillUp != 0) {
		HP = 100 + (10 * defenceSkillUp);
	}

	HP += (level * 50);
	enemyHP += (enemyLevel * 50);
}
//causes to do an attack every 1.5 seconds
function damageTime() {
	getElement("damageDealt").style.pointerEvents = "none";
	interval = setInterval(function() {
	charactersDM(); 
	},1500);
}
//stops the interval.
function stopInterval() {
	getElement("damageDealt").style.pointerEvents = "auto";
	window.clearInterval(interval);
}
//generates a random number between 1 and 9.
//based on the number it chooses a level.
function randomEnemyLevel() {
	var randomEnemyLevelId = random(9, 1);

	switch(randomEnemyLevelId) {
		case 1:
		case 4:
		case 7:
			getElement("enemyLevel").innerHTML = "level " + (enemyLevel = level - 1);
		break;

		case 2:
		case 5:
		case 8:
			getElement("enemyLevel").innerHTML = "level " + (enemyLevel = level);
		break;

		case 3:
		case 6:
		case 9:
			getElement("enemyLevel").innerHTML = "level " + (enemyLevel = level);
		break;

	} 
	return enemyLevel;
}
//base function to choose if abiltiy/critical or normal hit.
function charactersDM() {
	XPBAR();
	countChildren();
	//generates a random number between 0 and 20 and if its one of the numbers declared below call the ability function.
	var abilityNumber = Math.floor((Math.random() * 20));
	switch(abilityNumber){
		case 3:
		case 8:
		case 11:
		case 17:
		case 20:
			abilities();
			// enemyDM();
		break;

		case 6:
		case 13:
		case 15:
		case 19:
			enemyAbilities();
			// characterDM();
		break;
		//if none of the numbers above is called call the enemyDM function and characterDM function to do a critical or normal damage
		default:
			enemyDM();
			characterDM();
		break;
		}
}
//the damage dealt by the enemy 
	function enemyDM(){
		countChildren();
		damageEnemy();
		//generates a random number between 0 and the enemyCriticalChance if it is 1 and damage is above 0 do a critical hit
		var randomNumber = Math.floor((Math.random() * (enemyCriticalChance)));
		if ((randomNumber == 1) && damage > 0)  {
			damage = damage * 2;
		    HP = HP - damage;
			getElement("characterHP").innerHTML = HP + " Hitpoints";
			criticalD(damage);
			damageReceivedFromEnemy = damage;
			//if the number is not 1 do normal damage
		} else {
		    HP = HP - damage;
			getElement("characterHP").innerHTML = HP + " Hitpoints";
			damageD(damage);
			damageReceivedFromEnemy = damage;

		}
		death();
	}
	//the damage dealt by character
	function characterDM(){
		damageDealtToEnemy

		countChildren();
		myDamageDealt();
		//generates a random number between 0 and the criticalChance if it is 3 do a critical hit.
		var randomNumber = Math.floor((Math.random() * (criticalChance)));
		if (randomNumber == 3) {
			damage = damage * 2;
		    enemyHP = enemyHP - damage;
			getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";
			criticalR(damage);
			damageDealtToEnemy = damage;
		} else {
			//if the number is not 3 do a normal attack
			damage = random(baseDamage,attackSkillUp);
		    enemyHP = enemyHP - damage;
			getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";
			damageR(damage);
			damageDealtToEnemy = damage;
		}
		death();
	}	
	function death(){
		//if character HP is 0 or below you've died
		if (HP <= 0) {
			alert("You died");
			lost++;
			shuffleEnemyName();
			enemyLevel = randomEnemyLevel();
			wonDied();
		}
		//if the enemy HP is 0 or below the enemy has died
		if (enemyHP <= 0) {
			alert("You've won");
			win++;
			enemyLevelXP();
			if (xp >= xpNeeded) {
				level++;
				levelUp();
				getElement("level").innerHTML = "level " + level;
			}
			//gets a new enemyName and gives it a random level.
			shuffleEnemyName();
			enemyLevel = randomEnemyLevel();
			wonDied();
		} 
	}
//if characters HP or enemyHP has reached 0 or below reset particals of the game and clear the screen. 
function wonDied(){
		calcDamage();
		hitpoints();		
		getElement("winLose").innerHTML = "You have won " + win + " games<br>You have lost " + lost + " games";
		getElement("characterHP").innerHTML = HP + " Hitpoints";
		getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";
		getElement("charactersD").innerHTML = "";
		getElement("charactersR").innerHTML = "";
	}
//calculates based on the level of the enemy how many exp you will get if you've won
function enemyLevelXP() {
	if (enemyLevel < level) {
		xp += 1;
		XPBAR();
	}
	if (enemyLevel == level) {
		xp += 2;
		XPBAR();
	}
	if (enemyLevel > level){ 
		xp += 3;
		XPBAR();
	}
}
//if xpneeded is equal to the xp you'll be able to click on attack/strength or defence so you can level up that skill.
function levelUp() {
	baseDamage += 2;
	skillPoints++;
	getElement("skillPoints").innerHTML = "You have "  + skillPoints + "skillPoint(s)";
	getElement("skills_attack").style.cursor="pointer";
	getElement("skills_strength").style.cursor="pointer";
	getElement("skills_defence").style.cursor="pointer";
	xpNeeded = xpNeeded * 1.5;
}
getElement("skills_attack").onclick = function() {
	if (skillPoints > 0) {
		attackSkillUp ++;
		criticalChance--;			
		skillPoints--;
		getElement("skillPoints").innerHTML = "You have "  + skillPoints + "skillPoint(s)";
		getElement("attack").innerHTML = "attack level " + attackSkillUp;
		getElement("skills_attack").style.cursor="default";
		getElement("skills_strength").style.cursor="default";
		getElement("skills_defence").style.cursor="default";
	}
}
getElement("skills_strength").onclick = function() {
	if (skillPoints > 0) {
		skillPoints--;
		baseDamage++;
		strengthSkillUp++;
		getElement("skillPoints").innerHTML = "You have "  + skillPoints + "skillPoint(s)";
		getElement("strength").innerHTML = "strength level " + strengthSkillUp;
		getElement("skills_attack").style.cursor="default";
		getElement("skills_strength").style.cursor="default";
		getElement("skills_defence").style.cursor="default";
	}
}
getElement("skills_defence").onclick = function() {
	if (skillPoints > 0) {
		defenceSkillUp++;
		HP += 20;
		skillPoints--;
		getElement("skillPoints").innerHTML = "You have "  + skillPoints + "skillPoint(s)";
		getElement("defence").innerHTML = "defence level " + defenceSkillUp;
		getElement("characterHP").innerHTML = HP + " Hitpoints";
		getElement("skills_attack").style.cursor="default";
		getElement("skills_strength").style.cursor="default";
		getElement("skills_defence").style.cursor="default";
	}
}
//if at the beginning of the damage abilities is called (random number is equal to the number needed to run abilities).
//creates a random number from 0 to 4.
//all abilities have a number from 0 to 4 and if the number is equal to the number needed for that ability run that ability.
function abilities(){
	myDamageDealt();
	var thisNumber = Math.floor((Math.random() * 4));
	console.log(thisNumber + "this number");
	//var thisNumber = 3;
	switch(thisNumber) {
		case 0:
		case 1:
		case 3:
		case 4:
			enemyDM();
		break;
	}
	//increases the damage by 50%.
	if (thisNumber == 0){
		console.log("my damage");
		damageAbilitie = Math.round(damage + (damage * 0.50));
		enemyHP = enemyHP - damageAbilitie;
		getElementInnerHtml("charactersR", "pink", "dealt", damageAbilitie , "50% damage increased");
		getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";
	}
	//does a life steal ability, if the damage is 0 to 5 the lifesteal is 100%.
	//if the damage is 6 or above the lifesteal will be 50% of the damage dealt.
	if (thisNumber == 1) {
		if (damage <= 5) {
			HP += damage;
			getElementInnerHtml("charactersR", "red", "dealt", damage, "100% lifesteal");
		} else {
			HP += Math.round((damage * 0.50));
			getElementInnerHtml("charactersR", "red", "dealt", damage, "50% lifesteal");
		} 
		enemyHP = enemyHP - damage;
		getElement("characterHP").innerHTML = HP + " Hitpoints";
		getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";
	}
	if (thisNumber == 2){
		damageEnemy();
		if (damage >= 2) {
		defenceNumber = (Math.random() * (0.60 - 0.30) + 0.30).toFixed(2);
		damageNumber = Math.round(damage - (damage * defenceNumber));
		defenceNumber = Math.round(defenceNumber);
		defenceAbilityCharacter();		
		}
		else {
			defenceNumber = 1;
			damageNumber = Math.round(damage - (damage * defenceNumber));
			defenceAbilityCharacter();
		}
	}
	//runs the multistrike ability for the character (number 1)
	if (thisNumber == 3){
		multistrikeNumber = 1;
		multistrike();
		multistrike();
	}
	//increase damage ability.
	//generates a random number between 0.30 and 0.60 and multiplies that with the damage and add it to the regular damage.
	if (thisNumber == 4){
		var increaseDamageNumber = (Math.random() * (0.60 - 0.30) + 0.30).toFixed(2);
		var variable = Math.round(damage + (damage * increaseDamageNumber));
		enemyHP = enemyHP - variable;
		increaseDamageNumber =  Math.round((increaseDamageNumber * 100));
		getElementInnerHtml("charactersR", "orange", "dealt", variable, increaseDamageNumber + "% damage increase");
		getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";
	}
}
//if at the beginning of the damage abilities is called (random number is equal to the number needed to run abilities).
//creates a random number from 0 to 4.
//all abilities have a number from 0 to 4 and if the number is equal to the number needed for that ability run that ability.
function enemyAbilities(){
	damageEnemy();
	var thisNumber = Math.floor((Math.random() * 4));
	//var thisNumber = 3;
		switch(thisNumber) {
			case 0:
			case 1:
			case 3:
			case 4:
				characterDM();
			break;
		}

	//increases the damage by 50%.
	if (thisNumber == 0){
		damageAbilitie = damage + (damage * 0.50);
		HP = HP - damageAbilitie;
		getElementInnerHtml("charactersR", "pink", "dealt", damageAbilitie , "50% damage increased");
		getElement("characterHP").innerHTML = HP + " Hitpoints";
	}
	//does a life steal ability, if the damage is 0 to 5 the lifesteal is 100%.
	//if the damage is 6 or above the lifesteal will be 50% of the damage dealt.
	if (thisNumber == 1) {
		if (damage <= 5) {
			enemyHP += damage;
			getElementInnerHtml("charactersD", "red", "received", damage, "100% lifesteal");
		} else {
			enemyHP += Math.round((damage * 0.50));
			getElementInnerHtml("charactersD", "red", "received", damage, "50% lifesteal");
		} 
		HP = HP - damage;
		getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";
		getElement("characterHP").innerHTML = HP + " Hitpoints";
	}
	if (thisNumber == 2){
		myDamageDealt();
		if (damage >= 2) {
		defenceNumber = (Math.random() * (0.60 - 0.30) + 0.30).toFixed(2);
		damageNumber = Math.round(damage - (damage * defenceNumber));
		defenceAbilityEnemy();		
		}
		else {
			defenceNumber = 1;
			damageNumber = Math.round(damage - (damage * defenceNumber));
			defenceAbilityEnemy();
		}
	}
	//runs the multistrike ability for the enemy (number 2)
	if (thisNumber == 3){
		multistrikeNumber = 2;
		multistrike();
		multistrike();

	}
	if (thisNumber == 4){
		var increaseDamageNumber = (Math.random() * (0.60 - 0.30) + 0.30).toFixed(2);
		var variable = Math.round(damage + (damage * increaseDamageNumber));
		HP = HP - variable;
		increaseDamageNumber =  Math.round((increaseDamageNumber * 100));
		getElementInnerHtml("charactersD", "orange", "dealt", variable, increaseDamageNumber + "% damage increase");
		getElement("characterHP").innerHTML = HP + " Hitpoints";
	}
}
//does the normal damage but apart from the regular function so it's able to be called twice.
function multistrike(){
	if (multistrikeNumber == 1) {
		damage = random(baseDamage,attackSkillUp);
		enemyHP = enemyHP - damage;
		getElement("enemyHP").innerHTML = enemyHP + " Hitpoints";
		getElementInnerHtml("charactersR", "purple", "dealt", damage, "multistrike");
	} 
	if (multistrikeNumber == 2) {
		damageEnemy();
	    HP = HP - damage;
		getElement("characterHP").innerHTML = HP + " Hitpoints";
		getElementInnerHtml("charactersD", "purple", "received", damage, "multistrike");
	}
}
//if the amount lines of attacks is 10 or above, remove the first one.
function countChildren() {
	//creates a variable equal to the div
	var charactersD = getElement("charactersD");
	var charactersR = getElement("charactersR");

	//creates a variable that is equal to the length of the amount of attacks displayed on the screen
	var ElementscharactersD = childrenLength("charactersD");
	var ElementscharactersR = childrenLength("charactersR");

	//if the amount of attacks is 10 or above remove the first child.
	if (ElementscharactersD >= 10) {
		charactersD.removeChild(charactersD.firstChild);
	}
	if (ElementscharactersR >= 10) {
		charactersR.removeChild(charactersR.firstChild);
	}
}