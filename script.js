
//board
var blockSize = 22;
var rows = 22;
var cols = 22;
var board;
var context; 

//snake head
var snakeX = blockSize * 5;
var snakeY = blockSize * 5;

var velocityX = 0;
var velocityY = 0;

var snakeBody = [];

var snakeSpeed = 200;

//food
var foodX;
var foodY;

var superFoodX=-50;
var superFoodY=-50;

var gameOver = false;
var score = 0;
var foodEaten = 0;

var scoreElement;

var bestlogo = new Image();
bestlogo.src = "images/best_logo1.png";

window.onload = function() {
    board = document.getElementById("board");
    board.height = rows * blockSize;
    board.width = cols * blockSize;
    context = board.getContext("2d"); //used for drawing on the board

    scoreElement = document.getElementById("score");
    console.log(scoreElement.innerHTML);

    placeFood();
    document.addEventListener("keyup", changeDirection);
    update();
     //100 milliseconds
}

function update() {
    if (gameOver) {
        return;
    }
    
    context.fillStyle="black";
    context.fillRect(0, 0, board.width, board.height);

    //context.fillStyle="red";
    //context.fillRect(foodX, foodY, blockSize, blockSize);
    context.beginPath();
    context.arc(foodX+blockSize/2, foodY+blockSize/2, blockSize/2, 0, 2 * Math.PI);
    context.fillStyle = "red";
    context.fill();

    context.drawImage(bestlogo, superFoodX, superFoodY, blockSize*2, blockSize*2);

    if (snakeX == foodX && snakeY == foodY) {
        snakeBody.push([foodX, foodY]);
        foodEaten++;
        placeFood();
        snakeSpeed *= 0.95;
        score += 10;
        scoreElement.innerText = '' + score;
        console.log(snakeSpeed);
    }
    if ((snakeX==superFoodX || snakeX==superFoodX+blockSize) && (snakeY==superFoodY || snakeY==superFoodY+blockSize)){
        score += 20;
        scoreElement.innerText = '' + score;
        snakeBody.push([superFoodX, superFoodY]);
        superFoodX=-50;
        superFoodY=-50;
    }

    for (let i = snakeBody.length-1; i > 0; i--) {
        snakeBody[i] = snakeBody[i-1];
    }
    if (snakeBody.length) {
        snakeBody[0] = [snakeX, snakeY];
    }

    context.fillStyle="lime";
    snakeX += velocityX * blockSize;
    snakeY += velocityY * blockSize;
    context.fillRect(snakeX, snakeY, blockSize, blockSize);
    context.fillStyle="green";
    for (let i = 0; i < snakeBody.length; i++) {
        context.fillRect(snakeBody[i][0], snakeBody[i][1], blockSize, blockSize);
    }


    //game over conditions
    if (snakeX < 0) {
        snakeX = blockSize*(cols-1);      
    }else if(snakeX > (cols-1)*blockSize){
        snakeX = 0;
    }else if(snakeY < 0){
        snakeY = blockSize*(rows-1);
    }else if(snakeY > (rows-1)*blockSize){
        snakeY = 0;
    }

    for (let i = 0; i < snakeBody.length; i++) {
        if (snakeX == snakeBody[i][0] && snakeY == snakeBody[i][1]) {
            gameOver = true;
            alert("Game Over");
        }
    }
    setTimeout(update, snakeSpeed);
}

function changeDirection(e) {
    if (e.code == "ArrowUp" && velocityY != 1) {
        velocityX = 0;
        velocityY = -1;
    }
    else if (e.code == "ArrowDown" && velocityY != -1) {
        velocityX = 0;
        velocityY = 1;
    }
    else if (e.code == "ArrowLeft" && velocityX != 1) {
        velocityX = -1;
        velocityY = 0;
    }
    else if (e.code == "ArrowRight" && velocityX != -1) {
        velocityX = 1;
        velocityY = 0;
    }
}

function superFoodDisappear(){
    superFoodX=-50;
    superFoodY=-50;
}


function placeFood() {
    
    if(foodEaten%2==0 && foodEaten!=0 && superFoodX==-50){
        superFoodX = Math.floor(Math.random() * cols-1) * blockSize;
        superFoodY = Math.floor(Math.random() * rows-1) * blockSize;
        setTimeout(superFoodDisappear,5000);
    }
    //(0-1) * cols -> (0-19.9999) -> (0-19) * 25
    foodX = Math.floor(Math.random() * cols) * blockSize;
    foodY = Math.floor(Math.random() * rows) * blockSize;
}