<?php

error_reporting(0);
date_default_timezone_set('America/Lima');

#REQUIRED FILES

    require_once('Functions.php');

#BOT TOKEN AND MY ID

    $My_ID = '1466851830'; #HERE GOES YOUR ID, VARIABLE NECESSARY TO ADD NEW USERS OR GROUPS.
    $botToken = '1863317709:AAH55mEVMdNySI9yKYtd9tihbaWU8uEjFCo'; #HERE YOU ADD THE BOT TOKEN.

#START CAPTURE OF VARIABLES SENT FROM THE CHAT

    $update = file_get_contents('php://input');
    $update = json_decode($update, true);
    $e = print_r($update);

    #DEFINING MESSAGE VARIABLES

    $chatId = $update["message"]["chat"]["id"];
    $userId = $update["message"]["from"]["id"];
    $firstname = $update["message"]["from"]["first_name"];
    $lastname = $update["message"]["from"]["last_name"];
    $username = $update["message"]["from"]["username"];
    $message = $update["message"]["text"];
    $message_id = $update["message"]["message_id"];
    $info = json_encode($update, JSON_PRETTY_PRINT);

#ADMIN PRIVILEGE CHECK

    if ($userId != $My_ID) {
        CheckAdmin($userId);
    }

#ADMIN COMMANDS

    #COMMAND TO ADD CHATS AND THEY CAN USE YOUR BOT, EXAMPLE /add 1466851830

    if (strpos($message, "!add") === 0 || strpos($message, "/add") === 0) {
        if ($userId != $My_ID && $Admin != true) {
            $message = "You are not authorized to add new users and/or groups.\nContact @KingProOficial.";
            SendMessage($chatId, $message, $message_id);
            exit();
        } elseif ($userId == $My_ID || $Admin == true) {
            $Add = substr($message, 5);
            AddChatID($Add);
            $message_admin = "✔️ The user was successfully added.";
            $message_user = "✔️ Permissions granted to use @NinjaKingChkBot.";
            SendMessage($chatId, $message_admin, $message_id);
            SendMessage($Add, $message_user, "");
            exit();
        }
    }

    #COMMAND TO RANK UP YOUR BOT, EXAMPLE /premium 1466851830

    if (strpos($message, "!premium") === 0 || strpos($message, "/premium") === 0) {
        if ($userId != $My_ID && $Admin != true) {
            $message = "You are not authorized to rank up users and/or groups.\nContact @KingProOficial.";
            SendMessage($chatId, $message, $message_id);
            exit();
        } elseif ($userId == $My_ID || $Admin == true) {
            $Add = substr($message, 9);
            PremiumChatID($Add);
            $message_admin = "✔️ Account upgraded to PREMIUM successfully.";
            $message_user = "✔️ Your account was upgraded to PREMIUM, enjoy your membership with @NinjaKingChkBot.";
            SendMessage($chatId, $message_admin, $message_id);
            SendMessage($Add, $message_user, "");
            exit();
        }
    }

    #COMMAND TO ADD ADMIN

    if (strpos($message, "!setadmin") === 0 || strpos($message, "/setadmin") === 0) {
        if ($userId != $My_ID) {
            $message = "You are not authorized to rank up users and/or groups.\nContact @KingProOficial.";
            SendMessage($chatId, $message, $message_id);
            exit();
        } elseif ($userId == $My_ID) {
            $Add = substr($message, 10);
            SetAdmin($Add);
            $message_admin = "✔️ Account updated to ADMINISTRATOR successfully.";
            $message_user = "✔️ Your account was upgraded to ADMINISTRATOR, enjoy your membership with @NinjaKingChkBot.";
            SendMessage($chatId, $message_admin, $message_id);
            SendMessage($Add, $message_user, "");
            exit();
        }
    }

    #COMMAND TO BAN USERS

    if (strpos($message, "!ban") === 0 || strpos($message, "/ban") === 0) {
        if ($userId != $My_ID && $Admin != true) {
            $message = "You are not authorized to suspend user accounts.\nContact @KingProOficial.";
            SendMessage($chatId, $message, $message_id);
            exit();
        } elseif ($userId == $My_ID || $Admin == true) {
            $Add = substr($message, 5);
            Ban($Add);
            $message_admin = "✔️ Account suspended successfully.";
            $message_user = "✔️ Your account was temporarily suspended, if you think it is a mistake contact @KingProOficial.";
            SendMessage($chatId, $message_admin, $message_id);
            SendMessage($Add, $message_user, "");
            exit();
        }
    }

    #COMMAND TO UNBAN USERS

    if (strpos($message, "!unban") === 0 || strpos($message, "/unban") === 0) {
        if ($userId != $My_ID && $Admin != true) {
            $message = "You are not authorized to unban user accounts.\nContact @KingProOficial.";
            SendMessage($chatId, $message, $message_id);
            exit();
        } elseif ($userId == $My_ID || $Admin == true) {
            $Add = substr($message, 7);
            Unban($Add);
            $message_admin = "✔️ The account was successfully reactivated.";
            $message_user = "✔️ Your account was activated again, enjoy @KingProOficial.";
            SendMessage($chatId, $message_admin, $message_id);
            SendMessage($Add, $message_user, "");
            exit();
        }
    }

    #COMMAND TO DELETE USERS

    if (strpos($message, "!delete") === 0 || strpos($message, "/delete") === 0) {
        if ($userId != $My_ID && $Admin != true) {
            $message = "You are not authorized to delete users and/or groups.\nContact @KingProOficial.";
            SendMessage($chatId, $message, $message_id);
            exit();
        } elseif ($userId == $My_ID || $Admin == true) {
            $Add = substr($message, 8);
            Delete($Add);
            $message_admin = "✔️ The user/group was deleted successfully.";
            $message_user = "✔️ You were removed from our Database\nContact @KingProOficial to request access again.";
            SendMessage($chatId, $message_admin, $message_id);
            SendMessage($Add, $message_user, "");
            exit();
        }
    }

#USER COMMANDS

    #START COMMAND

    if (strpos($message, "!start") === 0 || strpos($message, "/start") === 0) {
        $message = "‼️Hello, welcome to the best BOT checker ‼️\nAvailable commands are:\n/bin ⮞ BIN Information.\n/gen ⮞ Card Generator.\n/chk ⮞ CCs Check.\n✅ Have a good day!!!!";
        SendMessage($chatId, $message, $message_id);
        exit();
    }

    #INFO COMMAND

    if (strpos($message, "!info") === 0 || strpos($message, "/info") === 0) {
        $message = "ℹ️ INFO SERVICE:\nUsername: @$username\nUser ID: $userId\nChat/Group ID: $chatId";
        SendMessage($chatId, $message, $message_id);
        exit();
    }

    #COMMAND TO KNOW THE REMAINING TIME OF THE GROUP
    if (strpos($message, "!mygroup") === 0 || strpos($message, "/mygroup") === 0) {
        CheckChatID($chatId); #THIS FUNCTION CHECKS IF THE USER OR GROUP IS ADDED TO USE THE BOT.
        MyGroup($chatId);
        exit();
    }

    #COMMAND TO KNOW THE REMAINING TIME OF THE USER

    if (strpos($message, "!myacc") === 0 || strpos($message, "/myacc") === 0) {
        CheckChatID($chatId); #THIS FUNCTION CHECKS IF THE USER OR GROUP IS ADDED TO USE THE BOT.
        MyAccount($userId);
        exit();
    }

    #BINLOOKUP COMMAND /bin or !bin

    if (strpos($message, "!bin") === 0 || strpos($message, "/bin") === 0) {
        $Gateway = 'BIN Lookup'; #YOU SHOULD CHANGE THIS IF YOU USE ANOTHER COMMAND, LEAVE IT LIKE THIS FOR THE BIN ONE.
        $File = 'BinLookup.php'; #YOU MUST CHANGE THIS TO THE NAME OF YOUR NEW FILE IF YOU USE ANOTHER COMMAND.
        CheckChatID($chatId); #THIS FUNCTION CHECKS IF THE USER OR GROUP IS ADDED TO USE THE BOT.
        $Card = GetCard($message); #THIS FUNCTION IS USED TO GRAB THE CARD OUT OF THE COMMAND.
        QueryAPI($File, $Card); #THIS FUNCTION QUERIES THE API DEPENDING ON THE NAME OF THE FILE, IN THIS CASE "BinLookup.php".
        Response($Gateway, $Result, $Rank); #THIS FUNCTION IS USED TO VERIFY THE TYPE OF RESPONSE TO SEND TO THE USER.
        exit();
    }

    #CC CHECK COMMAND /chk or !chk

    if (strpos($message, "!chk") === 0 || strpos($message, "/chk") === 0) {
        $Gateway = 'Stripe Auth'; #YOU SHOULD CHANGE THIS IF YOU USE ANOTHER COMMAND FOR YOUR GATE NAME.
        $File = 'StripeAuth.php'; #YOU MUST CHANGE THIS TO YOUR API NAME.
        CheckChatID($chatId); #THIS FUNCTION CHECKS IF THE USER OR GROUP IS ADDED TO USE THE BOT
        Premium();
        $Card = GetCard($message); #THIS FUNCTION IS USED TO GRAB THE CARD OUT OF THE COMMAND.
        QueryAPI($File, $Card); #THIS FUNCTION QUERIES THE API DEPENDING ON THE NAME OF THE FILE, IN THIS CASE "BinLookup.php".
        Response($Gateway, $Result, $Rank); #THIS FUNCTION IS USED TO VERIFY THE TYPE OF RESPONSE TO SEND TO THE USER.
        exit();
    }

    #COMMAND TO GENERATE CCs /gen or !gen

    if (strpos($message, "!gen") === 0 || strpos($message, "/gen") === 0) {
        $Gateway = 'CC Generator'; #YOU SHOULD CHANGE THIS IF YOU USE ANOTHER COMMAND, LEAVE IT LIKE THIS FOR THE BIN ONE.
        $File = 'CardGenerator.php'; #YOU MUST CHANGE THIS TO THE NAME OF YOUR NEW FILE IF YOU USE ANOTHER COMMAND.
        CheckChatID($chatId); #THIS FUNCTION CHECKS IF THE USER OR GROUP IS ADDED TO USE THE BOT.
        $Card = GetCard($message); #THIS FUNCTION IS USED TO GRAB THE CARD OUT OF THE COMMAND.
        QueryAPI($File, $Card); #THIS FUNCTION QUERIES THE API DEPENDING ON THE NAME OF THE FILE, IN THIS CASE "BinLookup.php".
        Response($Gateway, $Result, $Rank); #THIS FUNCTION IS USED TO VERIFY THE TYPE OF RESPONSE TO SEND TO THE USER.
        exit();
    }
