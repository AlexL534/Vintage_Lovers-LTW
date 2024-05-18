<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../classes/message.class.php');


function drawUserQuestion(Session $session, PDO $db){
    $currentUserID=$session->getId();
    $questions = UserMessage::getQuestions($db,$currentUserID);
    $usersAlreadyShown=array();
    $productsAlreadyShown=array();?>
    <h3 id="inboxTitle">
        Your messages
    </h3>
    <?php if(empty($questions)){ ?>
        <p id="noMessages">You still haven't message anyone</p>
    <?php } ?>
    <ul class = "questions">
    <?php foreach($questions as $questionDB){
        
        $sid=$questionDB['senderID'];
        $rid=$questionDB['receiverID'];
        $pid=$questionDB['productID'];
        
        if(!isset($rid) && isset($sid) ){
            
            $rid = $sid;
        }
        
        if(in_array($rid,$usersAlreadyShown) && in_array($pid,$productsAlreadyShown)){
            continue;
        }
        $usersAlreadyShown[]=$rid;
        $productsAlreadyShown[]=$pid;
        $receiver = User::getUser($db,intval($rid));
        $product = Product::getProduct($db,intval($pid)); ?>
        <li><a href="../pages/messages_page.php?sid=<?= $currentUserID?>&rid=<?=$rid ?>&pid=<?=$pid?>">
            <p>You are having a conversation with <?= htmlentities($receiver->getUserName());?> about the <?= htmlentities($product->getName()); ?></p>
        </a></li>
    <?php } ?>
    
    </ul>
<?php } ?>




<?php
function drawInbox(Session $session, PDO $db){
    drawUserQuestion($session,$db);
    
}
?>

<?php
function drawMessages(PDO $db,int $pid, Session $session,int $rid){ ?>
    <section id="messagesPage">
        <div id = "UserMessages">
            <?php
            $messages = UserMessage::getMessages($session->getId(),$rid,$pid,$db);
            foreach($messages as $message){ ?>
                <p class= <?= ($session->getId() == $message->getSenderID()) ? "sender" : "receiver" ?>><?= htmlentities($message->getText());?></p>
            <?php } ?>
        </div>
<?php } ?>

<?php
function drawProductInfo(int $pid, PDO $db){
    $product = Product::getProduct($db,$pid);
     ?>
    <a href="/../pages/products.php?id=<?= $pid ?>" id="product_link">
        <article id="productInfoSmall">
            <p class= "product_name"><?= htmlentities($product->getName());?></p>
            
            <p class= "product_price">Price: <?= $product->getPrice();?></p>
        </article>
    </a>
    

<?php } ?>

<?php
function drawMessageForm(int $sid, int $rid, int $pid){ ?>
        <form id="messageForm">
            <input type="hidden" name = "senderID" value = "<?= $sid ?>">
            <input type="hidden" name = "receiverID" value = "<?= $rid ?>">
            <input type="hidden" name = "productID" value = "<?= $pid ?>">
            <input type="text" name = "messageText" placeholder ="Write your message here">
            <button>Send</button>
        </form>
    </section>
<?php } ?>

