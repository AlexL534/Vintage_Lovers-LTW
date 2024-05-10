<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../classes/message.class.php');


function drawUserQuestion(Session $session, PDO $db){
    $currentUserID=$session->getId();
    $questions = UserMessage::getQuestions($db,$currentUserID);?>
    <h3>
        Questions you asked
    </h3>
    <ul class = "questionsAsked">
    <?php foreach($questions as $questionDB){
        $rid=$questionDB['receiverID'];
        $pid=$questionDB['productID'];
        $receiver = User::getUser($db,intval($rid));
        $product = Product::getProduct($db,intval($pid)); ?>
        <a href="../pages/messages_page.php?sid=<?= $currentUserID?>&rid=<?=$rid ?>&pid=<?=$pid?>">
            <p>You asked User <?= htmlentities($receiver->getUserName());?> about the <?= htmlentities($product->getName()); ?></p>
        </a>
    <?php } ?>
    
    </ul>
<?php } ?>


<?php
function drawQuestionsToUser(Session $session, PDO $db){
    $currentUserID=$session->getId();
    $questions = UserMessage::getQuestionsForSeller($db,$currentUserID);?>
    <h3>
        Question other users have asked you
    </h3>
    <ul class = "questionsToUser">
    <?php foreach($questions as $questionDB){
        $sid=$questionDB['senderID'];
        $pid=$questionDB['productID'];
        $sender = User::getUser($db,intval($sid));
        $product = Product::getProduct($db,intval($pid)); ?>
        <a href="../pages/messages_page.php?sid=<?= $sid?>&rid=<?= $currentUserID?>&pid=<?=$pid?>">
            <p>User <?= htmlentities($sender->getUserName());?> asked about the <?= htmlentities($product->getName()); ?></p>
        </a>
    <?php } ?>
    
    </ul>
<?php } ?>

<?php
function drawInbox(Session $session, PDO $db){
    drawUserQuestion($session,$db);
    drawQuestionsToUser($session,$db);
}
?>

<?php
function drawMessages(PDO $db, int $rid , int $sid, int $pid, Session $session){ ?>
    <div id = "messages">
        <?php
        $messages = UserMessage::getMessages($sid,$rid,$pid,$db);
        foreach($messages as $message){ ?>
            <p class= <?= ($session->getId() === $sid) ? "sender" : "receiver" ?>><?= htmlentities($message->getText());?></p>
        <?php } ?>
    </div>
<?php } ?>

<?php
function drawProductInfo(int $pid, PDO $db){
    $product = Product::getProduct($db,$pid); ?>
    <div id="productInfo">
        
        <a href="../pages/product.php?id=<?= $pid ?>" id ="productName"><?= htmlentities($product->getName());?></a>
        <p id = "productPrice">Price: <?= $product->getPrice();?></p>
    </div>

<?php } ?>

<?php
function drawMessageForm(int $sid, int $rid, int $pid){ ?>
    <form>
        <input type="hidden" name = "senderID" value = "<?= $sid ?>">
        <input type="hidden" name = "receiverID" value = "<?= $rid ?>">
        <input type="hidden" name = "productID" value = "<?= $pid ?>">
        <input type="text" name = "messageText">
        <button formaction="../actions/action_send_message.php" formmethod="post" type="submit">Send</button>
    </form>
<?php } ?>

