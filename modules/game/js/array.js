var randomEnemyName = 
[
"sir douchebag", 
"Alabama Wanker",
"Charlie", 
"Morphius",
"Magot Mcglynn",
"Toby McQuire",
"Big Jeff " ,
"Bobby"  ,
"Jacque Butcher " ,
"Mana Moronta " ,
"Zachariah Zenon",  
"Susanne Skelton" , 
"Chi Clapper  ",
"Shonta Santana",  
"Lilia Litman " ,
"Chu Cantwell"  ,
"Alla Aldana"  ,
"Deandre Desimone" , 
"Adolfo Arzu",
"Santa's little bitch",
"Hannah Montana",
"Miley Cyrus",
"Barrack Obama",
"Putin",
"Geert Wilders",
"Rutte",
"Spacecowboy",
"Swekboy Michel",
"allahu akbar",
"Harde boi Dimitri",
"Hest hem ek wer",
"The chosen one",
"Hoerenloper",
"Golden Gurt",
"Barrack Osama",
"Romy",
"Roomkoe",
];

function shuffle(array) {
    var counter = array.length, temp, index;

    // While there are elements in the array
    while (counter > 0) {
        // Pick a random index
        index = Math.floor(Math.random() * counter);

        // Decrease counter by 1
        counter--;

        // And swap the last element with it
        temp = array[counter];
        array[counter] = array[index];
        array[index] = temp;
    }

    return array;
}
shuffle(randomEnemyName);

/*

abilities:

0 ~ Falcon pounch = +50% damage 3 turns.

*1 ~ Lifesteal = 1 tm 5 schade 100%, 5+ schade 50% heal.*

2 ~ shield = 3 beurten random tussen 30-60% defence.

3~ mtuli-strike = 2 hits snel achter elkaar. / dubbel hit.

4 ~ Boost = 3 beurten random tussen 30-60% meer damage.

*/